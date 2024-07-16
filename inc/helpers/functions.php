<?php
/**
 * Theme helper functions
 *
 * @package Elementify
 */

use Elementify\Inc\Utils;
/*
|--------------------------------------------------------------------------
| Menu Option
|--------------------------------------------------------------------------
|
| Returns an array of navigation menus.
*/
if ( ! function_exists('bizness_get_nav_menus') ) {
    /**
     * Returns an array of navigation menus.
     *
     * @access public
     * @param string $value_field The value to be stored in options. Accepted values: id|slug.
     * @return array
     */
    function bizness_get_nav_menus( $value_field = 'id' ) {
        $choices   = [];
        $nav_menus = wp_get_nav_menus();

        foreach ( $nav_menus as $term ) {
            $choices[ 'slug' === $value_field ? $term->slug : $term->term_id ] = $term->name;
        }

        return $choices;
    }
}

/*--------------------------------------------------------------
# Site Title
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_site_title' ) ) {
    /**
     * Displays the site title
     *
     * @param array   $args Arguments for displaying the site logo either as an image or text.
     * @param boolean $echo Echo or return the HTML.
     * @return string $html Compiled HTML based on our arguments.
     * @since 1.0.0
     */
    function elementify_site_title( $args = array(), $echo = true ) {

        $defaults   = array(
            'title'       => '<a href="%1$s">%2$s</a>',
            'title_class' => 'ele-site-title',
            'wrapper'     => '<div class="%1$s" itemprop="name">%2$s</div>',
            'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
        );
        $args       = wp_parse_args( $args, $defaults );

        /**
         * Filters the arguments for `elementify_site_title()`.
         *
         * @param array  $args     Parsed arguments.
         * @param array  $defaults Function's default arguments.
         */
        $args       = apply_filters( 'elementify_site_title_args', $args, $defaults );
        $contents   = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( get_bloginfo( 'name' ) ) );
        $classname  = $args['title_class'];
        $wrap       = $args['wrapper'];
        $html       = sprintf( $wrap, $classname, $contents );

        /**
         * Filters the arguments for `elementify_site_title()`.
         *
         * @param string $html      Compiled html based on our arguments.
         * @param array  $args      Parsed arguments.
         * @param string $classname Class name based on current view, home or single.
         * @param string $contents  HTML for site title or logo.
         */
        $html = apply_filters( 'elementify_site_title', $html, $args, $classname, $contents );

        if ( ! $echo ) {
            return $html;
        }

        echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
}

