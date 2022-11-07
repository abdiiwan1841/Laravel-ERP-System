<?php

namespace App\Http\Controllers\ERP\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ERP\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Picqer;

class ProductsController extends Controller
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
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.inventory') ],
            ["name" => trans('applang.products') ],
        ];
        return view('erp.inventory.products.index')->with([
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.inventory') ],
            ["name" => trans('applang.products'), "link" => route('products.index')],
            ["name" => trans('applang.create_product')],
        ];
        return view('erp.inventory.products.create')->with([
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products','name')],
            'description' => ['required', 'string', 'max:255'],
            'section_id' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'subcategory_id' => ['sometimes'],
            'unit_template_id' => ['required'],
            'measurement_unit_id' => ['required'],
            'supplier_id' => ['required'],
            'purchase_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'first_tax_id' => ['required'],
            'second_tax_id' => ['sometimes'],
            'lowest_sell_price' => ['required', 'numeric'],
            'discount' => ['numeric'],
            'discount_type' => ['sometimes'],
            'profit_margin' => ['sometimes'],
            'lowest_stock_alert' => ['required', 'numeric'],
            'notes' => ['string', 'max:255'],
            'status' => ['required'],
            'sku' => ['required', Rule::unique('products','sku')],
            'product_image' => ['image']
        ]);

        $data = $request->all();

        //create new product_image image
        if($request->product_image){
            Image::make($request->product_image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/images/'.$request->product_image->hashName()));

            $data['product_image'] = $request->product_image->hashName();
        }

        //create product barcode image
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        file_put_contents('uploads/products/barcodes/'.$request->sku.'.jpg', $generator->getBarcode($request->sku, $generator::TYPE_CODE_128, 3, 50));
        $data['barcode'] = $request->sku . '.jpg';

        Product::create($data);
        return redirect(route('products.index'))->with('success', trans('applang.product_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.inventory') ],
            ["name" => trans('applang.products'), "link" => route('products.index')],
            ["name" => trans('applang.show_product')],
        ];
        return view('erp.inventory.products.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'product'   => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.inventory') ],
            ["name" => trans('applang.products'), "link" => route('products.index')],
            ["name" => trans('applang.edit_product')],
        ];
        return view('erp.inventory.products.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'product'   => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products','name')->ignore($product->id)],
            'description' => ['required', 'string', 'max:255'],
            'section_id' => ['required'],
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'subcategory_id' => ['sometimes'],
            'unit_template_id' => ['required'],
            'measurement_unit_id' => ['required'],
            'supplier_id' => ['required'],
            'purchase_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric'],
            'first_tax_id' => ['required'],
            'second_tax_id' => ['sometimes'],
            'lowest_sell_price' => ['required', 'numeric'],
            'discount' => ['numeric'],
            'discount_type' => ['sometimes'],
            'profit_margin' => ['sometimes'],
            'lowest_stock_alert' => ['required', 'numeric'],
            'notes' => ['string', 'max:255'],
            'status' => ['required'],
            'sku' => ['required', Rule::unique('products','sku')->ignore($product->id)],
            'product_image' => ['image']
        ]);

        $data = $request->all();

        //update product_image image
        if($request->product_image){
            if($product->product_image != 'defaultProduct.png'){
                //delete old product image
                Storage::disk('public_uploads')->delete('/products/images//'.$product->product_image);
            }
            //create new product_image image
            Image::make($request->product_image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/images/'.$request->product_image->hashName()));

            $data['product_image'] = $request->product_image->hashName();
        }
        //keep old image if not change on it on update
        if (is_null($request->product_image) && $product->product_image != 'defaultProduct.png'){
            $data['product_image'] = $product->product_image;
        }elseif(is_null($request->product_image) && $product->product_image == 'defaultProduct.png'){
            $data['product_image'] = 'defaultProduct.png';
        }

        if($request->sku != '' && $request->sku != $product->sku) {
            //delete old barcode image
            if($product->barcode != ''){
                $barcode_path = public_path() . '/uploads/products/barcodes/' . $product->barcode;
                unlink($barcode_path);
            }
            //create product barcode image
            $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
            file_put_contents('uploads/products/barcodes/'.$request->sku.'.jpg', $generator->getBarcode($request->sku, $generator::TYPE_CODE_128, 3, 50));
            $data['barcode'] = $request->sku . '.jpg';
        }

        $product->update($data);
        return redirect(route('products.index'))->with('success', trans('applang.product_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
