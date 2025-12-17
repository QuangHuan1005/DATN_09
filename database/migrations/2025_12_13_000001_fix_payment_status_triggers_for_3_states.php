<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Xóa trigger cũ
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");

        // Tạo lại trigger với logic 3 trạng thái: 1=Chưa thanh toán, 2=Đã thanh toán, 3=Hoàn tiền
        // Trigger này chỉ tự động set payment_status_id khi application CHƯA set
        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bi
            BEFORE INSERT ON orders
            FOR EACH ROW
            BEGIN
                -- Chỉ tự động set nếu payment_status_id = NULL hoặc = 0
                IF NEW.payment_status_id IS NULL OR NEW.payment_status_id = 0 THEN
                    SET NEW.payment_status_id = CASE NEW.order_status_id
                        WHEN 1 THEN 1   -- Chờ xác nhận -> Chưa thanh toán
                        WHEN 2 THEN 1   -- Xác nhận -> Chưa thanh toán
                        WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                        WHEN 4 THEN 2   -- Đã giao hàng -> Đã thanh toán
                        WHEN 5 THEN 2   -- Hoàn thành -> Đã thanh toán
                        WHEN 6 THEN 1   -- Hủy -> Chưa thanh toán (giữ nguyên)
                        WHEN 7 THEN 3   -- Hoàn hàng -> Hoàn tiền
                        ELSE 1          -- Default: Chưa thanh toán
                    END;
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bu
            BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                -- Chỉ tự động đồng bộ nếu:
                -- 1) order_status_id thay đổi
                -- 2) payment_status_id KHÔNG được application set rõ ràng (OLD = NEW hoặc = 0)
                IF NEW.order_status_id != OLD.order_status_id 
                   AND (NEW.payment_status_id = OLD.payment_status_id OR NEW.payment_status_id = 0) THEN
                    SET NEW.payment_status_id = CASE NEW.order_status_id
                        WHEN 1 THEN 1   -- Chờ xác nhận -> Chưa thanh toán
                        WHEN 2 THEN 1   -- Xác nhận -> Chưa thanh toán
                        WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                        WHEN 4 THEN 2   -- Đã giao hàng -> Đã thanh toán (nếu chưa thanh toán)
                        WHEN 5 THEN 2   -- Hoàn thành -> Đã thanh toán
                        WHEN 6 THEN OLD.payment_status_id   -- Hủy -> giữ nguyên trạng thái cũ
                        WHEN 7 THEN 3   -- Hoàn hàng -> Hoàn tiền
                        ELSE NEW.payment_status_id
                    END;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");
    }
};



