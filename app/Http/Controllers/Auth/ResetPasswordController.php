<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\PasswordOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    /** FORM EMAIL */
    public function showEmailForm()
    {
        return view('auth.passwords.email-otp');
    }

    /** KIRIM OTP */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);

        PasswordOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => Hash::make($otp),
                'expired_at' => now()->addMinutes(10),
            ]
        );

        Mail::to($request->email)->send(new PasswordOtpMail($otp));

        return redirect()->route('password.otp.form', $request->email)
            ->with('success', 'OTP telah dikirim ke email.');
    }

    /** FORM OTP + PASSWORD BARU */
    public function showOtpForm($email)
    {
        return view('auth.passwords.reset-otp', compact('email'));
    }

    /** PROSES RESET */
    public function resetWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = PasswordOtp::where('email', $request->email)->first();

        if (!$record || now()->gt($record->expired_at)) {
            return back()->withErrors(['otp' => 'OTP sudah kadaluarsa']);
        }

        if (!Hash::check($request->otp, $record->otp)) {
            return back()->withErrors(['otp' => 'OTP tidak valid']);
        }

        User::where('email', $request->email)->update([
            'password' => $request->password,
        ]);

        $record->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }
}
