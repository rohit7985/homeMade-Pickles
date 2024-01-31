<p>Hello!</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p><strong>Click the button below to reset your password:</strong></p>
<form action="{{ $actionUrl }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" style="cursor: pointer; padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 3px;">Reset Password</button>
</form>
<p>This password reset link will expire in 5 minutes. If you did not request a password reset, no further action is required.</p>
<p>Thank you!</p>