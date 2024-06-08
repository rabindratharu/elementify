<?php
/**
 * Template part for displaying post entry footer
 *
 * @package Elementify
 */
?>
<footer class="entry-footer">
	<?php 
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'elementify' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			wp_kses_post( get_the_title() )
		),
		'<span class="edit-link">',
		'</span>'
	); ?>
	
</footer><!-- .entry-footer -->
