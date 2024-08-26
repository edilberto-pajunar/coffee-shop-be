<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        Voucher::create([
            'code' => 'COFFEE10',
            'discount_percentage' => 10,
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'usage_limit' => 100,
        ]);

        Voucher::create([
            'code' => 'FLAT50',
            'discount_amount' => 50,
            'min_spend' => 200,
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'usage_limit' => 50,
        ]);
    }
}
