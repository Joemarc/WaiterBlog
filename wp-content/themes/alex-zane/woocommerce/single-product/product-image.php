<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$gallery = $product->get_gallery_attachment_ids(); ?>

<div class="product-images">
    <div class="main-img-slider">
        <?php if ( has_post_thumbnail() || count( $gallery ) > 0 ) {
            if ( has_post_thumbnail() ) {
                $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<figure><a href="%s" data-size="600x450">%s</a></figure>', $props['url'], get_the_post_thumbnail() ), $post->ID );
            }
            if ( count( $gallery ) > 0 ) {
                foreach ( $gallery as $item ) {
                    $image_url = wp_get_attachment_image_url( $item, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
                    echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<figure><a href="%s" data-size="600x450"><img src="%s" alt="" /></a></figure>', $image_url, $image_url ), $post->ID );
                }
            }
        } else {
            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<figure><img src="%s" data-size="600x450" alt="%s" /></figure>', wc_placeholder_img_src(), __( 'Placeholder', 'alex-zane' ) ), $post->ID );
        } ?>
    </div>
    <?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>