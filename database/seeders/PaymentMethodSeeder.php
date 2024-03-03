<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'KBZ Pay',
                'description' => 'Payment method description',
            ],
            [
                'name' => 'Wave Pay',
                'description' => 'Payment method description',
            ],
            [
                'name' => 'AYA Pay',
                'description' => 'Payment method description',
            ],
        ];

        DB::table('payment_methods')->insert($methods);
    }
}
