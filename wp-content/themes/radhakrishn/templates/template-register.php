<?php
/**
 * Template Name: Register Page Template
 *
 */

get_header(); ?>

   

<div id="popup-register-form" class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="auth-wrap">
        <h2>Log In Your Account</h2>
    
        <form class="mt-8 grid grid-cols-6 gap-6"  id="registerform" name="registerform" action="#" method="post"  accept-charset="utf-8">

            <div class="form-message col-span-6"></div>

            <div class="col-span-6 sm:col-span-3">
                <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="fname" type="text" class="mt-1 w-full border border-black p-3 required" name="fname" value="">
            </div>

            <div class="col-span-6 sm:col-span-3">
                <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="lname" type="text" class="mt-1 w-full border border-black p-3 required" name="lname" value="">
            </div>

            <div class="col-span-6">
                <label for="email" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                <input id="register_email" type="email" class="mt-1 w-full border border-black p-3 required" name="register_email" value="" >
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
              <a href="#" class="text-gray-700 underline">Log in</a>.
            </p>
            </div>
        </form>
    </div>
</div>
<!-- END Form -->


<?php get_footer(); ?>
