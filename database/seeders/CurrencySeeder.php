<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['code' => 'лв', 'name' => 'Армянский драм', 'symbol' => '֏'],
            ['code' => 'AZN', 'name' => 'Азербайджанский манат', 'symbol' => '₼'],
            ['code' => 'BYN', 'name' => 'Белорусский рубль', 'symbol' => 'р.'],
            ['code' => 'BRL', 'name' => 'Бразильский реал', 'symbol' => '$'],
            ['code' => 'HUF', 'name' => 'Венгерский форинт', 'symbol' => 'Ft'],
            ['code' => 'VND', 'name' => 'Вьетнамский донг', 'symbol' => '₫'],
            ['code' => 'USD', 'name' => 'Доллар', 'symbol' => '$'],
            ['code' => 'AED', 'name' => 'Дирхам', 'symbol' => 'Dh'],
            ['code' => 'EUR', 'name' => 'Евро', 'symbol' => '€'],
            ['code' => 'ILS', 'name' => 'Израильский шекель', 'symbol' => '₪'],
            ['code' => 'INR', 'name' => 'Индийская рупия', 'symbol' => '₹'],
            ['code' => 'YER', 'name' => 'Риал', 'symbol' => '﷼'],  // Added Rial
            ['code' => 'RUB', 'name' => 'Российский рубль', 'symbol' => '₽'],
            ['code' => 'KZT', 'name' => 'Казахстанский тенге', 'symbol' => '₸'],
            ['code' => 'KHR', 'name' => 'Камбоджийский риель', 'symbol' => '៛'], // Added Cambodian Riel
            ['code' => 'KGS', 'name' => 'Киргизский сом', 'symbol' => 'с'],
            ['code' => 'KRW', 'name' => 'Корейская вона', 'symbol' => '₩'],
            ['code' => 'CNY', 'name' => 'Китайский юань', 'symbol' => '¥'],
            ['code' => 'MYR', 'name' => 'Малайзийский ринггит', 'symbol' => 'RM'], // Added Malaysian Ringgit
            ['code' => 'MNT', 'name' => 'Монгольский тугрик', 'symbol' => '₮'],
            ['code' => 'PLN', 'name' => 'Польский злотый', 'symbol' => 'zł'],
            ['code' => 'GBP', 'name' => 'Фунт', 'symbol' => '£'],
            ['code' => 'THB', 'name' => 'Тайландский бат', 'symbol' => '฿'],
            ['code' => 'TRY', 'name' => 'Турецкая лира', 'symbol' => '₺'],
            ['code' => 'TMT', 'name' => 'Туркменский манат', 'symbol' => 'm'],
            ['code' => 'UAH', 'name' => 'Украинская гривна', 'symbol' => '₴'],
            ['code' => 'UZS', 'name' => 'Узбекский сум', 'symbol' => 'so`m'],
            ['code' => 'IDR', 'name' => 'Индонезийская рупия', 'symbol' => 'Rp'], // Added Indonesian Rupiah
            ['code' => 'PKR', 'name' => 'Пакистанская рупия', 'symbol' => '₨'], // Added Pakistani Rupee
        ];

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['code' => $currency['code']], $currency);
        }
    }
}
