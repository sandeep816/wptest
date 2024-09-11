<?php
/**
 * Template Name: Front Page Template
 *
 */

get_header(); ?>

<main class="mx-auto container px-4 sm:px-6 lg:px-8 my-8">

<?php
    $current_month = date('m');

    $args = array(
        'post_type' => 'celebrity',
        'posts_per_page' => -1, // Get all celebrities
        'meta_query' => array(
            array(
                'key' => 'day_of_birth', // Your ACF field name
                'value' => array($current_month . '/01', $current_month . '/31'), // Month range
                'compare' => 'BETWEEN',
                'type' => 'DATE' // Important for date comparison
            )
        )
    );
    
    $query = new WP_Query($args);

    //echo "<pre>";
   // print_r($query);

   if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
       // $day_of_birth = get_field( 'day_of_birth' );
        $post_id = $post->ID;
     // echo $post_id = $query->ID;
        ?>
       <div>
            <h2><?php the_title(); ?></h2>
            <div><?php the_field('day_of_birth', $post_id); ?></div>
       </div>
        <?php  endwhile;
    wp_reset_postdata();
    else :
        echo 'No celebrities found with birthdays this month.';
    endif;
    
    
?>

</main>
<?php get_footer(); ?>
