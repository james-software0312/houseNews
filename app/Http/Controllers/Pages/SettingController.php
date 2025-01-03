<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Helper;
use App\Models\User;
use App\Models\Declarant;

class SettingController extends Controller
{

    public function index()
    {
      $user = Auth::user();
      $my_declarant = Declarant::where('user_id', $user->id)->where('is_owned', 1)->first();
      return view('content.setting.account', ['user' => $user,'my_declarant' => $my_declarant]);
    }
    public function security()
    {
      $user = Auth::user();
      return view('content.setting.security', ['user'=>$user]);
    }

    public function update(Request $request)
    {
      $user = Auth::user();
      // Handle the avatar upload
      if ($request->hasFile('avatar')) {

        if (!file_exists(public_path('storage/avatars'))) {
          mkdir(public_path('storage/avatars'), 0755, true);
        }

        $file = $request->file('avatar');
        $path = $file->store('avatars', 'public');

        if ($user->avatar && file_exists(public_path($user->avatar))) {
          unlink(public_path($user->avatar));
        }
        $user->avatar = asset('storage/' . $path);
        $user->save();
      }
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->birthday = Helper::format_date_for_db($request->input('birthday'));
      $user->birth_city = $request->input('birth_city');
      $user->birth_country = $request->input('birth_country');
      $user->address = $request->input('address');
      $user->pec_email = $request->input('pec_email');
      $user->save();
      if($request->is_owned == 'on'){
        $my_declarant = Declarant::where('user_id', $user->id)->where('is_owned', 1)->first();
        $ownerData = [
          'first_name'    => $request->input('first_name'),
          'last_name'     => $request->input('last_name'),
          'birthday'      => Helper::format_date_for_db($request->input('birthday')),
          'birth_city'    => $request->input('birth_city'),
          'birth_country' => $request->input('birth_country'),
          'address'       => $request->input('address'),
          'pec_email'     => $request->input('pec_email'),
          'avatar'        => $user->avatar,
          'user_id'       => $user->id,
          'is_owned'      => 1,
        ];
        $myDeclarant = Declarant::where('user_id', $user->id)->where('is_owned', 1)->first();

        if ($myDeclarant) $myDeclarant->update($ownerData);
        else Declarant::create($ownerData);
      }

      return redirect()->back()->with('success', 'Account updated successfully.');
    }
    public function updatePassword(Request $request)
    {
      $user = Auth::user();
      if($user->password != "password")
      if (!Hash::check($request->currentPassword, $user->password)) {
          return back()->withErrors(['currentPassword' => 'The Current Password is incorrect.']);
      }
      $user->password = Hash::make($request->newPassword);
      $user->save();
      return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Send OTP to the user's email
     */
    public function sendOTP(Request $request)
    {
      $user = Auth::user();
      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
      ]);

      if ($validator->fails()) {
          return response()->json(['error' => $validator->errors()], 422);
      }

      $existedEmail = User::where('email', $request->email)->where('id', '!=' ,$user->id)->first();

      if ($existedEmail) {
        return response()->json(["success" => false, 'message' => "Your email is used by another user"], 200);
      }

      $email = $request->email;

      // Generate a 6-digit OTP
      $otp = random_int(100000, 999999);

      session([$email . '_otp' => $otp]);

      Mail::mailer('smtp')->send('emails.otp', ['otp' => $otp], function ($message) use ($email, $otp) {
        $message->to($email);
        $message->subject(__('Your OTP code is: '.$otp));
      });

      return response()->json(["success" => true, 'message' => "We`ve sent the verification code to ". $email], 200);
    }

    /**
     * Verify the OTP
     */
    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->email;
        $code = $request->code;

        $storedOtp = session($email . '_otp');

        if ($storedOtp && $storedOtp == $code) {
            session()->forget($email . '_otp');

            $user = Auth::user();
            $user->email = $email;
            $user->save();
            return response()->json(['message' => 'OTP verified successfully.']);
        }

        return response()->json(['error' => 'Invalid OTP.'], 400);
    }
}
