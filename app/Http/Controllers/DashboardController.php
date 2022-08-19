<?php

namespace App\Http\Controllers;

use App\Helpers\PackagesHelper;
use App\Models\Package;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Size::all()->count())
            session()->now('popupMessage', 'No data available at the moment.');


        $shops = Shop::select(['id', 'name'])->get();
        $products = Product::select(['id', 'article_code', 'name'])->get();
        if (count($products) > 0) $packages =  $this->availablePackages($products[0]['id']);
        if (count($shops) > 0) $shop_packages =   $this->shopAllProductPackages(1);


        return view('layouts.shop_packages', ['shops' => $shops, 'products' => $products, 'packages' => $packages ?? [], 'shop_packages' => $shop_packages ?? []]);
    }

    /**
     * Show the available packages for an item.
     *
     * @return \Illuminate\Http\Response
     */
    public function availablePackages($product_id)
    {
        Product::findOrFail($product_id);
        $not_left_package_ids = PackagesHelper::getNotLeftPackages($product_id);
        return Package::with(['sizes'])->whereNotIn('id', $not_left_package_ids)->get();
    }


    /**
     * Show all product with packages for specific shop.
     *
     * @return \Illuminate\Http\Response
     */
    public function shopAllProductPackages($shop_id)
    {
        Shop::findOrFail($shop_id);
        return DB::table('package_shop as ps')
            ->join('packages as pa', 'ps.package_id', '=', 'pa.id')
            ->join('products as pr', 'ps.product_id', '=', 'pr.id')
            ->select(['pa.name as package_name', 'pr.name as product_name', DB::raw('count(*) as total_packages')])
            ->where('ps.shop_id', $shop_id)
            ->groupBy('package_name')
            ->groupBy('product_name')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate all requested items
        $request->validate([
            'shop_id' => 'required|integer|exists:shops,id',
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $not_left_packages_ids = PackagesHelper::getNotLeftPackages($request->product_id);
        $request->validate([
            'package_id' => ['required', 'integer', 'exists:packages,id', Rule::notIn($not_left_packages_ids)],
        ]);

        try {
            DB::beginTransaction();


            //get shop, product and package item
            $shop = Shop::find($request->shop_id);
            $product = Product::with(['sizes'])->find($request->product_id);
            $package = Package::find($request->package_id);

            //get result that will be after subtracting this package from the product sizes
            $subtracted_results = PackagesHelper::getSubtractPackageFromProduct($request->product_id, $request->package_id);
            $product_quantity_result = [];

            //update product quantity left in the store
            foreach ($subtracted_results as  $value) {
                if ($value->quantity < 0) abort(422, 'Invalid Data.');
                $product_quantity_result[$value->size_id] = ['quantity' => $value->quantity];
            }
            $product->sizes()->syncWithoutDetaching($product_quantity_result);

            //attach new product package to the shop
            $shop->products()->attach([$request->product_id => ['package_id' => $request->package_id]]);

            //update product all 
            $product->total_in_stock = $product->total_in_stock - $package->total_quantity;
            $product->save();

            DB::commit();

            $packages =  $this->availablePackages($request->product_id);
            return $packages;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }
}
