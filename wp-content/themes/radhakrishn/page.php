<?php get_header(); ?>
 
<main class="mx-auto container px-4 sm:px-6 lg:px-8 my-8">
<?php

// Start the Loop.
while ( have_posts() ) :
    the_post();

    get_template_part( 'template-parts/content/content', 'page' );

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }

endwhile; // End the loop.
?>
</main>

<?php get_footer(); ?>