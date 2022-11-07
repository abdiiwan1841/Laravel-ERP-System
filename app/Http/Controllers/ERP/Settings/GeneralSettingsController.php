<?php

namespace App\Http\Controllers\ERP\Settings;

use App\Http\Controllers\Controller;
use App\Models\ERP\Settings\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use LaravelLocalization;

class GeneralSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.general_settings')],
        ];

        // Read File

        $countriesString = file_get_contents(base_path('public/app-assets/data/countries_ar.json'));
        $countries = json_decode($countriesString, true);

        $timezoneString = file_get_contents(base_path('public/app-assets/data/timezones.json'));
        $timezones = json_decode($timezoneString, true);
//        dd(timezone_identifiers_list());

        $currencyString = file_get_contents(base_path('public/app-assets/data/currency-symbols.json'));
        $currencies = json_decode($currencyString, true);

        if(GeneralSetting::count() > 0){
            $gs = GeneralSetting::first();
            return view('erp.settings.general-settings.create', compact(['breadcrumbs', 'countries', 'timezones', 'currencies', 'gs']));
        }else{
            return view('erp.settings.general-settings.create', compact(['breadcrumbs', 'countries', 'timezones', 'currencies']));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric'],
            'mobile' => ['required', 'numeric'],
            'fax' => ['required', 'numeric'],
            'phone_code' => ['required'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'numeric'],
            'country' => ['required', 'string', 'max:255'],
            'commercial_record' => ['required', 'string', 'max:255'],
            'tax_registration' => ['required', 'string', 'max:255'],
            'time_zone' => ['required', 'string', 'max:255'],
            'basic_currency' => ['required'],
            'basic_currency_symbol' => ['required'],
            'extra_currencies' => ['required'],
            'language' => ['required', 'string', 'max:255'],
            'logo' => ['image']
        ]);

        $data = $request->all();

        if(GeneralSetting::count() > 0){
            $gs = GeneralSetting::first();
            if($request->logo){
                if($gs->logo != 'defaultLogo.png'){
                    //delete old logo image
                    Storage::disk('public_uploads')->delete('/logo_image//'.$gs->logo);
                }

                //create new logo image
                Image::make($request->logo)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/logo_image/'.$request->logo->hashName()));

                $data['logo'] = $request->logo->hashName();
            }



            if($request->reset === 'hidden-reset' && empty($request->logo)){
                Storage::disk('public_uploads')->delete('/logo_image//'.$gs->logo);
                $data['logo'] = 'defaultLogo.png';
            }

            //keep old image if not change on it on update
            if (empty($request->logo) && $gs->logo!='defaultLogo.png'){
/*                Storage::disk('public_uploads')->delete('/logo_image//'.$gs->logo);
                $data['logo'] = 'defaultLogo.png';*/
                $request->logo = $gs->logo;
            }

            $gs->update($data);

            //change language
            Config::set(['app.locale' => $request->language]);
            $locale = LaravelLocalization::setLocale($request->language);
            $url = LaravelLocalization::getLocalizedURL($locale, null, [], true);

            //change timezone
            Config::set(['app.timezone' => $request->time_zone]);
            date_default_timezone_set($request->time_zone);
//            dd(date_default_timezone_get());
//            dd(now());

            return redirect($url)->with('success', trans('applang.gs_updated_successfully'));

        }else{

            if($request->logo){
                //create new logo image
                Image::make($request->logo)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/logo_image/'.$request->logo->hashName()));

                $data['logo'] = $request->logo->hashName();
            }

            GeneralSetting::create($data);

            //change language
            Config::set(['app.locale' => $request->language]);
            $locale = LaravelLocalization::setLocale($request->language);
            $url = LaravelLocalization::getLocalizedURL($locale, null, [], true);

            //change timezone
            Config::set(['app.timezone' => $request->time_zone]);
            date_default_timezone_set($request->time_zone);

            return redirect($url)->with('success', trans('applang.gs_added_successfully'));
        }
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