/*--------------------------------------------------------------
# Site Description
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_site_description' ) ) {
    /**
     * Displays the site description.
     *
     * @param   boolean $echo Echo or return the html.
     * @return  string $html The HTML to display.
     * @since   1.0.0
     */
    function elementify_site_description( $echo = true ) {
        $description    = get_bloginfo( 'description' );
        $wrapper        = '<p class="ele-site-description" itemprop="description">%s</p><!-- .ele-site-description -->';
        $html           = sprintf( $wrapper, esc_html( $description ) );

        /**
         * Filters the html for the site description.
         *
         * @param string $html         The HTML to display.
         * @param string $description  Site description via `bloginfo()`.
         * @param string $wrapper      The format used in case you want to reuse it in a `sprintf()`.
         */
        $html = apply_filters( 'elementify_site_description', $html, $description, $wrapper );

        if ( ! $echo ) {
            return $html;
        }

        echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/*--------------------------------------------------------------
# Site Logo
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_site_logo' ) ) {
    /**
     * Displays the site logo.
     *
     * @param   boolean $echo Echo or return the $html.
     * @return  void $html The HTML to display.
     * @since   1.0.0
     */
    function elementify_site_logo( $echo = true ) {

        if ( ! has_custom_logo() ) {
            return;
        }
        $logo               = wp_kses_post( get_custom_logo() );
        $logo_class         = 'ele-site-logo';
        $wrapper            = '<div class="%1$s">%2$s</div>';
        $html               = sprintf( $wrapper, $logo_class, $logo );

        /**
         * Filters the html for the site description.
         *
         * @param string $html         The HTML to display.
         * @param string $description  Site description via `bloginfo()`.
         * @param string $wrapper      The format used in case you want to reuse it in a `sprintf()`.
         */
        $html = apply_filters( 'elementify_site_logo', $html, $logo, $wrapper );

        if ( ! $echo ) {
            return $html;
        }

        echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/*--------------------------------------------------------------
# Site Identity
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_site_identify' ) ) {
    /**
     * Displays the site  title and description.
     *
     * @return  void HTML display
     * @since   1.0.0
     */
    function elementify_site_identify() {
        ?>
<div class="ele-site-identity">
    <?php
            elementify_site_title(); // Site title.
            elementify_site_description(); // Site description.
            ?>
</div>
<?php
    }
}

/*--------------------------------------------------------------
# Primary Navigation
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_primary_navigation' ) ) {
    /**
     * Display Primary Navigation
     *
     * @return  string HTML display
     * @since   1.0.0
     */
    function elementify_primary_navigation() {

        // $default_values     = get_elementify_theme_mods();
        //$menu_caret         = elementify_get_theme_mod_new('elementify_header_menu_caret', $default_values['customizer']['toggle']['on'] );
        $main_navigation    = ['main-navigation ele-position-fixed----- ele-position-absolute ele-top-100 ele-top-0----- ele-left-0 ele-z-20 ele-w-100 ele-h-100vh'];
        $menu_class         = ['ele-main-menu ele-list-style-none ele-p-0 ele-m-0 ele-d-flex ele-flex-column ele-flex-lg-row'];

        // if ( $menu_caret['lg'] == 'on' ) {
            $menu_class[]   = 'have-caret';
        // }

        $main_navigation[] = 'main-navigation-sm ele-position-sm-relative ele-top-sm-auto ele-left-sm-auto ele-h-sm-auto';
        $menu_class[]      = 'ele-flex-sm-wrap';


        $menu_class[]   = 'ele-flex-lg-row';
        $menu_class[]   = 'ele-flex-sm-wrap ele-flex-sm-row ele-align-items-md-center';

        // Header Transition
        // $settings   = elementify_customizer_controls_io();
        // if ( isset( $settings['header_transition'] ) ) {
        //     $main_navigation[] = $settings['header_transition'];
        // }
        ?>

<nav id="site-navigation" class="<?php echo esc_attr( implode( ' ', $main_navigation ) ); ?>"
    aria-label="<?php esc_attr_e( 'Horizontal', 'elementify' ); ?>" role="navigation">

    <?php
            wp_nav_menu(
                array(
					'theme_location'	=> 'menu-1',
					'menu_id'        	=> 'primary-menu',
                    'menu_class'      	=> esc_attr( implode( ' ', $menu_class ) ),
                    'container_class' 	=> 'primary-menu-container',
                    'items_wrap'      	=> '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                    'fallback_cb'     	=> 'elementify_menu_fallback',
                )
            );
            ?>
</nav>

<div class="ele-trigger-menu ele-d-block ele-z-30 ele-d-sm-none">
    <div class="ele-hamburger-menu"><span></span><span></span><span></span><span></span></div>
</div>

<?php
    }
}

/*--------------------------------------------------------------
# Primary menu fallback
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_menu_fallback' ) ) {
    /**
     * Menu fallback for primary menu.
     *
     * Contains wp_list_pages to display pages created,
     * @return  void
     * @since   1.0.0
     */
    function elementify_menu_fallback() {
        $output  = '';
        $output .= '<div class="primary-menu-container">';
        $output .= '<ul id="primary-menu-list" class="ele-main-menu ele-d-flex ele-flex-wrap ele-list-style-none">';

        $output .= wp_list_pages(
            array(
                'echo'     => false,
                'title_li' => false,
            )
        );

        $output .= '</ul>';
        $output .= '</div>';

        // @codingStandardsIgnoreStart
        echo $output;
        // @codingStandardsIgnoreEnd
    }
}

