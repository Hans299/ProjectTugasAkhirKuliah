<form method="POST" action="{{ route('password.otp.send') }}">
    @csrf
    <input type="email" name="email" required placeholder="Email">
    <button type="submit">Kirim OTP</button>
</form>
