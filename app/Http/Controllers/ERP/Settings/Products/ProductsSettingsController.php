<?php

namespace App\Http\Controllers\ERP\Settings\Products;

use App\Http\Controllers\Controller;
use App\Models\ERP\Settings\Products\Brand;
use App\Models\ERP\Settings\Products\Category;
use App\Models\ERP\Settings\Products\Section;
use App\Models\ERP\Settings\Products\SubCategory;
use Illuminate\Http\Request;

class ProductsSettingsController extends Controller
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
            ["name" => trans('applang.products_settings') ],
        ];
        $sections = Section::all();
        $brands = Brand::all();
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('erp.settings.products.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'sections'  => $sections,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands'        => $brands
        ]);
    }
}
