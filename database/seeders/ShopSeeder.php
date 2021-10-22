<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->truncate();
        $data = [
            [
                "id" => 1,
                "name" => "Istanbul"
            ],
            [
                "id" => 2,
                "name" => "Izmir"
            ],
            [
                "id" => 3,
                "name" => "Ankara"
            ],
        ];

        foreach ($data as $value) {
            Shop::firstOrCreate($value);
        }
    }
}
