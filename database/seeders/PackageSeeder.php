<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->truncate();
        DB::table('package_quantity')->truncate();
        $packages = [
            [
                "id" => 1,
                "name" => "Small",
                "total_quantity" => 9,
            ],
            [
                "id" => 2,
                "name" => "Medium",
                "total_quantity" => 18,
            ],
            [
                "id" => 3,
                "name" => "Grand",
                "total_quantity" => 27,
            ],
        ];
        $package_quantity = [
            1 => [
                1 => [
                    "quantity" => 1
                ],

                2 => [
                    "quantity" => 1
                ],

                3 => [
                    "quantity" => 1
                ],

                4 => [
                    "quantity" => 1
                ],

                5 => [
                    "quantity" => 1
                ],

                6 => [
                    "quantity" => 1
                ],

                7 => [
                    "quantity" => 1
                ],

                8 => [
                    "quantity" => 1
                ],

                9 => [
                    "quantity" => 1
                ]
            ],
            2 => [
                1 => [
                    "quantity" => 2
                ],

                2 => [
                    "quantity" => 2
                ],

                3 => [
                    "quantity" => 2
                ],

                4 => [
                    "quantity" => 2
                ],

                5 => [
                    "quantity" => 2
                ],

                6 => [
                    "quantity" => 2
                ],

                7 => [
                    "quantity" => 2
                ],

                8 => [
                    "quantity" => 2
                ],

                9 => [
                    "quantity" => 2
                ]
            ],
            3 => [
                1 => [
                    "quantity" => 3
                ],

                2 => [
                    "quantity" => 3
                ],

                3 => [
                    "quantity" => 3
                ],

                4 => [
                    "quantity" => 3
                ],

                5 => [
                    "quantity" => 3
                ],

                6 => [
                    "quantity" => 3
                ],

                7 => [
                    "quantity" => 3
                ],

                8 => [
                    "quantity" => 3
                ],

                9 => [
                    "quantity" => 3
                ]
            ]
        ];
        foreach ($packages as $value) {
            $item =  Package::firstOrCreate($value);
            foreach ($package_quantity as $k => $value) {
                if ($k == $item->id)
                    $item->sizes()->attach($value);
            }
        }
    }
}
