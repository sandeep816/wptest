<?php
/**
 * Template Name: Forgot password Template
 *
 */

get_header(); ?>

   

<form id="custom-forgot-password-form" action="" method="post">
    <input type="email" name="email" id="forgot-email" placeholder="Email">
    <input type="submit" value="Reset Password">
    <span class="response-message"></span>
</form>


<?php get_footer(); ?>
