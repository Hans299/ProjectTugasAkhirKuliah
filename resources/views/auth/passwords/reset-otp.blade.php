<form method="POST" action="{{ route('password.otp.reset') }}">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <input type="text" name="otp" placeholder="OTP" required>

    <input type="password" name="password" placeholder="Password Baru" required>
    <input type="password" name="password_confirmation" placeholder="Ulang Password" required>

    <button type="submit">Reset Password</button>
</form>
