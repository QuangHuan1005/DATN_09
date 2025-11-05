<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_statuses')->upsert([
            ['id' => 1, 'name' => 'Chưa thanh toán',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Đang xử lý',            'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Đã thanh toán',         'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Hoàn tiền',             'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['name', 'updated_at']);
    }
}
