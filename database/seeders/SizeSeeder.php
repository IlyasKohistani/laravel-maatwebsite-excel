<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->truncate();
        $data = [
            [
                "id" => 1,
                "name" => "S"
            ],
            [
                "id" => 2,
                "name" => "M"
            ],
            [
                "id" => 3,
                "name" => "M/L"
            ],
            [
                "id" => 4,
                "name" => "L"
            ],
            [
                "id" => 5,
                "name" => "L/XL"
            ],
            [
                "id" => 6,
                "name" => "XL"
            ],
            [
                "id" => 7,
                "name" => "2XL"
            ],
            [
                "id" => 8,
                "name" => "3XL"
            ],
            [
                "id" => 9,
                "name" => "4XL"
            ]
        ];

        foreach ($data as $value) {
            Size::firstOrCreate($value);
        }
    }
}
