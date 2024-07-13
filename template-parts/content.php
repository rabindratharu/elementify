<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elementify
 */

$the_post_id   = get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ele-column'); ?> data-aos="fade-up" data-aos-offset="200"
    data-aos-delay="100" data-aos-duration="<?php echo esc_attr( $args['duration']); ?>" data-aos-once="true">

    <?php
	/**
	 * Hook for entry content.
	 *
	 * @hooked elementify/loop/entry_thumbnail - 10
	 * @hooked elementify/loop/entry_post_card - 20
	 */
	do_action( 'elementify/loop/entry_content' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->