/*--------------------------------------------------------------
# Collapsable menu fallback
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_collapsible_menu_fallback' ) ) {
    /**
     * Menu fallback for primary menu.
     *
     * Contains wp_list_pages to display pages created,
     * @return  void
     * @since   1.0.0
     */
    function elementify_collapsible_menu_fallback() {
        $output  = '';
        $output .= '<div class="ele-collapsible-menu-container">';
        $output .= '<ul id="ele-collapsible-menu-list" class="ele-ele-collapsible-menu">';

        $output .= wp_list_pages(
            array(
                'echo'     => false,
                'title_li' => false,
            )
        );

        $output .= '</ul>';
        $output .= '</div>';

        // @codingStandardsIgnoreStart
        echo $output;
        // @codingStandardsIgnoreEnd
    }
}

/*--------------------------------------------------------------
# Get SVG Code
--------------------------------------------------------------*/
if ( !function_exists( 'elementify_get_icon_svg' ) ) {
    /**
     * Gets the SVG code for a given icon.
     *
     * @param   string $group The icon group.
     * @param   string $icon The icon.
     * @param   int    $size The icon size in pixels.
     * @return  string
     * @since   1.0.0
     */
    function elementify_get_icon_svg( $group, $icon, $size = 24 ) {
        return Elementify\Inc\SVG_Icons::get_svg( $group, $icon, $size );
    }
}

/*--------------------------------------------------------------
# Get SVG Code from social url
--------------------------------------------------------------*/
if ( !function_exists( 'elementify_get_social_link_svg' ) ) {
    /**
     * Detects the social network from a URL and returns the SVG code for its icon.
     *
     * @param   string $uri Social link.
     * @param   int    $size The icon size in pixels.
     * @return  string
     * @since   1.0.0
     */
    function elementify_get_social_link_svg( $uri, $size = 24 ) {
        return Elementify\Inc\SVG_Icons::get_social_link_svg( $uri, $size );
    }
}

/*--------------------------------------------------------------
# Pagination
--------------------------------------------------------------*/
if ( ! function_exists( 'elemetify_pagination' ) ) {

	/**
	 * Elemetify Pagination.
	 *
	 * @return void
	 */
	function elemetify_pagination() {

		$allowed_tags = [
			'span' => [
				'class' => []
			],
			'a' => [
				'class' => [],
				'href' => [],
			]
		];

		$args = [
			'before_page_number' => '<span class="ele-btn">',
			'after_page_number' => '</span>',
		];

		printf( '<div class="ele-pagination-wrap ele-d-flex ele-flex-wrap ele-align-items-center ele-w-100 ele-pagination-numeric numeric ele-justify-content-center"><nav class="navigation pagination" aria-label="Posts"><h2 class="screen-reader-text">%1$s</h2><div class="nav-links">%2$s</div></nav></div>', esc_html__('Posts navigation','elemetify'), wp_kses( paginate_links( $args ), $allowed_tags ) );
	}
}

/*
|--------------------------------------------------------------------------
| Trail Breadcrumb
|--------------------------------------------------------------------------
*/
if ( ! function_exists( 'elementify_breadcrumb' ) ) {
    /**
     * Display trail breadcrumb
     *
     * @return void
     */
    function elementify_breadcrumb() {
        $defaults = array(
            'show_browse'   => false,
            'echo'          => true
        );
        $args = apply_filters( 'breadcrumb_trail_args', $defaults );

        $breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

        if ( ! is_object( $breadcrumb ) )

            $breadcrumb = new Elementify\Inc\Breadcrumb_Trail( $args );

        return $breadcrumb->trail();
    }
}

/*--------------------------------------------------------------
# Google Fonts URL
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_get_fonts_url' ) ) {

	/**
	 * Get font url
	 *
	 * @return string
	 */
	function elementify_get_fonts_url() {

		$font_families = array(
            'Josefin+Sans:wght@100;200;300;400;500;600;700',
            'Nanum+Myeongjo:wght@400;700;800'
        );

        $fonts_url = add_query_arg( array(
            'family' => implode( '&family=', $font_families ),
            'display' => 'swap',
        ), 'https://fonts.googleapis.com/css2' );

        return esc_url_raw($fonts_url);
	}
}

