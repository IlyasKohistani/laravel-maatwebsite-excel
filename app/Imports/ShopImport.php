<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShopImport implements ToModel, WithHeadingRow, WithValidation
{


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $shop = new Shop([
            'name'    => $row['name'],
        ]);

        $shop->save();
        return $shop;
    }

    public function rules(): array
    {   
        return [
            'name' => 'required|max:255|unique:shops,name',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [];
    }


    public function headingRow(): int
    {
        return 1;
    }
}
