<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
//        $currencies = [
//            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$'],
//            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€'],
//            ['name' => 'Kazakhstani Tenge', 'code' => 'KZT', 'symbol' => '₸'],
//        ];
//
//        foreach ($currencies as $currency) {
//            Currency::updateOrCreate(['code' => $currency['code']], $currency);
//        }
        Currency::factory()->count(2)->create();
    }
}
