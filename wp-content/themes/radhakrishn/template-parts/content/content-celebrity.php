<?php
    $day_of_birth = get_field( 'day_of_birth' );
    $birthplace = get_field( 'birthplace' );
    $star_sign = get_field( 'star_sign' );
    $nickname = get_field( 'nickname' );
    $height = get_field( 'height' );
    $nationality = get_field( 'nationality' ); 
    $religion = get_field( 'religion' );
    $death = get_field( 'death' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header mb-4">
        <h1 class="entry-title text-2xl lg:text-5xl font-extrabold leading-tight mb-1" itemprop="name"><?php the_title(); ?></h1>
    </div>

    <div class="entry-content">
		<?php //the_content(); 
        
    //   $term_obj_list = get_the_terms( $post->ID, 'role' );
    //   echo "<pre>";
    //   print_r($term_obj_list);
    //   echo "</pre>";

    $term_list = get_the_terms($post->ID, 'role');
$types ='';
foreach($term_list as $term_single) {
     $types .= ucfirst($term_single->slug).', ';
}
$typesz = rtrim($types, ', ');
echo $typesz;
        ?>
	</div>

    <div class="border border-gray-300 bg-gray-100 p-8 mb-8">
        <ul>
            <li> <span>Actor</span> <span>film producer</span> <span>presenter</span></li>
            <li>Born:

            <?php
           $dob = DateTime::createFromFormat('Ymd', $day_of_birth);
           echo $dob->format('j M, Y');
           ?>
            </li>
            <li>Height: <?php echo $height; ?></li>
            <li>Citizenship: <?php echo $nationality; ?></li>
        </ul>
    </div>

    <div class="border border-gray-300 bg-gray-100 p-8 hidden">
    <h2>Filmography</h2>

                        <?php

                        // https://github.com/scribu/wp-posts-to-posts/wiki/Connection-metadata
                        //Find connected pages
                        $connected = new WP_Query( array(
                            'connected_type' => 'posts_to_pages',
                            'connected_items' => get_queried_object(),
                            'nopaging' => true,
                            'suppress_filters' => false
                        ));

                        // echo '<pre>';
                        //print_r($connected );

                        ?>
                        <ul>
                        <?php while( $connected->have_posts() ) : $connected->the_post(); ?>
                            <li>
					<span itemprop="actors" itemscope="" itemtype="http://schema.org/Person">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" itemprop="url">
					<figure>
                         <img src="https://placehold.co/50x50" alt="">
                    </figure>
					<h5><span itemprop="name"><?php the_title(); ?></span></h5>
					<span class="role"><?php  echo p2p_get_meta( get_post()->p2p_id, 'character', true ); ?></span>
						</a>
					</span>
                            </li>
                        <?php endwhile; wp_reset_query(); ?>
                        </ul>

                        </div>

</div>