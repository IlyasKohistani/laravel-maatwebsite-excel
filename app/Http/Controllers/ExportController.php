<?php

namespace App\Http\Controllers;

use App\Exports\ProductsSampleExport;
use App\Exports\ShopDetailsExport;
use App\Models\Package;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    /**
     * This will export a product excel sample file
     *
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function productsSample()
    {
        return Excel::download(new ProductsSampleExport, 'products_sample.xlsx');
    }


    /**
     * This will export a shop detailed excel file
     *
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function shopDetails(Shop $shop_id)
    {
        return Excel::download(new ShopDetailsExport($shop_id->id), 'shop_details.xlsx');
    }

     /**
     * This will export all shops detailed excel file
     *
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function allShopDetails()

    {
        return Excel::download(new ShopDetailsExport('ALL'), 'all_shop_details.xlsx');
    }
}
