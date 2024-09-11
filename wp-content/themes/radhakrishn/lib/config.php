<?php

// Remove RSD Links
remove_action( 'wp_head', 'rsd_link' );

// Disable Emoticons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//Remove Shortlink
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

//Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

//Hide WordPress Version
remove_action( 'wp_head', 'wp_generator' );

//Remove WLManifest Link
remove_action( 'wp_head', 'wlwmanifest_link' );

//Hide WordPress Version
remove_action( 'wp_head', 'wp_generator' );


remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational li

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);



/*
	-- Customizing the Login Form
	-- http://codex.wordpress.org/Customizing_the_Login_Form
*/

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/site-wp-logo.png);
            height:110px;
            width:110px;
            background-size: 110px 110px;
            background-repeat: no-repeat;
            padding-bottom: 0px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Bpro';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );



// customize admin footer text
function custom_admin_footer()
{
    echo 'Website Development by <a href="https://xepress.in/" target="_blank" title="Visit xepress.in for more information">xepress</a>';
}
add_filter('admin_footer_text', 'custom_admin_footer');


// SVG Image Upload
function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

