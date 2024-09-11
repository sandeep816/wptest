<?php
$term = get_queried_object();
// echo "<pre>";
// print_r($term);
// echo "</pre>";

$year = get_field('year');
$release_date_string = get_field('release_date', $term);
$runtime = get_field('runtime');

$film_director = get_field('film_director');
$film_producer = get_field('film_producer');
$film_writer = get_field('film_writer');
$film_awards = '';

$genre_terms = wp_get_post_terms( get_the_ID(), 'genre');
$language_terms = wp_get_post_terms( get_the_ID(), 'language');
$location_terms = wp_get_post_terms( get_the_ID(), 'location');

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header mb-4">
        <h1 class="entry-title text-2xl lg:text-5xl font-extrabold leading-tight mb-1" itemprop="name"><?php the_title(); ?></h1>
        
        <div id="genre">
            <?php foreach( $genre_terms as $item ) {?>
            <a href="<?php echo get_term_link( $item->term_id ); ?>">
                <span class="itemprop" itemprop="genre"><?php echo $item->name ?></span>
            </a>
        <?php } ?>
        </div><!-- END #genre -->




        



	</div>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</div>