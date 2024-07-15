<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elementify
 */

namespace Elementify;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php
/**
 * Functions hooked into elementify/before_content action
 *
 * @hooked elementify_site_content_start    - 10
 */
do_action( 'elementify/before_content' );
?>

<?php
/**
 * Functions hooked into elementify/content_top action
 * 
 * @hooked elementify_posts_wrapper_start - 10
 */
do_action( 'elementify/content_top' );
// Initialize the duration variable
$duration 	= 1000;
$delay 		= 0;
?>

<?php if ( have_posts() ) : ?>

<?php
	/**
	 * Functions hooked into elementify/content/before_loop action
	 * 
	 * @hooked elementify_posts_page_header - 10
	 */
	do_action('elementify/content/before_loop');

	/* Start the Loop */
	while ( have_posts() ) : the_post();

		/*
		* Include the Post-Type-specific template for the content.
		* If you want to override this in a child theme, then include a file
		* called content-___.php (where ___ is the Post Type name) and that will be used instead.
		*/
		get_template_part( 'template-parts/content', get_post_type(), [
			'data-aos-duration' => $duration,
			'data-aos-delay' 	=> $delay, // Add a delay to the animations for a more natural flow of the content on the page.
		] );

		// Increment the duration for the next iteration
        $duration 	+= 50; // Increase by 500 milliseconds
		$delay 		+= 50; // Increase by 500 milliseconds

	endwhile;

	/**
	 * Functions hooked into elementify/content/after_loop action
	 *
	 * @hooked elementify_posts_wrapper_end	- 10
	 * @hooked elementify_posts_pagination 	- 15
	 */
	do_action('elementify/content/after_loop');

else :

	get_template_part( 'template-parts/content', 'none' );

endif;
?>

<?php
/**
 * Functions hooked into elementify/content_bottom action
 * 
 * @hooked elementify_posts_wrapper_end - 10
 */
do_action( 'elementify/content_bottom' );
?>

<?php
/**
 * Functions hooked into elementify/after_content action
 *
 * @hooked elementify_site_content_end	- 10
 */
do_action( 'elementify/after_content' );
?>

<?php get_footer(); ?>