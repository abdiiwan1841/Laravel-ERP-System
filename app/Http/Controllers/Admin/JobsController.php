<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Stichoza\GoogleTranslate\GoogleTranslate;

class JobsController extends Controller
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
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.jobs') ]
        ];
        // $permissions = Permission::all();
        $jobs = Job::all();
        return view('admin.jobs.index')->with([
            'breadcrumbs' => $breadcrumbs,
            'jobs' => $jobs,
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
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.jobs'), "link" => route('jobs.index') ],
            ["name" => trans('applang.create_job') ]
        ];
        return view('admin.jobs.create')->with([
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
            'name_en' => 'required|unique:jobs,name_en',
            'name_ar' => 'required|unique:jobs,name_ar',
        ]);

        Job::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar
        ]);

        return redirect()->route('jobs.index')->with('success', trans('applang.job_created_successfully'));
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
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.jobs'), "link" => route('jobs.index') ],
            ["name" => trans('applang.edit_job') ]
        ];
        $job = Job::find($id);
        return view('admin.jobs.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'job' => $job,
        ]);
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
            'name_en' => 'required',
            'name_ar' => 'required'
        ]);
        $job = Job::find($id);
        $job->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en
        ]);
        return redirect()->route('jobs.index')->with('success', trans('applang.job_edited_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->job_id;
        $job = Job::where('id', $id)->first();
        $job->delete();
        return redirect()->route('jobs.index')->with('success', trans('applang.job_deleted_successfully'));
    }

    public function deleteSelectedJobs(Request $request)
    {
        $ids = $request->ids;
        Job::whereIn('id', $ids)->delete();
        return Response::json([
            'success' => true,
            'message' => 'Job deleted successfully'
        ],200);
    }

    public function translateJob($job)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.jobs'), "link" => route('jobs.index') ],
            ["name" => trans('applang.create_job') ]
        ];

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($job);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($job);

        return view('admin.jobs.create')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en
        ]);
    }

    public function translateEditJob($id)
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.authontication')],
            ["name" => trans('applang.jobs'), "link" => route('jobs.index') ],
            ["name" => trans('applang.edit_job') ]
        ];

        $editedJobId = explode('/', url()->previous())[6];
        // $editedRole = Role::where('id', $editedroleId)->first();

        $job = Job::where('id', $editedJobId)->first();

        $tr = new GoogleTranslate(); // Translates to 'en' from auto-detected language by default
        $translated_ar = $tr->setSource('en')->setTarget('ar')->translate($id);
        $translated_en = $tr->setSource('ar')->setTarget('en')->translate($id);

        return view('admin.jobs.edit')->with([
            'breadcrumbs' => $breadcrumbs,
            'translated_ar' => $translated_ar,
            'translated_en' => $translated_en,
            'editedJobId' => $editedJobId,
            'job'     => $job,
        ]);
    }
}
