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
add_action('wp_ajax_user_login', 'user_login_ajax');
add_action('wp_ajax_nopriv_user_login', 'user_login_ajax');

/**
 * login page ajax call
 */
function user_login_ajax()
{

    $params = array();
    parse_str($_POST['ajax_data'], $params);

    $username = sanitize_text_field($params['username']);
    $password = sanitize_text_field($params['password']);
    $remember = isset($params['remember']) ? true : false;

    if (empty($username)) {
        wp_send_json(array('status' => false, 'message' => 'Please enter your username'));
    }

    if (empty($password)) {
        wp_send_json(array('status' => false, 'message' => 'Please enter your password'));
    }

    $user = wp_signon(array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember,
    ));

    if (is_wp_error($user)) {
        wp_send_json(array('status' => false, 'message' => $user->get_error_message()));
    }

    // Set the redirect URL
    $redirect_to = home_url(); // Change this to the URL you want to redirect to after login

    wp_send_json(array('status' => true, 'message' => 'Login successful', 'redirect_to' => $redirect_to));
}


// Register User

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

// Populate the "Verified" column with data and a manual verification link
function show_verified_column_content($value, $column_name, $user_id) {
    if ($column_name == 'verified') {
        $is_verified = get_user_meta($user_id, 'is_email_verified', true);
        if ($is_verified) {
            return __('Verified', 'mydomain');
        } else {
            $verify_url = wp_nonce_url(admin_url('users.php?action=verify_user&user_id=' . $user_id), 'verify_user_' . $user_id);
            return __('Not Verified', 'mydomain') . ' | <a href="' . esc_url($verify_url) . '">' . __('Verify Now', 'mydomain') . '</a>';
        }
    }
    return $value;
}
add_action('manage_users_custom_column', 'show_verified_column_content', 10, 3);

// Handle manual verification
function handle_manual_verification() {
    if (isset($_GET['action']) && $_GET['action'] == 'verify_user' && isset($_GET['user_id']) && isset($_GET['_wpnonce'])) {
        $user_id = intval($_GET['user_id']);
        $nonce = $_GET['_wpnonce'];

        // Debugging: Log the verification process
        error_log('Manual verification process started for user_id: ' . $user_id);

        if (!wp_verify_nonce($nonce, 'verify_user_' . $user_id)) {
            wp_die(__('Nonce verification failed', 'mydomain'));
        }

        update_user_meta($user_id, 'is_email_verified', true);
        delete_user_meta($user_id, 'email_verification_code');

        wp_redirect(admin_url('users.php?verified=1'));
        exit;
    }
}
add_action('admin_init', 'handle_manual_verification');

// Display admin notice after manual verification
function display_verification_notice() {
    if (isset($_GET['verified']) && $_GET['verified'] == 1) {
        echo '<div class="notice notice-success is-dismissible"><p>' . __('User has been verified successfully.', 'mydomain') . '</p></div>';
    }
}
add_action('admin_notices', 'display_verification_notice');


// Add custom endpoint for email verification failed
add_action('wp_ajax_nopriv_resend_verification_email', 'resend_verification_email_ajax');
add_action('wp_ajax_resend_verification_email', 'resend_verification_email_ajax');

function resend_verification_email_ajax() {
    $user_id = intval($_POST['user_id']);

    if (!$user_id) {
        wp_send_json(array('status' => false, 'message' => 'Invalid user ID.'));
    }

    $user = get_userdata($user_id);

    if (!$user) {
        wp_send_json(array('status' => false, 'message' => 'User not found.'));
    }

    // Generate a new verification code
    $verification_code = wp_generate_password(20, false);
    update_user_meta($user_id, 'email_verification_code', $verification_code);

    $verification_link = add_query_arg(array(
        'user_id' => $user_id,
        'verification_code' => $verification_code
    ), site_url('/verify-email'));

    $subject = 'Verify Your Email Address';
    $message = 'Please click the following link to verify your email address: ' . $verification_link;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mail_sent = wp_mail($user->user_email, $subject, $message, $headers);

    if (!$mail_sent) {
        wp_send_json(array('status' => false, 'message' => 'Failed to send verification email.'));
    }

    wp_send_json(array('status' => true, 'message' => 'Verification email sent successfully.'));
}


