<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           [ 'name' => 'Dollars', 'currency_symbol' => '$', 'currency_code' => 'USD', 'created_at' => now()],
           [ 'name' => 'Rupee', 'currency_symbol' => '₹', 'currency_code' => 'INR', 'created_at' => now()]
        ];

        Currency::insert($data);
    }
}
