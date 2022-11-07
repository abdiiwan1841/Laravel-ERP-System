<?php

namespace App\Http\Controllers\ERP\Sales;

use App\Http\Controllers\Controller;
use App\Models\ERP\Purchases\Supplier;
use App\Models\ERP\Purchases\SupplierContact;
use App\Models\ERP\Sales\Client;
use App\Models\ERP\Sales\ClientContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class ClientsController extends Controller
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
            ["name" => trans('applang.sales') ],
            ["name" => trans('applang.clients') ],
        ];
        $clients = Client::all();

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        return view('erp.sales.clients.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'clients' => $clients,
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
            ["name" => trans('applang.sales') ],
            ["name" => trans('applang.clients') , "link" => route('clients.index')],
            ["name" => trans('applang.add_client')]
        ];

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        return view('erp.sales.clients.create')->with([
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
            'full_name'    => ['required', 'string', 'max:255'],
            'email'     => ['string', 'email', 'max:255', 'unique:suppliers,email'],
            'phone'     => ['numeric', 'unique:suppliers,phone'],
            'mobile'    => ['numeric', 'unique:suppliers,mobile'],
            'opening_balance' => ['numeric'],
            'opening_balance_date' => ['date', 'date_format:Y-m-d'],
        ]);
        $data = $request->all();
        $data['created_by'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        $client = Client::create($data);

        if($request->client_cont_first_name){
            foreach($request->client_cont_first_name as $key => $client_cont_first_name){
                $request->validate([
                    'client_cont_first_name.'.$key => ['string', 'max:255'],
                    'client_cont_last_name.'.$key => ['string', 'max:255'],
                    'client_cont_email.'.$key  => ['string', 'email', 'max:255', 'unique:client_contacts,client_cont_phone'],
                    'client_cont_phone.'.$key  => ['numeric', 'unique:client_contacts,client_cont_phone'],
                    'client_cont_mobile.'.$key  => ['numeric', 'unique:client_contacts,client_cont_mobile'],
                ]);
                $contactsData[] = [
//                    'client_id' => $client->id,
                    'client_id' => 2,
                    'client_cont_first_name' => $request->client_cont_first_name[$key],
                    'client_cont_last_name' => $request->client_cont_last_name[$key],
                    'client_cont_email' => $request->client_cont_email[$key],
                    'client_cont_phone' => $request->client_cont_phone[$key],
                    'client_cont_mobile' => $request->client_cont_mobile[$key],
                ];
            }

//            foreach ($contactsData as $contact){
//                ClientContact::create($contact);
//            }
            $client->contacts()->createMany($contactsData);
        }

        return redirect()->route('clients.index')->with('success', trans('applang.create_client_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sales') ],
            ["name" => trans('applang.clients') , "link" => route('clients.index')],
            ["name" => trans('applang.show_client')]
        ];

        $client = Client::with('contacts')->find($id);

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        return view('erp.sales.clients.show')->with([
            'breadcrumbs' => $breadcrumbs,
            'countries' => $countries,
            'currencies' => $currencies,
            'client' => $client
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sales') ],
            ["name" => trans('applang.clients') , "link" => route('clients.index')],
            ["name" => trans('applang.edit_client')]
        ];

        $client = Client::with('contacts')->find($id);

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        return view('erp.sales.clients.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'countries' => $countries,
            'currencies' => $currencies,
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'full_name'    => ['required', 'string', 'max:255'],
            'email'     => ['string', 'email', 'max:255', Rule::unique('clients','email')->ignore($client->id)],
            'phone'     => ['numeric', Rule::unique('clients','phone')->ignore($client->id)],
            'mobile'    => ['numeric', Rule::unique('clients','mobile')->ignore($client->id)],
            'opening_balance' => ['numeric'],
            'opening_balance_date' => ['date'],
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $client->update($data);

        if($request->contact_id){
            foreach($request->contact_id as $key=>$id){
                $request->validate([
                    'client_cont_first_name.'.$key => ['string', 'max:255'],
                    'client_cont_last_name.'.$key => ['string', 'max:255'],
                    'client_cont_email.'.$key  => ['string', 'email', 'max:255', Rule::unique('client_contacts','client_cont_email')->ignore($request->contact_id[$key])],
                    'client_cont_phone.'.$key  => ['numeric', Rule::unique('client_contacts','client_cont_phone')->ignore($request->contact_id[$key])],
                    'client_cont_mobile.'.$key  => ['numeric', Rule::unique('client_contacts','client_cont_mobile')->ignore($request->contact_id[$key])],
                ]);

                $contact = ClientContact::firstOrNew(['id'=> $request->contact_id[$key]]);
                $contact->client_cont_first_name = $request->client_cont_first_name[$key];
                $contact->client_cont_last_name = $request->client_cont_last_name[$key];
                $contact->client_cont_email = $request->client_cont_email[$key];
                $contact->client_cont_phone = $request->client_cont_phone[$key];
                $contact->client_cont_mobile = $request->client_cont_mobile[$key];
                $contact->client_id = $client->id;
                $contact->save();
            }
        }

        return redirect()->back()->with('success', trans('applang.edit_client_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->client_id;
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', trans('applang.delete_client_success'));
    }

    public function deleteClientContact(Request $request)
    {
        $contact = ClientContact::where('client_id' , $request->client_id)->first();
        $contact->delete();
        return redirect()->back()->with('success', trans('applang.delete_client_contact_success'));
    }

    public function editClientOpeningBalance(Request $request)
    {
        $id = $request->client_id;
        $client = Client::find($id);
        $client->update([
            'opening_balance' => $request->opening_balance,
            'opening_balance_date' => $request->opening_balance_date,
        ]);
        return redirect()->back()->with('success', trans('applang.edit_client_success'));
    }

    public function suspendClient(Request $request)
    {
        $id = $request->client_id;
        $client = Client::find($id);
        $client->update([
            'status' => 0
        ]);
        return redirect()->back()->with('success', trans('applang.edit_client_success'));
    }

    public function activateClient(Request $request)
    {
        $id = $request->client_id;
        $client = Client::find($id);
        $client->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success', trans('applang.edit_client_success'));
    }
}
