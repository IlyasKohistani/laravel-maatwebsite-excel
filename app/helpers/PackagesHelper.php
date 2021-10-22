<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PackagesHelper
{
    public static function getNotLeftPackages($product_id){
        //we join package quantity and product quantity based on there size id and we calculate if this product has left item for any package in all sizes
        $not_left_packages = DB::table('package_quantity as paq')
                                ->join('product_quantity as prq', 'prq.size_id','=','paq.size_id')
                                ->select(['paq.package_id as package_id'])->where('prq.product_id',$product_id)
                                ->where(DB::raw('(prq.quantity - paq.quantity)'),'<',0)
                                ->groupBy('package_id')->get()
                                ->pluck('package_id');
        return $not_left_packages;
    }


    public static function getSubtracPackageFromProduct($product_id,$package_id){
        $subtract_result = DB::table('package_quantity as paq')
                                ->join('product_quantity as prq', 'prq.size_id','=','paq.size_id')
                                ->select(['prq.size_id as size_id',DB::raw('(prq.quantity - paq.quantity) as quantity')])
                                ->where('prq.product_id',$product_id)
                                ->where('paq.package_id',$package_id)
                                ->get();
        return $subtract_result;
    }
}
