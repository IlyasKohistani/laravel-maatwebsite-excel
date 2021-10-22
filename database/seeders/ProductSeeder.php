<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        DB::table('product_quantity')->truncate();
        $products = [
            [
                'id' => 1,
                'sku' =>   100000,
                'name' =>   '76254 NAVY',
                'article_code' => 76250,
                'total_in_stock' => 930
            ],
            [
                'id' => 2,
                'sku' =>   100001,
                'name' =>   '76254 BLUE',
                'article_code' => 76251,
                'total_in_stock' => 600
            ],
            [
                'id' => 3,
                'sku' =>   100002,
                'name' =>   '76254 GREY',
                'article_code' => 76252,
                'total_in_stock' => 2030
            ],
        ];
        
        $product_quantity = [
            1 => [
                1 => [
                    "quantity" => 100
                ],

                2 => [
                    "quantity" => 200
                ],

                3 => [
                    "quantity" => 50
                ],

                4 => [
                    "quantity" => 60
                ],

                5 => [
                    "quantity" => 80
                ],

                6 => [
                    "quantity" => 100
                ],

                7 => [
                    "quantity" => 200
                ],

                8 => [
                    "quantity" => 100
                ],

                9 => [
                    "quantity" => 40
                ]
            ],
            2 => [
                1 => [
                    "quantity" => 40
                ],

                2 => [
                    "quantity" => 60
                ],

                3 => [
                    "quantity" => 200
                ],

                4 => [
                    "quantity" => 70
                ],

                5 => [
                    "quantity" => 30
                ],

                6 => [
                    "quantity" => 60
                ],

                7 => [
                    "quantity" => 40
                ],

                8 => [
                    "quantity" => 45
                ],

                9 => [
                    "quantity" => 55
                ]
            ],
            3 => [
                1 => [
                    "quantity" => 100
                ],

                2 => [
                    "quantity" => 200
                ],

                3 => [
                    "quantity" => 300
                ],

                4 => [
                    "quantity" => 320
                ],

                5 => [
                    "quantity" => 80
                ],

                6 => [
                    "quantity" => 90
                ],

                7 => [
                    "quantity" => 120
                ],
                8 => [
                    "quantity" => 220
                ],

                9 => [
                    "quantity" => 600
                ]
            ]
        ];

        foreach ($products as $value) {
            $item =  Product::firstOrCreate($value);
            foreach ($product_quantity as $k => $value) {
                if ($k == $item->id)
                    $item->sizes()->attach($value);
            }
        }
    }
}
