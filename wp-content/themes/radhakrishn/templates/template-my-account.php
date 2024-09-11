<?php
/*
Template Name: My Account Page Template
*/
if( ! is_user_logged_in() ){
    $url = home_url( '/' );
    wp_safe_redirect( $url );
}

$user = wp_get_current_user();

$user_id = $user->id;

get_header(); ?>

<div class="container">
<?php 
echo "<pre>";
print_r($user);
echo "</pre>";
?>
</div>
<?php
get_footer();