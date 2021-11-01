<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PackagesHelper
{
    public static function getNotLeftPackages($product_id)
    {
        //we join package quantity and product quantity based on there size id and we calculate if this product has left item for any package in all sizes
        $not_left_packages = DB::table('package_quantity as paq')
            ->join('product_quantity as prq', 'prq.size_id', '=', 'paq.size_id')
            ->select(['paq.package_id as package_id'])->where('prq.product_id', $product_id)
            ->where(DB::raw('(prq.quantity - paq.quantity)'), '<', 0)
            ->groupBy('package_id')->get()
            ->pluck('package_id');
        return $not_left_packages;
    }


    public static function getSubtractPackageFromProduct($product_id, $package_id)
    {
        $subtract_result = DB::table('package_quantity as paq')
            ->join('product_quantity as prq', 'prq.size_id', '=', 'paq.size_id')
            ->select(['prq.size_id as size_id', DB::raw('(prq.quantity - paq.quantity) as quantity')])
            ->where('prq.product_id', $product_id)
            ->where('paq.package_id', $package_id)
            ->get();
        return $subtract_result;
    }

    /**
     * return a detailed list of all packages with products item assigned to shops.
     *
     * @param  Array|Integer|String $SHOP_ID
     * @return Array
     */
    public static function getShopPackageProducts($shop_id = 'ALL')
    {
        if (!is_array($shop_id) && !is_string($shop_id)) $shop_id = [$shop_id];
        $result =  DB::table('package_shop as ps')
            ->join('shops as s', 's.id', '=', 'ps.shop_id')
            ->join('packages as pa', 'ps.package_id', '=', 'pa.id')
            ->join('products as pr', 'ps.product_id', '=', 'pr.id')
            ->select(['s.id as shop_id', 's.name as shop_name', 'pa.name as package_name', 'pa.total_quantity as package_product_quantity', 'ps.package_id as package_id', 'pr.name as product_name', 'pr.article_code as article_code', DB::raw('count(*) as total_packages')]);

        if (!is_string($shop_id)) $result = $result->whereIn('ps.shop_id', $shop_id);

        $result =  $result->groupBy(['s.id', 's.name', 'package_name', 'package_id', 'product_name', 'article_code', 'package_product_quantity'])
            ->get();

        return $result;
    }
}
