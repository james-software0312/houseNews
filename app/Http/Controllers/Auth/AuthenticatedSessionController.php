<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\UserVerificationToken;

class AuthenticatedSessionController extends Controller
{
    protected $providers = [
        'google',
        'facebook',
        'linkedin'
    ];
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login_act(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // Check if user is admin
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
                    return redirect()->route('verify.email', ['email' => $request->email]);
                    // return back()->with('error', "Your account is not verified !");
                }
            } else {
                return back()->with('error', "Your account is inactive !");
            }
        } else {
            return back()->with('error', "Credentials do not match !");
        }

        if (!Auth::attempt($credentials)) {
            return back()->with('error', __('frontend.Credentials_donot_match'));
        }

        return redirect()->route('login');
    }

    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }


    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty($user->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse()
    {
        return redirect()->intended('dashboard');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->email)->first();

        // if user already found
        if ($user) {
            // update the avatar and provider that might have changed
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
            // login the user
            Auth::login($user, true);

            // return $this->sendSuccessResponse();
            return redirect()->route('dashboard');
        } else {

            $user = User::create([
              'first_name' => $providerUser->name,
              'last_name' => "",
              'email' => $providerUser->email,
              'password' => "password",
              'avatar' => $providerUser->avatar,
              'provider' => $driver,
              'provider_id' => $providerUser->id,
              'access_token' => $providerUser->token,
              'status' => '1',
              'is_verified' => '1',
              'is_admin' => '0',
            ]);
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

}
