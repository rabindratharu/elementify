<?php
/**
 * Template part for displaying a header navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Elementify
 */
// use Elementify_Framework\Inc\Menus;
// $menu_class     = Menus();
// $header_menu_id = $menu_class->get_menu_id( 'menu-1' );
// $header_menus   = wp_get_nav_menu_items( $header_menu_id );

?>
<header id="masthead" class="site-header ele-w-100 ele-site-header 35s">
	<div class="ele-header-wrap ele-position-relative">
		<div class="ele-header-main ele-d-flex------ ele-align-items-center------ ele-flex-wrap------ ele-justify-content-between------">
			<div class="ele-container ele-mx-auto ele-d-grid">
				<?php //echo elementify_site_branding(); ?>
				<?php echo elementify_primary_navigation(); ?>
			</div>
		</div>
	</div>
</header><!-- #masthead -->
