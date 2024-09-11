<?php
/* Template Name: Reset Password */

get_header(); ?>

<div class="reset-password-form">
    <h2>Reset Password</h2>
    <form id="resetPasswordForm" method="post">
        <input type="hidden" name="reset_key" value="<?php echo esc_attr($_GET['key']); ?>">
        <input type="hidden" name="user_login" value="<?php echo esc_attr($_GET['login']); ?>">
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit">Submit</button>
    </form>
    <div id="resetPasswordMessage" style="display:none;"></div>
</div>

<?php get_footer(); ?>