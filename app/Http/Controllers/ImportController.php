<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportGeneralRequest;
use App\Imports\PackageImport;
use App\Imports\ProductImport;
use App\Imports\ShopImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('import');
    }


    /**
     * Import excel file records.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(ImportGeneralRequest $request)
    {
        try {
            switch ($request->type) {
                case 1:
                    Excel::import(new ShopImport, request()->file('file'));
                    break;
                case 2:
                    Excel::import(new ProductImport, request()->file('file'));
                    break;
                case 3:
                    Excel::import(new PackageImport, request()->file('file'));
                    break;
            }
            return 'ok';
        } catch (ValidationException $e) {
            $failure = $e->failures()[0];
            $message =  $failure->errors()[0] . ' On row number ' . $failure->row() . '.';
            return Response(['message'=>$message], 422);
        }
    }
}
