<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Size;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
class ProductImport implements ToModel, WithHeadingRow, WithValidation
{

   
    protected $sizes = [];
    protected $size_rules = [];

    public function __construct()
    {
        $sizes = Size::select('id','name')->get()->toArray();
        foreach ($sizes as $value) {
            $name = strtolower(str_replace(['/',' '],['','_'],$value['name']));
            $this->sizes[$value['id']] = $name;
            $this->size_rules[$name] = 'required|integer|min:0';
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $size_quantities = [];
        $total_in_stock = 0;
        foreach ($this->sizes as $key => $value) {
            $size_quantities[$key] = ['quantity' => intval($row[$value]) ?? 0];
            $total_in_stock += (intval($row[$value]) ?? 0);
        }

        $product = new Product([
            'article_code' => $row['article_code'],
            'name'    => $row['name'],
            'sku' => $row['sku'],
            'total_in_stock' => $total_in_stock,
        ]);

        $product->save();
        $product->sizes()->attach($size_quantities);
        return $product;
    }

    public function rules(): array
    {   
        $rules = array_merge([
            'sku' => 'required|integer',
            'name' => 'required|max:255',
            'article_code' => 'required|integer|unique:products,article_code',
            'total_in_stock' => 'required|integer',
        ], $this->size_rules);

        return $rules;
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
