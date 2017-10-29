<?php
/**
 * The template includes necessary functions for theme.
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */

if ( ! isset( $content_width ) ) {
    $content_width = 1200; /* pixels */
}

defined( 'ALEX_ZANE_URI' )    or define( 'ALEX_ZANE_URI',    get_template_directory_uri() );
defined( 'ALEX_ZANE_T_PATH' ) or define( 'ALEX_ZANE_T_PATH', get_template_directory() );
defined( 'ALEX_ZANE_F_PATH' ) or define( 'ALEX_ZANE_F_PATH', ALEX_ZANE_T_PATH . '/inc' );

// Framework integration
// ------------------------------------------
require_once ALEX_ZANE_T_PATH . '/custom/inc.php';

if ( ! function_exists('alex_zane_after_setup' ) ) {
    function alex_zane_after_setup() {

        load_theme_textdomain( 'alex-zane', get_template_directory() . '/languages' );

        register_nav_menus(
            array(
                'primary-menu'  => esc_html__( 'Primary menu', 'alex-zane' ),
            )
        );

        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );

        add_image_size( 'alex_zane_gallery_1', 570, 380, true);
        add_image_size( 'alex_zane_gallery_2', 570, 570, true);
        add_image_size( 'alex_zane_gallery_3', 570, 356, true);
        add_image_size( 'alex_zane_gallery_4', 570, 321, true);

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
          'search-form',
          'comment-form',
          'comment-list',
          'gallery',
          'caption',
        ) );

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
          'aside',
          'audio',
          'gallery',
          'image',
          'video',
          'quote',
          'link',
        ) );

        // WooCommerce Support
        add_theme_support( 'woocommerce' );
    }
}
add_action( 'after_setup_theme', 'alex_zane_after_setup' );


if ( ! function_exists('alex_zane_change_tags' ) ) {
    function alex_zane_change_tags( $c ){
        $tags = array('<ul>');
        foreach( (array) $c as $k => $v ){
            $tags[] = '<li><i class="fa fa-tag"></i>' . $v . '</li>';
        }
        $tags[] = '</ul>';
        return $tags;
    }
}
add_filter( "term_links-post_tag", 'alex_zane_change_tags' );