// Add custom endpoint for password reset
add_action('wp_ajax_nopriv_forgot_password', 'handle_forgot_password');
add_action('wp_ajax_forgot_password', 'handle_forgot_password');

function handle_forgot_password() {
    $user_email = sanitize_email($_POST['user_email']);

    if (!is_email($user_email)) {
        wp_send_json(array('status' => false, 'message' => 'Invalid email address.'));
    }

    $user = get_user_by('email', $user_email);

    if (!$user) {
        wp_send_json(array('status' => false, 'message' => 'No user found with this email address.'));
    }

    // Generate a password reset key
    $reset_key = get_password_reset_key($user);

    // Create the password reset link
    $reset_link = add_query_arg(array(
        'action' => 'reset_password',
        'key' => $reset_key,
        'login' => rawurlencode($user->user_login)
    ), site_url('/reset-password'));

    // Send the password reset email
    $subject = 'Password Reset Request';
    $message = 'Click the following link to reset your password: ' . $reset_link;
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $mail_sent = wp_mail($user_email, $subject, $message, $headers);

    if (!$mail_sent) {
        wp_send_json(array('status' => false, 'message' => 'Failed to send password reset email.'));
    }

    wp_send_json(array('status' => true, 'message' => 'Password reset email sent successfully.'));
}


// Add custom endpoint for password reset
add_action('wp_ajax_nopriv_reset_password', 'handle_reset_password');
add_action('wp_ajax_reset_password', 'handle_reset_password');

function handle_reset_password() {
    $reset_key = sanitize_text_field($_POST['reset_key']);
    $user_login = sanitize_text_field($_POST['user_login']);
    $new_password = sanitize_text_field($_POST['new_password']);

    $user = check_password_reset_key($reset_key, $user_login);

    if (is_wp_error($user)) {
        wp_send_json(array('status' => false, 'message' => 'Invalid password reset key.'));
    }

    reset_password($user, $new_password);

    wp_send_json(array('status' => true, 'message' => 'Password reset successfully.'));
}


//  Front-End Post Submission 
add_action('wp_ajax_nopriv_submit_post', 'handle_submit_post');
add_action('wp_ajax_submit_post', 'handle_submit_post');

function handle_submit_post() {
    if (!is_user_logged_in()) {
        wp_send_json(array('status' => false, 'message' => 'You must be logged in to submit a post.'));
    }

    // Check nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'submit_post_nonce')) {
        wp_send_json(array('status' => false, 'message' => 'Nonce verification failed.'));
    }

    $post_title = sanitize_text_field($_POST['post_title']);
    $post_content = wp_kses_post($_POST['post_content']);
    $post_categories = array_map('intval', $_POST['post_categories']);
    $post_tags = sanitize_text_field($_POST['post_tags']);

    $post_id = wp_insert_post(array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'pending', // Set to 'pending' for review before publishing
        'post_author' => get_current_user_id(),
        'post_category' => $post_categories,
        'tags_input' => explode(',', $post_tags),
    ));

    if (is_wp_error($post_id)) {
        wp_send_json(array('status' => false, 'message' => 'Failed to submit post.'));
    }

    // Handle the featured image upload
    if (!empty($_FILES['post_featured_image']['name'])) {
        $file = $_FILES['post_featured_image'];
        $upload = wp_handle_upload($file, array('test_form' => false));

        if ($upload && !isset($upload['error'])) {
            $attachment_id = wp_insert_attachment(array(
                'post_mime_type' => $upload['type'],
                'post_title' => sanitize_file_name($file['name']),
                'post_content' => '',
                'post_status' => 'inherit'
            ), $upload['file'], $post_id);

            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);
            set_post_thumbnail($post_id, $attachment_id);
        } else {
            wp_send_json(array('status' => false, 'message' => 'Failed to upload featured image.'));
        }
    }

    wp_send_json(array('status' => true, 'message' => 'Post submitted successfully.'));
}