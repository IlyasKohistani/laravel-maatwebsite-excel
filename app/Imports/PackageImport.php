<?php

namespace App\Imports;

use App\Models\Package;
use App\Models\Size;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PackageImport implements ToModel, WithHeadingRow, WithValidation
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
        $total_quantity = 0;
        foreach ($this->sizes as $key => $value) {
            $size_quantities[$key] = ['quantity' => intval($row[$value]) ?? 0];
            $total_quantity += (intval($row[$value]) ?? 0);
        }

        $package = new Package([
            'name'    => $row['name'],
            'total_quantity' => $total_quantity,
        ]);

        $package->save();
        $package->sizes()->attach($size_quantities);
        return $package;
    }

    public function rules(): array
    {   
        $rules = array_merge([
            'name' => 'required|max:255|unique:packages,name',
            'total_quantity' => 'required|integer',
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
