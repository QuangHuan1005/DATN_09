<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 2.1) Đồng bộ dữ liệu cũ: map payment_status_id theo order_status_id
        DB::statement("
            UPDATE orders
            SET payment_status_id = CASE order_status_id
                WHEN 1 THEN 1   -- Chờ xác nhận      -> Chưa thanh toán
                WHEN 2 THEN 1   -- Xác nhận    -> Đang xử lý
                WHEN 3 THEN 1   -- Đang giao hàng -> Đang xử lý
                WHEN 4 THEN 2   -- Đã giao hàng -> Đang xử lý
                WHEN 5 THEN 3   -- Hoàn thành  -> Đã thanh toán
                WHEN 6 THEN 5   -- Hủy  -> Hoàn tiền
                WHEN 7 THEN 5   -- Hoàn hàng  -> Hoàn tiền
                ELSE payment_status_id
            END
        ");

        // 2.2) Xóa trigger cũ (nếu đã tồn tại) để tránh lỗi redeclare
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");

        // 2.3) BEFORE INSERT: gán NEW.payment_status_id theo NEW.order_status_id
        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bi
            BEFORE INSERT ON orders
            FOR EACH ROW
            BEGIN
                SET NEW.payment_status_id = CASE NEW.order_status_id
                    WHEN 1 THEN 1   -- Chờ xác nhận      -> Chưa thanh toán
                    WHEN 2 THEN 1   -- Xác nhận    -> Chưa thanh toán
                    WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                    WHEN 4 THEN 2   -- Đã giao hàng -> Đang xử lý
                    WHEN 5 THEN 3   -- Hoàn thành  -> Đã thanh toán
                    WHEN 6 THEN 5   -- Hủy  -> Hoàn tiền
                    WHEN 7 THEN 5   -- Hoàn hàng  -> Hoàn tiền
                    ELSE NEW.payment_status_id
                END;
            END
        ");

        // 2.4) BEFORE UPDATE: mỗi lần đổi order_status_id thì cập nhật payment_status_id tương ứng
        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bu
            BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                -- Đồng bộ theo order_status_id mới
                SET NEW.payment_status_id = CASE NEW.order_status_id
                    WHEN 1 THEN 1   -- Chờ xác nhận      -> Chưa thanh toán
                    WHEN 2 THEN 1   -- Xác nhận    -> Chưa thanh toán
                    WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                    WHEN 4 THEN 2   -- Đã giao hàng -> Đang xử lý
                    WHEN 5 THEN 3   -- Hoàn thành  -> Đã thanh toán
                    WHEN 6 THEN 5   -- Hủy  -> Hoàn tiền
                    WHEN 7 THEN 5   -- Hoàn hàng  -> Hoàn tiền
                    ELSE NEW.payment_status_id
                END;
            END
        ");
    }

    public function down(): void
    {
        // Gỡ trigger khi rollback
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");
        // Không rollback dữ liệu mapped vì có thể đã dùng thực tế
    }
};
