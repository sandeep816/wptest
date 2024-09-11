<?php
/**
 * Template Name: Dashboard Page Template
 *
 */

get_header(); 

if( ! is_user_logged_in() ){
    $url = home_url( '/' );
    wp_safe_redirect( $url );
}

$current_user = wp_get_current_user();

//$user_id = $user->id;
 


get_header(); ?>

<div class="container">
 
<?php 
echo 'User first name: ' . $current_user->user_firstname . '<br />';
echo 'User last name: ' . $current_user->user_lastname . '<br />';
echo 'User display name: ' . $current_user->display_name . '<br />';
// echo "<pre>";
// print_r($current_user->ID);
// echo "</pre>";
?>

<?php
$user = wp_get_current_user();

if ( $user ) :
	?>
	<img src="<?php echo esc_url( get_avatar_url( $current_user->ID ) ); ?>" />
<?php endif; ?>
</div>
<?php get_footer(); ?>