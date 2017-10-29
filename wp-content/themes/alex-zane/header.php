<?php
/**
 * Header template.
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no" />
        <?php
        if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
            $alex_zane_folio_favicon = cs_get_option( 'site_favico_16x16' );
            if( $alex_zane_folio_favicon ) :
                $url_icon = wp_get_attachment_url( $alex_zane_folio_favicon );
            else:
                $url_icon = get_template_directory_uri().'/assets/images/favicon.png';
            endif;
        ?>
        <link rel="shortcut icon" href="<?php echo esc_url( $url_icon ); ?>" type="image/x-icon">
        <?php } ?>
        <?php wp_head(); ?>
  </head>
<body <?php body_class(); ?>>

<div class="loader"></div>

<!-- Container -->
<main class="container">
<div>
    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay transition">
        <div class="mobile-menu">
            <i class="fa fa-times fa-2x"></i>
        </div>
        <?php
        if ( has_nav_menu( 'primary-menu' ) ) {
            wp_nav_menu(
                array(
                    'container'      => '',
                    'items_wrap'     => '<ul class="mobile-menu-content">%3$s</ul>',
                    'theme_location' => 'primary-menu',
                    'depth'          => 3
                )
            );
        } else {
            print '<div class="mobile-menu-content">' . esc_html__( 'Please register Top Navigation from', 'alex-zane' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'alex-zane' ) . '</a></div>';
        }
        ?>
    </div>
    <!-- /Mobile Menu -->

    <?php
    global $post;

    $banner_img_show = $banner_show = $style_header = $fixed_header = $page_id = $page_options = $show_banner = $alt_title = $alt_subtitle = $alt_subtitle = $alt_image = '';

    //is singular
    $page_id = !is_singular() ? get_option( 'page_for_posts' ) : $post->ID;

    //is single
    $page_id = is_single() ? get_option( 'page_for_posts' ) : $page_id;

    //is product page
    $page_id = is_product() ? $post->ID : $page_id;

    //is shop page
    $page_id = is_shop() ? get_option( 'woocommerce_shop_page_id' ) : $page_id;

    if ( $page_id ) {
        $page_options = get_post_meta( $page_id , '_custom_page_options', true );
        if (!empty($page_options)) {
            $show_banner = $page_options['show_banner'];
            $alt_title = $page_options['alt_title'];
            $alt_subtitle = $page_options['alt_subtitle'];
            $alt_image = $page_options['alt_image'];
        }
    }

    $g_alt_img = cs_get_option( 'alt_image');

    //is show banner
    if ($show_banner && ($alt_title || $alt_subtitle || $alt_image || $g_alt_img) ) {
        $banner_show = true;
    }

    $fixed_header = (!empty($page_options['fixed_header']) ) ? $page_options['fixed_header'] : '';
    if ( empty($page_options['style_header']) && !$banner_show && !is_shop() && !is_product() && !is_cart() && !is_checkout() ) {
        $style_header = 'dark';
    }

    $image_bg = (!empty($alt_image)) ? wp_get_attachment_image_url($alt_image,'full') : wp_get_attachment_image_url($g_alt_img,'full');
    $image_bg = !empty($image_bg) ? $image_bg : get_template_directory_uri() . '/assets/images/parallax2.jpg';

    //is show image banner
    if ($show_banner && $image_bg) {
        $banner_img_show = true;
    }

    // fixed header
    if ( $fixed_header || cs_get_option('fixed_header') ) {
        $fixed_header = 'fixed';
    }


    ?>

    <!-- Header -->
    <header class="transition header <?php echo esc_attr($style_header); ?> <?php echo esc_attr($fixed_header); ?>">

        <?php if ( $banner_img_show || is_shop() || is_product() || is_cart() || is_checkout() ) { ?>
            <div class="parallax">
                <img src="<?php echo esc_attr($image_bg); ?>" alt="" class="alex-bg-image">
                <div class="darker"></div>
            </div>
        <?php } ?>

        <div class="main-menu">
            <div id="logo">
                <?php $alex_zane_logo_image = cs_get_option( 'logo_image');  ?>

                <a class="logo" href="<?php echo esc_url(home_url( '/' )); ?>">
                    <?php if(!empty($alex_zane_logo_image)){ ?>
                        <img class="f-logo" src="<?php echo esc_attr( $alex_zane_logo_image ); ?>" alt="<?php echo esc_attr( get_bloginfo("name") ); ?>">
                    <?php } else { ?>
                        <img class="f-logo" src="<?php echo esc_attr( get_stylesheet_directory_uri() ) ?>/assets/images/logo.svg" alt="<?php echo esc_attr( get_bloginfo("name") ); ?>" >
                    <?php } ?>
                </a>
            </div>

            <!-- Menu -->
            <nav id="menu" class="col-md-10 col-sm-10">
                <?php
                if ( has_nav_menu( 'primary-menu' ) ) {

                    wp_nav_menu(
                        array(
                            'container'      => '',
                            'items_wrap'     => '<ul class="hidden-xs">%3$s</ul>',
                            'theme_location' => 'primary-menu',
                            'depth'          => 3
                        )
                    );
                } else {
                    print '<div class="hidden-xs">' . esc_html__( 'Please register Top Navigation from', 'alex-zane' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'alex-zane' ) . '</a></div>';
                }
                ?>
                <div class="mobile-menu col-xs-2 pull-right visible-xs">
                    <i class="fa fa-bars fa-2x"></i>
                </div>
            </nav>
            <!-- /Menu -->
        </div>

        <?php if ( $banner_show ): ?>
            <div class="item-category">
                <?php if ($alt_title) { ?>
                    <h1><?php echo esc_html( $alt_title ); ?></h1>
                <?php } else {
                    the_title( '<h1>', '</h1>' );
                } ?>

                <?php if ($alt_subtitle) { ?>
                    <p><?php echo esc_html( $alt_subtitle ); ?></p>
                <?php } ?>

                <div class="border">
                    <div></div>
                </div>
            </div>
        <?php elseif ( function_exists('is_woocommerce') && ( is_woocommerce() || is_cart() || is_checkout() ) ): ?>
            <div class="item-category">
                <?php if ( is_shop() ) {
                    echo '<h1>', get_the_title( $page_id ), '</h1>';
                } else {
                    the_title( '<h1>', '</h1>' );
                } ?>

                <div class="border">
                    <div></div>
                </div>
            </div>
        <?php endif; ?>


    </header>
    <!-- /Header -->
