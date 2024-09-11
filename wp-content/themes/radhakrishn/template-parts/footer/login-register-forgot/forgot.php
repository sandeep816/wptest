<div id="popup-forgot-form" class="forgot-password-form mfp-hide zoom-anim-dialog auth-form-wrap">
    <div class="auth-wrap">
        <h2>Forgot Password</h2>
        <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
        <form id="forgotPasswordForm" class="mx-auto mb-0 mt-8 max-w-md space-y-4" method="post">
        <div class="form-group mt-3">
            <input type="email" name="user_email" placeholder="Enter your email" class="w-full rounded-lg border-blue-500 p-4 pe-12 text-sm shadow-sm required" required>
            </div>
            <button type="submit" class="btn inline-block rounded-lg bg-green-700 px-5 py-3 text-sm font-medium text-white">Submit</button>
        </form>
        <div id="forgotPasswordMessage" style="display:none;"></div>
    </div>
</div>