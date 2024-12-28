<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\User;

class VerificationController extends Controller
{
    public function verify_email(Request $request)
    {
        $code = $request->query('code');
        $email = $request->query('email');

        return view('auth.verifications.verification', ['code' => $code, 'email' => $email]);
    }

    public function verified_email(Request $request)
    {
        $_input = $request->input();

        $code = $request->query('code');
        $email = $request->query('email');

        $user_where = [
            ['remember_token', '=', $code],
            ['email', '=', $email]
        ];
        $user = User::where($user_where)->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            $url = env('FRONTEND_APP_URL').'/';

            return redirect($url);
        } else {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}