<?php
/**
 * Theme custom helper functions
 *
 * @package Bizness
 */
class Bizness_Helper {

    /**
     * Returns the attachment object.
     *
     * @static
     * @access public
     * @see https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
     * @param string $url URL to the image.
     * @return int|string Numeric ID of the attachement.
     */
    public static function get_image_id( $url ) {
        global $wpdb;
        if ( empty( $url ) ) {
            return 0;
        }

        $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid = %s;", $url ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery

        if ( ! empty( $attachment ) ) {
            return $attachment[0];
        }
        return 0;
    }

    /**
     * Returns an array of the attachment's properties.
     *
     * @param string $url URL to the image.
     * @return array
     */
    public static function bizness_get_image_from_url( $url ) {
        $image_id = self::get_image_id( $url );
        $image    = wp_get_attachment_image_src( $image_id, 'full' );

        return [
            'url'       => $image[0],
            'width'     => $image[1],
            'height'    => $image[2],
            'thumbnail' => $image[3],
        ];
    }

    /**
     * Get an array of posts.
     *
     * @static
     * @access public
     * @param array $args Define arguments for the get_posts function.
     * @return array
     */
    public static function get_posts( $args ) {
        if ( is_string( $args ) ) {
            $args = add_query_arg(
                [
                    'suppress_filters' => false,
                ]
            );
        } elseif ( is_array( $args ) && ! isset( $args['suppress_filters'] ) ) {
            $args['suppress_filters'] = false;
        }

        // Get the posts.
        // TODO: WordPress.VIP.RestrictedFunctions.get_posts_get_posts.
        $posts = get_posts( $args );

        // Properly format the array.
        $items = [];
        foreach ( $posts as $post ) {
            $items[ $post->ID ] = $post->post_title;
        }
        wp_reset_postdata();

        return $items;
    }

    /**
     * Get an array of publicly-querable taxonomies.
     *
     * @static
     * @access public
     * @return array
     */
    public static function get_taxonomies() {
        $items = [];

        // Get the taxonomies.
        $taxonomies = get_taxonomies(
            [
                'public' => true,
            ]
        );

        // Build the array.
        foreach ( $taxonomies as $taxonomy ) {
            $id           = $taxonomy;
            $taxonomy     = get_taxonomy( $taxonomy );
            $items[ $id ] = $taxonomy->labels->name;
        }

        return $items;
    }

    /**
     * Get an array of publicly-querable post-types.
     *
     * @static
     * @access public
     * @return array
     */
    public static function get_post_types() {
        $items = [];

        // Get the post types.
        $post_types = get_post_types(
            [
                'public' => true,
            ],
            'objects'
        );

        // Build the array.
        foreach ( $post_types as $post_type ) {
            $items[ $post_type->name ] = $post_type->labels->name;
        }

        return $items;
    }

    /**
     * Get an array of terms from a taxonomy.
     *
     * @static
     * @access public
     * @param string|array $taxonomies See https://developer.wordpress.org/reference/functions/get_terms/ for details.
     * @return array
     */
    public static function get_terms( $taxonomies ) {
        $items = [];

        // Get the post types.
        $terms = get_terms( $taxonomies );

        // Build the array.
        foreach ( $terms as $term ) {
            $items[ $term->term_id ] = $term->name;
        }

        return $items;
    }

    /**
     * Returns an array of navigation menus.
     *
     * @access public
     * @param string $value_field The value to be stored in options. Accepted values: id|slug.
     * @return array
     */
    public static function get_nav_menus( $value_field = 'id' ) {
        $choices   = [];
        $nav_menus = wp_get_nav_menus();

        foreach ( $nav_menus as $term ) {
            $choices[ 'slug' === $value_field ? $term->slug : $term->term_id ] = $term->name;
        }

        return $choices;
    }

    /**
     * Returns sidebar layout value
     *
     * @param string $sidebar default sidebar value is none
     * @return string $sidebar
     */
    public static function get_sidebar_layout( $sidebar = 'none' ) {

        global $post;

        // Check meta first to override and return (prevents filters from overriding meta)
        $sidebar = get_post_meta( $post->ID, 'elementify_framework_sidebar_layout', true );
        if ( $sidebar && $sidebar != 'default' ) {
            return $sidebar;
        }
        if ( is_single() ) {
            $sidebar = get_theme_mod( 'post_sidebar_layout', 'right' );
        } elseif ( is_page() ) {
            $sidebar = get_theme_mod( 'elementify_framework_page_sidebar_layout_layout', 'right' );
        }
        else {
            $sidebar = get_theme_mod( 'blog_sidebar_layout', 'right' );
        }

        return $sidebar;
    }


}

/**
 * Returns posts.
 *
 * @since Newsup 1.0.0
 */
if (!function_exists('newsup_get_posts')):
    function newsup_get_posts($number_of_posts, $category = '0')
    {

        $ins_args = array(
            'post_type' => 'post',
            'posts_per_page' => absint($number_of_posts),
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true
        );

        $category = isset($category) ? $category : '0';
        if (absint($category) > 0) {
            $ins_args['cat'] = absint($category);
        }

        $all_posts = new WP_Query($ins_args);

        return $all_posts;
    }

endif;
