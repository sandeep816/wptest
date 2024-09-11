<?php
/**
 * Template Name: Add Post Page Template
 *
 */

 
if( ! is_user_logged_in() ){
  $url = home_url( '/' );
  wp_safe_redirect( $url );
}

get_header(); 

?>
<div class="container max-w-[1000px]">
<form id="post-submission-form">
  <div>
  <label for="post-title" class="block">Title:</label>
  <input type="text" id="post-title" name="post_title" class="w-full border-b bg-orange-300" required>
  </div>

  <div>
  <label for="post-content"  class="block">Content:</label>
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

 <div>
 <label for="post-categories"  class="block">Categories:</label>
  <select id="post-categories" name="post_categories" class="w-full border-b bg-orange-300" multiple>
    <?php
      $categories = get_categories();
      foreach ($categories as $category) {
        echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
      }
    ?>
  </select>
 </div>

  <label for="post-featured-image" class="block">Featured Image:</label>
  <input type="file" id="post-featured-image" name="post_featured_image" class="w-full border-b bg-orange-300" required>

  <button type="submit" class="w-full bg-blue-400">Submit Post</button>
</form>
</div>
<?php get_footer(); ?>"