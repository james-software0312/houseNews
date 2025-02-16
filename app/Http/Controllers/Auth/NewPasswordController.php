<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $token = $request->token;

        $user = DB::table('password_reset_tokens')->where('token', '=', $token)->first();
        if ($user) {
            return view('auth.reset-password', compact('user'));
        } else
            return redirect()->route('login');
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'password' => ['required'],
        ]);
        $userbytoken = DB::table('password_reset_tokens')->where(['token' => $request->token])->first();
        if (!$userbytoken) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $userbytoken->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['token' => $request->token])->delete();
        // Mail::send('emails.confirmation', [], function ($message) use ($userbytoken) {
        //     $message->to($userbytoken->email);
        //     $message->subject(__('frontend.password_changed'));
        // });
        return view('auth.confirm-password');
    }
}
