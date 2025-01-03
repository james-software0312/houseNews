<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerificationToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskDetail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rule =
            [
                'firstname' => 'required|string|max:20',
                'lastname' => 'required|string|max:20',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];
        $error_msg = [
            'firstname.required' => __('Please fill in the field'),
            'lastname.required' => __('Please fill in the field'),
            'email.required' => __('Please fill in the field'),
            'email.email' => __('Email must be a valid email address'),
            'password.required' => __('Please fill in the field'),
            'password.min' => __('Password should be minium 8 characters'),
        ];

        $request->validate($rule, $error_msg);

        // $task = TaskDetail::leftJoin('tasks', 'tasks.id', '=', 'task_details.task_id')
        // ->where('task_details.guest_email', $request->email)->first();
        // if(!$task){
        //     return redirect()->back()->withErrors(['email' => 'This email is not an invited email. Please use the correct email.']);
        // }

        $user = User::where('email', $request->email)->where('is_deleted', 0)->first();
        $credentials = $request->only('email', 'password');
        if ($user) {
            if ($user->status) {
                if ($user->is_verified) {
                    if (Auth::attempt($credentials)) {
                        return redirect()->route('dashboard');
                    } else {
                        return back()->with('error', "Credentials do not match !");
                    }
                } else if (!$user->is_verified) {
                    // return redirect()->route('verify.email', ['email' => $request->email]);
                    return back()->with('error', "Your account is not verified !");
                }
            } else {
                return back()->with('error', "Your account is inactive !");
            }
        } else {
            return back()->with('error', "Credentials do not match !");
        }

        $user = User::create([
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => '1',
            'is_verified' => '0',
            'is_admin' => '0',
        ]);

        $token = Str::random(64);

        UserVerificationToken::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $details = [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'token' => $token,
            'email' => $user->email
        ];

        Mail::send('emails.verify', ['details' => $details], function ($message) use ($user) {
          $message->to($user->email);
          $message->subject(__('IMPORTANT, verification of your email address'));
        });
        // dispatch(new \App\Jobs\VerifyEmailJob($details));
        // Auth::attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);
        return redirect()->route('verify.email', ['email' => $request->email]);
    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    public function verify_email(Request $request)
    {
        if(!isset($request->email)){
            return redirect()->route('login');
        }
        return view('auth.verify-email',['email'=>$request->email]);
    }
    public function resentEmail(Request $request){

        if(isset($request->email)){
            $user = User::where('email', $request->email)->where('is_verified','0')->first();
            if(isset($user)){
                $token = Str::random(64);
                UserVerificationToken::where('user_id', $user->id)->delete();
                UserVerificationToken::create([
                    'user_id' => $user->id,
                    'token' => $token
                ]);

                $details = [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'token' => $token,
                    'email' => $user->email
                ];
                Mail::to($user->email)->send(new \App\Mail\VerifyEmail($details));
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($token)
    {
        $verifyUser = UserVerificationToken::where('token', $token)->first();

        $message = 'Sorry your e-mail cannot be identified.';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_verified) {
                $user->is_verified = 1;
                $user->email_verified_at = Carbon::now();
                $user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
            Auth::login($user);
        }
        return redirect()->route('login')->with('error', $message);
    }

}