/*--------------------------------------------------------------
# Add svg icon for the menu item if they have submenu items.
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_submenu_icon' ) ) {
    /**
     * Filters a menu item's starting output.
     * 
     * Append the dropdown arrow to links with submenus.
     * 
     * @param string   $item_output The menu item's starting HTML output.
     * @param WP_Post  $item        Menu item data object.
     * @return string
     */
    function elementify_submenu_icon( $item_output, $item, $depth, $args ) {
        $has_children = in_array( 'menu-item-has-children', $item->classes );
        if ( $has_children ) {
            $item_output = str_replace(
                '</a>',
                '<span class="ele-submenu-icon">' . elementify_get_icon_svg( 'ui', 'angle-down', 18 ) . '</span></a>',
                $item_output
            );
        }
        return $item_output;
    }
}
//add_filter( 'walker_nav_menu_start_el', 'elementify_submenu_icon', 10, 4 );

/*--------------------------------------------------------------
# Add classes in Sub Menu
--------------------------------------------------------------*/
if ( ! function_exists( 'elementify_submenu_classes' ) ) {
    /**
     * Filters a menu item's starting output.
     * 
     * Append the dropdown arrow to links with submenus.
     * 
     * @return string
     */
    function elementify_submenu_classes( $classes, $args, $depth ) {
        foreach ( $classes as $key => $class ) {
            if ( $class == 'sub-menu' ) {
                $classes[ $key ] = 'sub-menu ele-transition-normal';
            }
        }
        return $classes;
    }
}
//add_filter( 'nav_menu_submenu_css_class', 'elementify_submenu_classes', 10, 3 );

/**
 * Detects the social network from a URL and returns the SVG code for its icon.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param string $uri  Social link.
 * @param int    $size The icon size in pixels.
 * @return string
 */
function twenty_twenty_one_get_social_link_svg( $uri, $size = 24 ) {
	return Elementify\Inc\SVG_Icons::get_social_link_svg( $uri, $size );
}

/**
 * Displays SVG icons in the footer navigation.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of the menu. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string The menu item output with social icon.
 */
function twenty_twenty_one_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'footer' === $args->theme_location ) {
		$svg = twenty_twenty_one_get_social_link_svg( $item->url, 24 );
		if ( ! empty( $svg ) ) {
			$item_output = str_replace( $args->link_before, $svg, $item_output );
		}
	}

	return $item_output;
}

add_filter( 'walker_nav_menu_start_el', 'twenty_twenty_one_nav_menu_social_icons', 10, 4 );

add_filter(
	'nav_menu_link_attributes',
	function ($attr, $item, $args, $depth) {

		$class = 'ele-menu-link';

		if (! isset($attr['class'])) {
			$attr['class'] = '';
		}

		$attr['class'] .= ' ' . $class;

		$attr['class'] = trim($attr['class']);

		$attr['role'] = 'menuitem';

		if (isset($args->skip_ghost)) {
			$item_classes = '';

			if ($item && isset($item->classes) && is_array($item->classes)) {
				$item_classes = implode(' ', $item->classes);
			}

			if (
				strpos($item_classes, 'has-children') !== false
				||
				strpos($item_classes, 'has_children') !== false
			) {
				$attr['aria-haspopup'] = 'true';
				$attr['aria-expanded'] = 'false';
			}
		}

		return $attr;
	},
	5, 4
);

// /**
//  * Filters the CSS class(es) applied to a menu list element.
//  *
//  * @param array $classes Array of the CSS classes that are applied to the menu `<ul>` element.
//  * @return array
//  */
// add_filter( 'nav_menu_submenu_css_class', function( $classes ) {
//     return [ 'wp-block-navigation__container' ];
// } );
 
// /**
//  * Filters the CSS classes applied to a menu item's list item element.
//  * 
//  * @param array $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
//  * @return array
//  */
// add_filter( 'nav_menu_css_class', function( $classes ) {
//     $item_classes = [ 'wp-block-navigation-link' ];
//     if ( in_array( 'current-menu-item', $classes ) ) {
//         $item_classes[] = 'current-menu-item';
//     }
//     if ( in_array( 'menu-item-has-children', $classes ) ) {
//         $item_classes[] = 'has-child';
//     }
//     return $item_classes;
// } );
 
