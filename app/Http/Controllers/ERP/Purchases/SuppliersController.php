<?php

namespace App\Http\Controllers\ERP\Purchases;

use App\Http\Controllers\Controller;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\SupplierContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class SuppliersController extends Controller
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
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.suppliers') ],
        ];
        $suppliers = Supplier::all();

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        return view('erp.purchases.suppliers.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'suppliers' => $suppliers,
            'countries'   => $countries
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
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.suppliers'), "link" => route('suppliers.index') ],
            ["name" => trans('applang.add_supplier')],
        ];
        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        return view('erp.purchases.suppliers.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'countries' => $countries,
            'currencies' => $currencies
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
            'commercial_name' => ['required', 'string', 'max:255'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'     => ['string', 'email', 'max:255', 'unique:suppliers,email'],
            'phone'     => ['required', 'numeric', 'unique:suppliers,phone'],
            'mobile'    => ['numeric', 'unique:suppliers,mobile'],
            'fax'       => ['numeric', 'unique:suppliers,fax'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'currency' => ['required'],
            'opening_balance' => ['required', 'numeric'],
            'opening_balance_date' => ['required', 'date', 'date_format:Y-m-d'],
            'status' => ['required'],
        ]);
        $data = $request->all();
        $data['created_by'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        $supplier = Supplier::create($data);

        if($request->supp_cont_first_name){
            foreach($request->supp_cont_first_name as $key=>$supp_cont_first_name){
                $request->validate([
                    'supp_cont_first_name.'.$key => ['required','string', 'max:255'],
                    'supp_cont_last_name.'.$key => ['required', 'string', 'max:255'],
                    'supp_cont_email.'.$key  => ['required', 'string', 'email', 'max:255', 'unique:supplier_contacts,supp_cont_phone'],
                    'supp_cont_phone.'.$key  => ['required', 'numeric', 'unique:supplier_contacts,supp_cont_phone'],
                    'supp_cont_mobile.'.$key  => ['required', 'numeric', 'unique:supplier_contacts,supp_cont_mobile'],
                ]);

                $contactsData[] = [
                    'supplier_id' => $supplier->id,
                    'supp_cont_first_name' => $request->supp_cont_first_name[$key],
                    'supp_cont_last_name' => $request->supp_cont_last_name[$key],
                    'supp_cont_email' => $request->supp_cont_email[$key],
                    'supp_cont_phone' => $request->supp_cont_phone[$key],
                    'supp_cont_mobile' => $request->supp_cont_mobile[$key],
                ];
            }

            foreach ($contactsData as $contact){
                SupplierContact::create($contact);
            }
        }

        return redirect()->route('suppliers.index')->with('success', trans('applang.create_supplier_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.suppliers') , "link" => route('suppliers.index') ],
            ["name" => $supplier->commercial_name .' '.'( # '.$supplier->full_code.')'],
        ];

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        return view('erp.purchases.suppliers.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'countries'   => $countries,
            'supplier'  => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.inventory_purchases')],
            ["name" => trans('applang.purchases') ],
            ["name" => trans('applang.suppliers'), "link" => route('suppliers.index') ],
            ["name" => trans('applang.edit_supplier')],
        ];
        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        return view('erp.purchases.suppliers.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'countries' => $countries,
            'currencies' => $currencies,
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'commercial_name' => ['required', 'string', 'max:255'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'     => ['string', 'email', 'max:255', Rule::unique('suppliers','email')->ignore($supplier->id)],
            'phone'     => ['required', 'numeric', Rule::unique('suppliers','phone')->ignore($supplier->id)],
            'mobile'    => ['numeric', Rule::unique('suppliers','mobile')->ignore($supplier->id)],
            'fax'       => ['numeric', Rule::unique('suppliers','fax')->ignore($supplier->id)],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'currency' => ['required'],
            'opening_balance' => ['required', 'numeric'],
            'opening_balance_date' => ['required', 'date'],
            'status' => ['required'],
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $supplier->update($data);

        if($request->contact_id){
            foreach($request->contact_id as $key=>$id){
                $request->validate([
                    'supp_cont_first_name.'.$key => ['required', 'string', 'max:255'],
                    'supp_cont_last_name.'.$key => ['required','string', 'max:255'],
                    'supp_cont_email.'.$key  => ['required','string', 'email', 'max:255', Rule::unique('supplier_contacts','supp_cont_email')->ignore($request->contact_id[$key])],
                    'supp_cont_phone.'.$key  => ['required', 'numeric', Rule::unique('supplier_contacts','supp_cont_phone')->ignore($request->contact_id[$key])],
                    'supp_cont_mobile.'.$key  => ['required', 'numeric', Rule::unique('supplier_contacts','supp_cont_mobile')->ignore($request->contact_id[$key])],
                ]);

                $contact = SupplierContact::firstOrNew(['id'=> $request->contact_id[$key]]);
                $contact->supp_cont_first_name = $request->supp_cont_first_name[$key];
                $contact->supp_cont_last_name = $request->supp_cont_last_name[$key];
                $contact->supp_cont_email = $request->supp_cont_email[$key];
                $contact->supp_cont_phone = $request->supp_cont_phone[$key];
                $contact->supp_cont_mobile = $request->supp_cont_mobile[$key];
                $contact->supplier_id = $supplier->id;
                $contact->save();
            }
        }

        return redirect()->route('suppliers.index')->with('success', trans('applang.edit_supplier_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->supplier_id;
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', trans('applang.delete_supplier_success'));
    }

    public function deleteSelectedSuppliers(Request $request)
    {
        $ids = $request->ids;
        Supplier::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'supplier deleted successfully'
        ],200);
    }

    public function deleteSupplierContact(Request $request)
    {
        $contact = SupplierContact::where('supplier_id' , $request->supplier_id)->first();
        $contact->delete();
        return redirect()->back()->with('success', trans('applang.delete_supplier_contact_success'));
    }

    public function editSupplierOpeningBalance(Request $request)
    {
        $id = $request->supplier_id;
        $supplier = Supplier::find($id);
        $supplier->update([
            'opening_balance' => $request->opening_balance,
            'opening_balance_date' => $request->opening_balance_date,
        ]);
        return redirect()->back()->with('success', trans('applang.edit_supplier_success'));
    }

    public function suspendSupplier(Request $request)
    {
        $id = $request->supplier_id;
        $supplier = Supplier::find($id);
        $supplier->update([
            'status' => 0
        ]);
        return redirect()->back()->with('success', trans('applang.edit_supplier_success'));
    }

    public function activateSupplier(Request $request)
    {
        $id = $request->supplier_id;
        $supplier = Supplier::find($id);
        $supplier->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success', trans('applang.edit_supplier_success'));
    }
}
