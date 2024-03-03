<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'payment_method_id' => 1,
                'account_name' => 'Aung Kaung',
                'account_number' => '098765456543',
            ],
            [
                'payment_method_id' => 1,
                'account_name' => 'Myat Paing',
                'account_number' => '098765456543',
            ],
            [
                'payment_method_id' => 2,
                'account_name' => 'Aung Paing',
                'account_number' => '098765456543',
            ],
            [
                'payment_method_id' => 3,
                'account_name' => 'Myat Kaung',
                'account_number' => '098765456543',
            ],
        ];

        DB::table('payment_accounts')->insert($accounts);
    }
}
