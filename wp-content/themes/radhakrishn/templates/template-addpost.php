<?php
/**
 * Template Name: Add Post Page Template
 *
 */

if( ! is_user_logged_in() ){
  $url = home_url( '/' );
  wp_safe_redirect( $url );
  exit;
}

get_header(); 
?>
<div class="container max-w-[1000px] py-12">
<div id="post-submission-message" style="display:none;"></div>
  <form id="post-submission-form">
    <?php wp_nonce_field('submit_post_nonce', 'submit_post_nonce'); ?>
    <div class="mb-5">
      <label for="post-title" class="block">Title:</label>
      <input type="text" id="post-title" name="post_title" class="w-full" required>
    </div>

    <div class="mb-5">
      <label for="post-content" class="block">Content:</label>
      <?php
        $content = '';
        $editor_id = 'post-content-editor';
        wp_editor($content, $editor_id, array(
          'media_buttons' => false,
          'tinymce' => array(
            'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,|,code,|,formatselect',
            'theme_advanced_buttons2' => '',
          ),
        ));
      ?>
    </div>

    <div class="mb-5">
      <label for="post-categories" class="block">Categories:</label>
      <select id="post-categories" name="post_categories[]" class="w-full"  multiple>
        <?php
          $categories = get_categories();
          foreach ($categories as $category) {
            echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
          }
        ?>
      </select>
    </div>

    <div class="mb-5">
      <label for="post-tags" class="block">Tags:</label>
      <input type="text" id="post-tags" name="post_tags" class="w-full" placeholder="Comma separated">
    </div>

    <div class="mb-5">
      <label for="post-featured-image" class="block">Featured Image:</label>
      <input type="file" id="post-featured-image" name="post_featured_image" class="w-full">
    </div>

    <div>
      <button type="submit" class="bg-blue-500 text-white px-4 py-2">Submit Post</button>
    </div>
  </form>
  
</div>
<?php get_footer(); ?>