// /**
//  * Filters the HTML attributes applied to a menu item's anchor element.
//  * 
//  * @param array $atts The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
//  * @return array
//  */
// add_filter( 'nav_menu_link_attributes', function( $atts ) {
//     $atts['class'] = 'wp-block-navigation-link__content';
//     return $atts;
// } );
 
// /**
//  * Filters a menu item's title.
//  * 
//  * @param string $title The menu item's title.
//  * @return string
//  */
// add_filter( 'nav_menu_item_title', function( $title ) {
//     return '<span class="wp-block-navigation-link__label">' . $title . '</span>';
// } );
 
/**
 * Filters a menu item's starting output.
 * 
 * Append the dropdown arrow to links with submenus.
 * 
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @return string
 */
// add_filter( 'walker_nav_menu_start_el', function( $item_output, $item ) {
//     $has_children = in_array( 'menu-item-has-children', $item->classes );
//     if ( $has_children ) {
//         $item_output = str_replace(
//             '</a>',
//             '</a><span class="wp-block-navigation-link__submenu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" transform="rotate(90)"><path d="M8 5v14l11-7z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg></span>',
//             $item_output
//         );
//     }
//     return $item_output;
// }, 10, 2 );


if ( ! function_exists( 'elementify_blog_id' ) ) {
	/**
	 * Get blog id, support multisite
	 *
	 *
	 * @param null $slug
	 *
	 * @return string
	 */
	function elementify_blog_id( $slug = null ) {
		global $blog_id;

		$prefix = ( is_multisite() && $blog_id > 1 ) ? 'ele-blog-' . $blog_id : 'ele-blog';

		return $slug === null ? $prefix : $prefix . '-' . $slug;
	}
}

if ( ! function_exists( 'elementify_html_attributes' ) ) {
	/**
	 * Output html attributes
	 */
	function elementify_html_attributes() {

        $attrs = [
            'data-save-color-scheme' => 'no',
            'data-blog-id'  => elementify_blog_id(),
            'data-theme'    => isset( $_COOKIE['darkMode'] ) ? 'dark' : 'light'
        ];

		Utils::print_attribute_string( apply_filters( 'elementify_html_attributes', $attrs ) );
	}
}

/**
 * Always show footer widgets for customize builder
 *
 * @param bool   $active
 * @param string $section
 *
 * @return bool
 */
if ( ! function_exists( 'elementify_footer_widgets_show' ) ) {

    function elementify_footer_widgets_show( $active, $section ) {
        if ( strpos( $section->id, 'widgets-footer-' ) ) {
            $active = true;
        }
    
        return $active;
    }
}
add_filter( 'customize_section_active', 'elementify_footer_widgets_show', 15, 2 );


if ( ! function_exists( 'elementify_get_post_id' ) ) {
	/**
	 * Store the post ids.
	 *
	 * Since blog page takes the first post as its id,
	 * here we are storing the id of the post and for the blog page,
	 * storing its value via getting the specific page id through:
	 * `get_option( 'page_for_posts' )`
	 *
	 * @return false|int|mixed|string|void
	 */
	function elementify_get_post_id() {

		$post_id        = '';
		$page_for_posts = get_option( 'page_for_posts' );

		// For single post and pages.
		if ( is_singular() ) {
			$post_id = get_the_ID();
		} elseif ( ! is_front_page() && is_home() && $page_for_posts ) { // For the static blog page.

			$post_id = $page_for_posts;
		}

		// Return the post ID.
		return $post_id;
	}
}



if ( ! function_exists( 'elementify_get_scroll_reveal_attributes' ) ) {
	/**
	 * Output html attributes
	 */
	function elementify_get_scroll_reveal_attributes( $user_args = [] ) {

        $args = [
            'data-aos'          => 'fade-in',
            'data-aos-delay'    => '0',
            'data-aos-duration' => '1000',
            'data-aos-once'		=> 'false',
			'data-aos-easing'	=> 'ease-in-out'

        ];
        
        $merged_args = wp_parse_args( $user_args, $args );

		return apply_filters( 'elementify_get_scroll_reveal_attributes', $merged_args );
	}
}