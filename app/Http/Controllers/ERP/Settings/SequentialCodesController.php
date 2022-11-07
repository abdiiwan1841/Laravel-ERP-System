<?php

namespace App\Http\Controllers\ERP\Settings;

use App\Http\Controllers\Controller;
use App\Models\ERP\Settings\SequentialCode;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class SequentialCodesController extends Controller
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
            ["name" => trans('applang.settings')],
            ["name" => trans('applang.sequential_codes')],
        ];
        $seq_codes = SequentialCode::all();

        return view('erp.settings.sequential-codes.index', compact(['breadcrumbs', 'seq_codes']));
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
            ["name" => trans('applang.sequential_codes'), "link" => route('sequential-codes.index')],
            ["name" => trans('applang.seq_code_add') ]
        ];
        $rejected = [
            'failed_jobs',
            'password_resets',
            'personal_access_tokens',
            'permissions',
            'roles',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'permissions_categories',
            'translated_permissions',
            'translated_roles',
            'sequential_numbers',
            'migrations',
            'jobs',
            'sequential_codes',
        ];
        $tables = DB::select('SHOW TABLES');
        $db = "Tables_in_".env('DB_DATABASE');
        return view('erp.settings.sequential-codes.create',compact(['tables', 'db', 'rejected', 'breadcrumbs']));
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
            'prefix' => 'required|unique:sequential_codes,prefix',
            'numbers_length' => 'required|numeric|digits_between:1,2',
            'model'  => 'required|unique:sequential_codes,model',
        ]);

        SequentialCode::create([
            'prefix'   => $request->prefix,
            'numbers_length' => $request->numbers_length,
            'model'   => $request->model,
        ]);

        return redirect()->route('sequential-codes.index')->with('success', trans('applang.seq_code_created_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $code = SequentialCode::find($id);
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.sequential_codes')],
            ["name" => trans('applang.seq_code_edit') ]
        ];
        $rejected = [
            'failed_jobs',
            'password_resets',
            'personal_access_tokens',
            'permissions',
            'roles',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'permissions_categories',
            'translated_permissions',
            'translated_roles',
            'sequential_numbers',
            'migrations',
            'jobs',
            'sequential_codes',
        ];
        $tables = DB::select('SHOW TABLES');
        $db = "Tables_in_".env('DB_DATABASE');
        return view('erp.settings.sequential-codes.edit',compact(['tables', 'db', 'rejected', 'breadcrumbs', 'code']));
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
        $code = SequentialCode::find($id);
        $request->validate([
            'prefix' => ['required', Rule::unique('sequential_codes','prefix')->ignore($id)],
            'numbers_length' => 'required|numeric|digits_between:1,2',
        ]);

        $data = $request->all();
        $code->update($data);

        return redirect()->route('sequential-codes.index')->with('success', trans('applang.seq_code_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
/*    public function destroy(Request $request)
    {
        $id = $request->seq_code_id;
        $seqCode = SequentialCode::where('id', $id);
        $seqCode->delete();
        return redirect()->route('sequential-codes.index')->with('success', trans('applang.seq_code_deleted_successfully'));
    }*/

/*    public function deleteSelectedSeqCodes(Request $request)
    {
        $ids = $request->ids;
        SequentialCode::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Sequential Code deleted successfully'
        ],200);
    }*/
}
