<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EditUserAccountInfoController extends Controller
{
    /**
     * Show the user account info page for edit.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $breadcrumbs = [
            ["name" => trans('applang.dashboard'), "link" => route('dashboard')],
            ["name" => trans('applang.my_account') ]
        ];
        return view('auth.appAuth.edit-user-account-info')->with([
            'user' => auth()->user(),
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function updateNameEmail(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->user()->id],
        ]);

        $data = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];

        auth()->user()->update($data);

        return redirect()->route('users.index')->with('success', trans('applang.update_user_success'));
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
          ]);

          if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('success', trans('applang.password_update_success'));

          } else {
              return back()->withErrors(['error' => trans('applang.current_password_not_match')]);
          }

    }
}
