<?php
/**
 * Template Name: Profile Template
 *
 */

get_header(); ?>

   
 <?php 
 $user_id = get_current_user_id();
 $user_info = get_userdata($user_id);
 
//  echo "<pre>";
// print_r($user_info);
// echo "</pre>";

 ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <h2>User Profile</h2>
        <p>Username: <?php echo $user_info->user_login; ?></p>
        <p>Email: <?php echo $user_info->user_email; ?></p>
        <p>Bio: <?php echo get_user_meta($user_id, 'bio', true); ?></p>
        <p>Profile Picture: <?php echo get_avatar($user_id); ?></p>
        
        <!-- Form for editing profile -->
        <h2>Edit Profile</h2>
        <form id="edit-profile-form" action="" method="post" enctype="multipart/form-data">
            <input type="text" name="username" value="<?php echo $user_info->user_login; ?>" placeholder="Username"><br>
            <input type="email" name="email" value="<?php echo $user_info->user_email; ?>" placeholder="Email"><br>
            <textarea name="bio" placeholder="Bio"><?php echo get_user_meta($user_id, 'bio', true); ?></textarea><br>
            <input type="file" name="profile_picture"><br>
            
            <input type="submit" value="Update Profile">
        </form>
        <span class="response-message"></span>
    </main>
</div>


<?php get_footer(); ?>
