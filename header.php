<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Elementify
 */

namespace Elementify;

//use Elementify\Inc\Utils;
use Elementify_Framework\Inc\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!doctype html>

<?php
/**
 * Functions hooked into elementify/before_html action
 *
 */
do_action( 'elementify/before_html' );
?>

<html <?php language_attributes(); ?> <?php elementify_html_attributes(); ?> <?php Utils::the_microdata( 'html' ); ?>>

<head>

    <?php
    /**
     * Functions hooked into elementify/head_top action
     *
     */
    do_action( 'elementify/head_top' );
    ?>

    <?php
    /**
     * Functions hooked into elementify/head action
     *
     * @hooked elementify_head_meta - 10
     */
    do_action( 'elementify/head' );
    ?>

    <?php
    /**
     * Functions hooked into elementify/head_bottom action
     *
	 * @hooked elementify_wp_head - 10
     */
    do_action( 'elementify/head_bottom' );
    ?>

</head>

<body <?php 
    body_class();
    /**
     * Functions hooked into elementify/body_attributes action
     *
	 * @hooked elementify_body_attributes - 10
     */
    do_action( 'elementify/body_attributes' );
    ?>>

    <?php
/**
 * Functions hooked into elementify/body_top action
 *
 * @hooked elementify_wp_body_open - 10
 */
do_action( 'elementify/body_top' );
?>
    <div id="page" class="site ele-position-relative ele-position-absolute-after">

        <?php
        // Particles Effect
		if ( get_theme_mod( 'elementify_framework_particles_enable' ) ) {
			$section 	= get_theme_mod( 'elementify_framework_particles_section', elementify_framework_get_theme_options()['values']['preset'] );
			if ( in_array( $section['desktop'], ['1'] ) ) {
				$particles_type 	= get_theme_mod( 'elementify_framework_particles_preset', elementify_framework_get_theme_options()['values']['preset'] );
				$particles_colors   = get_theme_mod( 'elementify_framework_particles_color' );
				$particles  		= Utils::get_particles();
				$particles_type     = $particles_type['desktop'];
				if ( $particles_colors && array_key_exists('desktop', $particles_colors) ) {
					// particle color
					if ( isset($particles_colors['desktop']['color_1']) ) {
						$particles[$particles_type]['particles']['color']['value'] = sanitize_text_field($particles_colors['desktop']['color_1']);
					}
					// line color
					if ( isset( $particles_colors['desktop']['color_2']) ) {
						if ( isset( $particles[$particles_type]['particles']['line_linked']['color'] ) ) {
							$particles[$particles_type]['particles']['line_linked']['color'] = sanitize_text_field($particles_colors['desktop']['color_2']);
						}
						if ( isset( $particles[$particles_type]['particles']['links']['color'] ) ) {
							$particles[$particles_type]['particles']['links']['color'] = sanitize_text_field($particles_colors['desktop']['color_2']);
						}
					}
				}
				?>
        <div <?php Utils::print_attribute_string([
					'class'             => 'ele-particles-canvas',
					'id'                => 'ele-site-particles-canvas',
					'data-particles'    => wp_json_encode($particles[$particles_type])
				]);?>></div><!-- .ele-particles-canvas -->
        <?php
			}
		}
        /**
         * Functions hooked into elementify/before_header action
         *
         * @hooked elementify_skip_link - 10
         */
        do_action( 'elementify/before_header' );
        ?>

        <?php
    /**
     * Functions hooked into elementify/header action
     *
     * @hooked elementify_header - 10
     */
    do_action( 'elementify/header' );
    //use Elementify_Framework\Inc\Generated_Styles;
    // $google_font_subsets = Fonts::add_google_fonts();
    // echo $google_font_subset = Fonts::get_google_font_url();
    // $enable = get_theme_mod( 'elementify_framework_buttons_padding');
    // echo '<pre>';
    // print_r($enable);
    // echo '</pre>';
    // echo Generated_Styles::dimensions(
	// 		[':root'],
	// 		'elementify_framework_buttons_padding',
	// 		'',
	// 		'--ele-button-padding'
	// 	);
    
    // $base = get_theme_mod('elementify_framework_single_post_author_info_border',[
    //     'font-family'   => 'default',
    //     'font-weight'   => '400',
    //     'subsets'       => ['latin'],
    //     'font-size'     => [
    //         'desktop'   => '30px',
    //     ],
    //     'line-height'   => [
    //         'desktop'   => '13px',
    //     ],
    //     'letter-spacing'=> [
    //         'desktop'   => '1.3px',
    //     ],
    //     'font-style'    => 'normal',
    //     'text-transform'    => 'none',
    //     'text-decoration'   => 'none',
    // ]);

    // echo '<pre>';
    // print_r($base);
    // echo '</pre>';
    ?>

        <?php
    /**
     * Functions hooked into elementify/after_header action
     *
     */
    do_action( 'elementify/after_header' );