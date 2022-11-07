<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::DASHBOARD;
    protected $maxAttempts = 3; //Default 5
    protected $decayMinutes = 5; //Default 1

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     * Check if the login by email or phone to return username
     * @return string
     */
    public function username()
    {
        $value = request()->input('email');
        $field = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone' ;
        request()->merge([$field => $value]);
        return $field;
    }

    protected function credentials(Request $request)
    {
        if($request->has('phone')){
            $email = User::where('phone', $request->phone)->pluck('email');
            return ['phone' => $request->phone,'email' => $email, 'password' => $request->password ,'status' => 1];
        }else{
            return ['email' => $request->email, 'password' => $request->password, 'status' => 1];
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && Hash::check($request->password, $user->password) && $user->status != 1) {
            $errors = [$this->username() => trans('auth.not_active')];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

}
