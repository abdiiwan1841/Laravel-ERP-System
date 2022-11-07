<?php

namespace App\Http\Controllers\ERP\Settings\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.settings') ],
            ["name" => trans('applang.products_settings'), "link" => route('productsSettings') ],
            ["name" => trans('applang.categories') ],
        ];
        return view('erp.settings.products.categories.index')->with([
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
