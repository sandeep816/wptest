<footer class="bg-gray-200">
    <div class="container mx-auto py-8">Footer</div>
</footer>

<!-- Login  -->
<div id="popup-login-form" class="mfp-hide zoom-anim-dialog auth-form-wrap">
<div class="auth-wrap">
        <h2 class="truncate text-xl font-semibold mb-5">Log In Your Account</h2>
        <div class="form-message" id="loginMessage"></div>
        <form action="#" id="loginForm" class="mx-auto mb-0 mt-8 max-w-md space-y-4" method="post" accept-charset="utf-8">

 

            <div class="form-group mt-3">
                <label for="username" class="sr-only"><?php echo esc_attr__('User*', 'radhakrishn'); ?></label>
                <div class="relative">
                <input id="username" type="email" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm required" name="username" value="" placeholder="Email Address">
                </div> 
            </div> 



            <div class="form-group  mt-3">
                <label for="password" class="sr-only"><?php echo esc_attr__('Password', 'radhakrishn'); ?></label>
                <div class="relative">
                <input id="password" type="password" class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm required" name="password">
                </div>
            </div> 
            <!-- END .form-group .row -->

            
            <div class="flex items-center justify-between space-x-2 py-6">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <a class="btn-link" href="forgot-password">
                    Forgot Your Password?
                </a>

            </div> <!-- END .form-group .row -->

            <div class="form-group">
                <input type="hidden" name="action" value="user_login">
                <input type="hidden" name="ss_nonce"
                       value="<?php echo esc_attr(wp_create_nonce('ss_nonce')) ?>">
                <input class="btn inline-block rounded-lg bg-green-700 px-5 py-3 text-sm font-medium text-white" name="login_submit" type="submit" value="LOGIN">
                <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
            </div>


        </form>

        <div class="">
            Don't have account yet? <a href="#popup-register-form" class="popuplink">Register</a>
        </div>
    </div>
</div>
<!-- Login  -->


<!-- Register Popup Content -->

<div id="popup-register-form" class="mfp-hide zoom-anim-dialog auth-form-wrap">

<div class="auth-wrap">
        <h2>Log In Your Account</h2>
        <div id="registerMessage" style="display:none;"></div>
        <form class="mt-8 grid grid-cols-6 gap-6"  id="registerform" name="registerform" action="#" method="post"  accept-charset="utf-8">

            <div class="form-message col-span-6"></div>

            <div class="col-span-6 sm:col-span-3">
                <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="fname" type="text" class="mt-1 w-full border border-black p-3" name="fname" value="">
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="lname" type="text" class="mt-1 w-full border border-black p-3" name="lname" value="">
            </div>

            <div class="col-span-6">
                <label for="email" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                <input id="register_email" type="email" class="mt-1 w-full border border-black p-3" name="register_email" value="" >
            </div>
            

        

            <div class="col-span-6 sm:col-span-3">
                <label for="register_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="register_password" type="password" class="mt-1 w-full border border-black p-3" name="register_password" >
            </div>

            <div class="col-span-6 sm:col-span-3">
            <label for="confirm_password" class="block text-sm font-medium text-gray-700">
              Password Confirmation
            </label>

            <input type="password" id="confirm_password" name="confirm_password" class="mt-1 w-full border border-black p-3">
          </div>

          <div class="col-span-6">
            <label for="agree" class="flex gap-4">
              <input type="checkbox" id="agree" name="agree" class="size-5 rounded-md border-gray-200 bg-white shadow-sm">

              <span class="text-sm text-gray-700">
                I want to receive emails about events, product updates and company announcements.
              </span>
            </label>
          </div>

          <div class="col-span-6">
            <p class="text-sm text-gray-500">
              By creating an account, you agree to our
              <a href="#" class="text-gray-700 underline"> terms and conditions </a>
              and
              <a href="#" class="text-gray-700 underline">privacy policy</a>.
            </p>
          </div>

            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
                <input type="hidden" name="action" value="user_register">
                <input type="hidden" name="ss_nonce" value="">
                <input type="submit" name="login_button" class="cursor-pointer binline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500" value="Sign Up" data-process="Processing . . ." data-string="Sign Up">

                <p class="mt-4 text-sm text-gray-500 sm:mt-0">
              Already have an account?
              <a href="#popup-login-form" class="text-gray-700 underline popuplink">Log in</a>.
            </p>
            </div>
        </form>

       
    </div>

</div>

<!-- Register Popup Content -->

<?php wp_footer(); ?>
</body>
</html>