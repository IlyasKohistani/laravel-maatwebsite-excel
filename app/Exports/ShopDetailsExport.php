<?php

namespace App\Exports;

use App\Helpers\PackagesHelper;
use App\Models\Package;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class ShopDetailsExport implements FromCollection, WithTitle, WithHeadings, WithStrictNullComparison
{
    protected $shop_id;

    public function __construct($shop_id)
    {
        $this->shop_id = $shop_id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'ShopDetails';
    }

    public function headings(): array
    {
        $sizes = Size::all()->pluck('name')->toArray();
        return array_merge([
            'Shop ID',
            'Shop',
            'Product',
            'Article Code',
            'Package',
            'Total Packages',
            'Total Products',
        ], $sizes);
    }

    public function collection()
    {
        $data =  PackagesHelper::getShopPackageProducts($this->shop_id);
        $packages = Package::with('sizes:id,name')->select(['id', 'name'])->get()->toArray();
        $results = [];
        foreach ($data as $value) {
            $package = collect($packages)->where('id', $value->package_id)->first();
            $package_sizes = array_column($package['sizes'], 'pivot');
            $package_sizes = array_map(function ($el) use ($value) {
                return $el['quantity'] * $value->total_packages;
            }, $package_sizes);
            $sub_item = [
                'shop_id' => '#' . $value->shop_id,
                'shop_name' => $value->shop_name,
                'product_name' => $value->product_name,
                'article_code' => $value->article_code,
                'package_name' => $value->package_name,
                'total_packages' => $value->total_packages,
                'total_package_product_quantity' => $value->package_product_quantity * $value->total_packages,
            ];

            $results[] = array_merge($sub_item, array_combine(array_column($package['sizes'], 'name'), $package_sizes));
        }
        return collect($results);
    }
}
