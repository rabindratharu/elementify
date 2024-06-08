<?php
/**
 * Theme Sidebars.
 *
 * @package Elementify
 */

namespace Elementify\Inc;

/**
 * Class Assets
 */
class Sidebars {

	/**
	 * Construct method.
	 */
	public function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To register action/filter.
	 *
	 * @return void
	 */
	private function setup_hooks() {

		/**
		 * Actions
		 */
		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
	}

	/**
	 * Register widgets.
	 *
	 * @action widgets_init
	 */
	public function register_sidebars() {

		register_sidebar(
			[
				'name'          => esc_html__( 'Sidebar', 'elementify' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'elementify' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);

		// Header Widgets Area
		for ( $i = 1; $i <= 2; $i ++ ) {
			register_sidebar(
				array(
					/* translators: 1: Widget number. */
					'name'          => sprintf( esc_html__( 'Header Area #%d', 'elementify' ), $i ),
					'id'            => 'header-' . $i,
					'description'   => esc_html__( 'Add widgets here.', 'elementify' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				)
			);
		}

		// Footer Widgets Area
		for ( $i = 1; $i <= 6; $i ++ ) {
			register_sidebar(
				array(
					/* translators: 1: Widget number. */
					'name'          => sprintf( esc_html__( 'Footer Area #%d', 'elementify' ), $i ),
					'id'            => 'footer-' . $i,
					'description'   => esc_html__( 'Add widgets here.', 'elementify' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				)
			);
		}
	}
}
