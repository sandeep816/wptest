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


        // if (is_wp_error($user)) {
        //     wp_send_json_error($user->get_error_message());
        //   } else {
        //     wp_send_json_success(array('message' => 'Login successful. Please wait while you are being redirected', 'redirect_to' => home_url()));
        //   }

        // die();


        if ( is_wp_error( $user ) ) {

            $error_code = $user->get_error_code();

            if( $error_code == 'incorrect_password' ) {

                echo json_encode( array(
                    'success' => false,
                    'message' => sprintf( wp_kses(__('The password you entered for the username <strong>%s</strong> is incorrect.', 'houzez-login-register'), $allowed_html_array), $username )
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


   $first_name	   = sanitize_text_field($params['fname']);
   $last_name 	   = sanitize_text_field($params['lname']);
   $user_email     = sanitize_text_field($params['register_email']);
   $user_pass      = sanitize_text_field($params['register_password']);

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

    // Update user meta
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name
    ));

    // Send verification email
    $verification_code = wp_generate_password(20, false);
    update_user_meta($user_id, 'email_verification_code', $verification_code);

    $verification_link = add_query_arg(array(
        'user_id' => $user_id,
        'verification_code' => $verification_code
    ), site_url('/verify-email'));

    $subject = 'Verify Your Email Address';
    $message = 'Please click the following link to verify your '.$user_email.' email address: ' . $verification_link;
    wp_mail($user_email, $subject, $message);

    wp_send_json(array('status' => true, 'message' => 'We sent an email to verify your email address.'));
 
    // if (empty($first_name)) {
    //     wp_send_json(array(
    //         'status' => false ,
    //         'message' => 'Please enter First Name'));
    // }

    // if (empty($last_name)) {
    //     echo json_encode(array('status' => false , 'message' => 'Please enter Last Name'));
    //     exit();
    // }

    // if(email_exists($user_email)) {
    //     echo json_encode(array('status' => false , 'message' => 'Email is already registered'));
    //     exit();
    // }

    // if (!is_email($user_email)) {
    //     echo json_encode(array('status' => false , 'message' => 'Invalid email'));
    //     exit();
    // }

    // if (empty($user_pass)) {
    //     echo json_encode(array('status' => false , 'message' => 'Please enter password'));
    //     exit();
    // }

    // $username = substr($user_email, 0, strpos($user_email, '@'));

    // $verification_code = wp_generate_password(20, false);

    // $userdata = array(
    //     'user_login'    => $username,
    //     'user_pass'     => $user_pass,
    //     'user_email'    => $user_email,
    //     'first_name'    => $first_name,
    //     'last_name'     => $last_name,
    //     'user_status'   => 1, 
    //     'meta_input'    => array(
    //     'verification_code' => $verification_code,
    //     ),
    // );

    // $new_user = wp_insert_user($userdata);

    // if ( is_wp_error( $new_user ) )
    // {
    //     echo json_encode(array('status' => false , 'message' => $new_user->get_error_message() ));
    //     die();

    // } else {


    //      // Send verification email
    //      $verification_link = add_query_arg(array(
    //         'verify_email' => 'true',
    //         'uid' => $new_user,
    //         'verification_code' => $verification_code,
    //     ), home_url());



    //     if( $user_email != "" ){
    //         $email_html = 'Please click the following link to verify your email: ' . $verification_link;
    //         $subject = 'Thank you for signup';
    //         $body = $email_html;
    //         $headers = array('Content-Type: text/html; charset=UTF-8');
    //         wp_mail($user_email , $subject, $body, $headers );
    //     }

    //     wp_send_json_success(array('message' => 'Registration successful, please check your email to verify.'));
        


    //}

}


function custom_verify_email() {
    if (isset($_GET['verify_email']) && $_GET['verify_email'] === 'true') {
        $user_id = intval($_GET['uid']);
        $verification_code = sanitize_text_field($_GET['verification_code']);
        $user = get_user_by('ID', $user_id);
        
        echo "User ID: $user_id\n";
        echo "Verification Code: $verification_code\n";
        echo "Saved Code: " . get_user_meta($user_id, 'verification_code', true) . "\n";
        
        if ($user) {
            $saved_code = get_user_meta($user_id, 'verification_code', true);
            if ($verification_code === $saved_code) {
                echo "Verification code matches!\n";
                update_user_meta($user_id, 'verification_code', '');
                $user_status = get_user_meta($user_id, 'user_status', true);
                echo "User Status (before): $user_status\n";
                wp_update_user(array(
                    'ID' => $user_id,
                    'user_status' => 0, // Activate user
                ));
                $user_status = get_user_meta($user_id, 'user_status', true);
                echo "User Status (after): $user_status\n";
                echo 'Email verified successfully!';
            } else {
                echo 'Invalid or expired verification code.';
            }
        } else {
            echo 'User not found.';
        }
    }
}
add_action('init', 'custom_verify_email');




add_action('wp_ajax_nopriv_custom_frontend_post_submission', 'custom_frontend_post_submission_ajax');
add_action('wp_ajax_custom_frontend_post_submission', 'custom_frontend_post_submission_ajax');

function custom_frontend_post_submission_ajax() {
  custom_frontend_post_submission();
  wp_die();
}


function custom_frontend_post_submission() {
    if (isset($_POST['post_title']) && isset($_POST['post_content'])) {
      $post_title = sanitize_text_field($_POST['post_title']);
      $post_content = sanitize_textarea_field($_POST['post_content']);
      $post_categories = $_POST['post_categories'];
      $post_featured_image = $_FILES['post_featured_image'];
  
      $post_data = array(
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_category' => $post_categories
      );
  
      $post_id = wp_insert_post($post_data);
  
      if ($post_id) {
        // Handle featured image upload
        $featured_image = media_handle_upload('post_featured_image', $post_id);
        if (is_wp_error($featured_image)) {
          echo 'Error uploading featured image: ' . $featured_image->get_error_message();
        } else {
          set_post_thumbnail($post_id, $featured_image);
        }
      } else {
        echo 'Error creating post.';
      }
    }
  }