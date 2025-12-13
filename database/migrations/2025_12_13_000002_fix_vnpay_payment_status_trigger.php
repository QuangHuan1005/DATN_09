<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop old triggers
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");

        // Tạo lại trigger BEFORE INSERT (giữ nguyên)
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

        // ✅ SỬA trigger BEFORE UPDATE để không ghi đè payment_status_id nếu đã thanh toán
        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bu
            BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                -- Chỉ tự động đồng bộ nếu:
                -- 1) order_status_id thay đổi
                -- 2) payment_status_id KHÔNG được application set rõ ràng (OLD = NEW)
                -- 3) ✅ VÀ payment_status_id cũ KHÔNG phải 'Đã thanh toán' (2) hoặc 'Hoàn tiền' (3)
                --    → Bảo vệ đơn VNPAY đã thanh toán khỏi bị ghi đè
                IF NEW.order_status_id != OLD.order_status_id 
                   AND NEW.payment_status_id = OLD.payment_status_id
                   AND OLD.payment_status_id NOT IN (2, 3) THEN
                    SET NEW.payment_status_id = CASE NEW.order_status_id
                        WHEN 1 THEN 1   -- Chờ xác nhận -> Chưa thanh toán
                        WHEN 2 THEN 1   -- Xác nhận -> Chưa thanh toán
                        WHEN 3 THEN 1   -- Đang giao hàng -> Chưa thanh toán
                        WHEN 4 THEN 2   -- Đá giao hàng -> Đã thanh toán
                        WHEN 5 THEN 2   -- Hoàn thành -> Đã thanh toán
                        WHEN 6 THEN OLD.payment_status_id   -- Hủy -> giữ nguyên
                        WHEN 7 THEN 3   -- Hoàn hàng -> Hoàn tiền
                        ELSE NEW.payment_status_id
                    END;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bi;");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_orders_sync_payment_status_bu;");
        
        // Restore old triggers from 2025_12_13_000001
        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bi
            BEFORE INSERT ON orders
            FOR EACH ROW
            BEGIN
                IF NEW.payment_status_id IS NULL OR NEW.payment_status_id = 0 THEN
                    SET NEW.payment_status_id = CASE NEW.order_status_id
                        WHEN 1 THEN 1
                        WHEN 2 THEN 1
                        WHEN 3 THEN 1
                        WHEN 4 THEN 2
                        WHEN 5 THEN 2
                        WHEN 6 THEN 1
                        WHEN 7 THEN 3
                        ELSE 1
                    END;
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_orders_sync_payment_status_bu
            BEFORE UPDATE ON orders
            FOR EACH ROW
            BEGIN
                IF NEW.order_status_id != OLD.order_status_id 
                   AND (NEW.payment_status_id = OLD.payment_status_id OR NEW.payment_status_id = 0) THEN
                    SET NEW.payment_status_id = CASE NEW.order_status_id
                        WHEN 1 THEN 1
                        WHEN 2 THEN 1
                        WHEN 3 THEN 1
                        WHEN 4 THEN 2
                        WHEN 5 THEN 2
                        WHEN 6 THEN OLD.payment_status_id
                        WHEN 7 THEN 3
                        ELSE NEW.payment_status_id
                    END;
                END IF;
            END
        ");
    }
};



