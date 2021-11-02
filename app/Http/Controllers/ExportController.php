<?php

namespace App\Http\Controllers;

use App\Exports\PackageTemplateExport;
use App\Exports\ProductTemplateExport;
use App\Exports\ShopDetailsExport;
use App\Exports\ShopTemplateExport;
use App\Models\Shop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    /**
     * This will export an excel file based on requested type
     *
     * @param   Request
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function export(Request $request)
    {
        switch ($request->type) {
            case 'All_Shop_Details':
                return Excel::download(new ShopDetailsExport('ALL'), 'all_shop_details.xlsx');
                break;
            case 'Product_Template':
                return Excel::download(new ProductTemplateExport, 'products_template.xlsx');
                break;
            case 'Package_Template':
                return Excel::download(new PackageTemplateExport, 'package_template.xlsx');
                break;
            case 'Shop_Template':
                return Excel::download(new ShopTemplateExport, 'shop_template.xlsx');
                break;
            default:
                return Excel::download(new ShopDetailsExport('ALL'), 'all_shop_details.xlsx');
                break;
        }
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
}
