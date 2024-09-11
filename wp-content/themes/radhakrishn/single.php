<?php get_header(); ?>
 
<main class="mx-auto container px-4 sm:px-6 lg:px-8 my-8">
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
<?php if(function_exists('bcn_display'))
{
bcn_display();
}?>
</div>
<?php if ( have_posts() ) : ?>

<?php
while ( have_posts() ) :
    the_post();
    ?>

    <?php get_template_part( 'template-parts/content/content', 'single' ); ?>

    <?php
    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) :
        comments_template();
    endif;
    ?>

<?php endwhile; ?>

<?php endif; ?>
</main>

<?php get_footer(); ?>
