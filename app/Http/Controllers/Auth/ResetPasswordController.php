<?php

namespace App\Http\Controllers\Auth;

use App\Employee;
use App\Http\Controllers\Controller;
use App\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $user = Employee::where('official_email', $request->official_email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        $reset = PasswordReset::where('email', $request->official_email)->delete();

        return redirect()->route('login')->with('success', 'Password updated successfully');
    }

    public function showResetForm($token, Request $request)
    {
        $reset = PasswordReset::where('token', $token)->first();
        if ($reset != '') {
            return view('auth.passwords.reset')->with('email', $request->email)->with('token', $token);
        } else {
            abort(403);
        }
    }
}
