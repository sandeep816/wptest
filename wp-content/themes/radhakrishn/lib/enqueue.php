<?php
/**
 * Enqueue theme assets.
 */
function xepress_enqueue_scripts() {
	$theme_version = wp_get_theme()->get('Version');

    
    wp_enqueue_style('xepress-style', get_stylesheet_uri(), array(), $theme_version);
    wp_style_add_data('xepress-style', 'rtl', 'replace');
    wp_enqueue_style('xepress-magnific', get_theme_file_uri('/assets/css/magnific-popup.css'), null, $theme_version);
    wp_enqueue_style('xepress', get_theme_file_uri('/assets/css/app.css'), null, $theme_version);
    //wp_enqueue_script('xepress', get_theme_file_uri( '/assets/js/custom-ajax-script.js' ), array(), $theme_version, true );


    wp_enqueue_script('jquery');
   wp_enqueue_script('custom-script', get_theme_file_uri( '/assets/js/custom-script.js' ), array('jquery'), '1.0', true);
    wp_enqueue_script('xepress', get_theme_file_uri( '/assets/js/app.js' ), array(), $theme_version, true );
    wp_enqueue_script('custom-validate', get_theme_file_uri( '/assets/js/jquery.validate.min.js' ), array('jquery'), '1.0', true);
    wp_enqueue_script('custom-magnific', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array('jquery'), '1.0', true);
    wp_enqueue_script('custom-ajax-script', get_theme_file_uri( '/assets/js/custom-ajax-script.js' ), array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce("ajax_nonce"),
    ));
}

add_action( 'wp_enqueue_scripts', 'xepress_enqueue_scripts' );
