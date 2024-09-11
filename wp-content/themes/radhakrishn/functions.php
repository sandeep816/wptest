<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Theme setup
include_once(TEMPLATEPATH . '/lib/setup.php');

// Enqueue scripts and styles
include_once(TEMPLATEPATH . '/lib/enqueue.php');

// Initialize theme default settings.
include_once(TEMPLATEPATH . '/lib/config.php');

// Register widget area
include_once(TEMPLATEPATH . '/lib/widgets.php');


//  Hide WordPress Admin Bar 
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}





/* logn */

/**
 * login page ajax call
 */
add_action('wp_ajax_login', 'login_ajax');
add_action('wp_ajax_nopriv_login', 'login_ajax');

/**
 * login page ajax call
 */
function login_ajax()
{
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    if( ! empty($_POST['ss_nonce'])  && wp_verify_nonce($_POST['ss_nonce'], 'ss_nonce') ) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $remember = $_POST['remember'];

        $credentials = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => $remember == "on" ? true : false
        );

        $user = wp_signon($credentials, false);


        if ( is_wp_error( $user ) ) {

            $error_code = $user->get_error_code();

            if( $error_code == 'incorrect_password' ) {

                echo json_encode( array(
                    'success' => false,
                    'message' => sprintf( wp_kses(__('The password you entered for the username <strong>%s</strong> is incorrect.', ''), $allowed_html_array), $username )
                ) );

            } else {

                echo json_encode( array(
                    'success' => false,
                    'message' => $user->get_error_message()
                ) );

            }

            wp_die();
        } else {
        }

    }
}


/*Registor*/

add_action('wp_ajax_nopriv_user_register', 'user_register_ajax');
add_action('wp_ajax_user_register', 'user_register_ajax');

function user_register_ajax(){

    $params = array();
    parse_str($_POST['ajax_data'], $params);

    $first_name = sanitize_text_field($params['fname']);
    $last_name = sanitize_text_field($params['lname']);
    $user_email = sanitize_email($params['register_email']);
    $user_pass = sanitize_text_field($params['register_password']);

    if (empty($first_name)) {
        wp_send_json(array('status' => false, 'message' => 'Please enter First Name'));
    }

    if (empty($last_name)) {
        wp_send_json(array('status' => false, 'message' => 'Please enter Last Name'));
    }

    if (email_exists($user_email)) {
        wp_send_json(array('status' => false, 'message' => 'Email is already registered'));
    }

    if (!is_email($user_email)) {
        wp_send_json(array('status' => false, 'message' => 'Invalid email'));
    }

    if (empty($user_pass)) {
        wp_send_json(array('status' => false, 'message' => 'Please enter password'));
    }

    // Create the user
    $user_id = wp_create_user($user_email, $user_pass, $user_email);
    if (is_wp_error($user_id)) {
        wp_send_json(array('status' => false, 'message' => $user_id->get_error_message()));
    }

    // Update user meta
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name
    ));

    // Set verification status to false
    update_user_meta($user_id, 'is_email_verified', false);

    // Send verification email
    $verification_code = wp_generate_password(20, false);
    update_user_meta($user_id, 'email_verification_code', $verification_code);

    $verification_link = add_query_arg(array(
        'user_id' => $user_id,
        'verification_code' => $verification_code
    ), site_url('/verify-email'));

    $subject = 'Verify Your Email Address';
    $message = 'Please click the following link to verify your email address: ' . $verification_link;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mail_sent = wp_mail($user_email, $subject, $message, $headers);

    if (!$mail_sent) {
        wp_send_json(array('status' => false, 'message' => 'Failed to send verification email.'));
    }

    wp_send_json(array('status' => true, 'message' => 'We sent an email to verify your email address.'));
}


// Modify the Login Process

// Check email verification status during login
function check_email_verification_status($user, $password) {
    $is_email_verified = get_user_meta($user->ID, 'is_email_verified', true);

    if (!$is_email_verified) {
        return new WP_Error('email_not_verified', __('Your email address has not been verified. Please check your email for the verification link.', 'mydomain'));
    }

    return $user;
}
add_filter('wp_authenticate_user', 'check_email_verification_status', 10, 2);

// Add custom endpoint for email verification
function add_custom_verification_endpoint() {
    add_rewrite_rule('^verify-email', 'index.php?verify_email=1', 'top');
    add_rewrite_tag('%verify_email%', '([^&]+)');
}
add_action('init', 'add_custom_verification_endpoint');

// Flush rewrite rules on theme activation
function flush_rewrite_rules_on_activation() {
    add_custom_verification_endpoint();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_on_activation');

// Handle email verification
function handle_email_verification() {
    if (get_query_var('verify_email')) {
        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
        $verification_code = isset($_GET['verification_code']) ? sanitize_text_field($_GET['verification_code']) : '';

        if ($user_id && $verification_code) {
            $saved_code = get_user_meta($user_id, 'email_verification_code', true);

            if ($saved_code === $verification_code) {
                update_user_meta($user_id, 'is_email_verified', true);
                delete_user_meta($user_id, 'email_verification_code');
                wp_redirect(site_url('/deshboard'));
                exit;
            }
        }

        wp_redirect(site_url('/email-verification-failed'));
        exit;
    }
}
add_action('template_redirect', 'handle_email_verification');


// Add the "Verified" column to the users table
function add_verified_column($columns) {
    $columns['verified'] = __('Verified', 'mydomain');
    return $columns;
}
add_filter('manage_users_columns', 'add_verified_column');

// Populate the "Verified" column with data
function show_verified_column_content($value, $column_name, $user_id) {
    if ($column_name == 'verified') {
        $is_verified = get_user_meta($user_id, 'is_email_verified', true);
        return $is_verified ? __('Verified', 'mydomain') : __('Not Verified', 'mydomain');
    }
    return $value;
}
add_action('manage_users_custom_column', 'show_verified_column_content', 10, 3);