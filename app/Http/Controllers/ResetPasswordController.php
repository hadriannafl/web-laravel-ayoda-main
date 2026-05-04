<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Editor\Fields\Select;

class ResetPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');

        $token = (string)Str::uuid();

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            alert()->error('Unsuccessful', 'Email Login not registered');
            return to_route('forgot.password');
        }else {
            if ($user->company_id == '0') {
                $company = '1';
            } else {
                $company = $user->company_id;
            }
            
            $datacomps = DB::table('m_child_company')->select('name', 'address', 'logo_filename')->where('id_company', $company)->first();
            DB::table('reset_password')->insert([
                'email'=> $user->real_email,
                'token'=> $token,
                'is_active' => 1,
                'expired_at' => Carbon::now()->addHour(),
                'created_at' => Carbon::now()
            ]);
            
            $data = [
                'url' => route('reset.password', [
                    'token' => $token
                ]),
                'logo_filename' => $datacomps->logo_filename,
                'address' => $datacomps->address,
                'company' => $datacomps->name
            ];
            Mail::send('mail_forget_password', $data, function($message) use($email, $user, $datacomps){
                $message->to($user->real_email, $user->username)->subject('' . $datacomps->name . ' - Reset Password');
            });
            alert()->success('Success', 'Link Has Been Send to Email');
            return to_route('forgot.password');
        }
    }

    public function resetPassword(Request $request)
    {
        $token = $request->input('token');

        $checkToken = DB::table('reset_password')->select('is_active', 'expired_at')->where('token', $token)->first();
        $expired_at = Carbon::parse($checkToken->expired_at);

        if ($checkToken->is_active == 0) {
            alert()->error('Error', 'Link was not Active');
            return to_route('forgot.password');
        }

        if ($expired_at->lt(Carbon::now()) ) {
            alert()->error('Error', 'Link was Expired');
            return to_route('forgot.password');
        }
        return view('auth.reset-password');
    }

    public function updatePassword(Request $request)
    {   
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $token = $request->input('token');

        $email = DB::table('reset_password')->where('token', $token)->pluck('email')->first();

        DB::table('users')->where('real_email', $email)->update([
            'password' => Hash::make($request->input('password'))
        ]);
        DB::table('reset_password')->where('token', $token)->update([
            'is_active' => 0
        ]);
        
        alert()->success('Success', 'Password has been Change');
        return to_route('forgot.password');
        // return redirect(url('/'));
    }
}
