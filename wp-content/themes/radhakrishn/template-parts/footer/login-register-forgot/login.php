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
                <a class="btn-link popuplink" href="#popup-forgot-form">
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