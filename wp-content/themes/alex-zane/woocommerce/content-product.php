<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$filter = array();
$filter_class = 'mix ';
$post_category = wp_get_post_terms($product->id, 'product_cat');
foreach ( $post_category as $category ) {
    $filter[] = $category->slug;
}
$filter_class .= implode(' ', $filter );


// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	echo '<div class="e-fail-message">'. esc_html__( 'No results found', 'alex-zane' ) .'</div>';
	return;
}
?>
<li <?php post_class( esc_attr( $filter_class ) ); ?>>
	<div class="e-single-item">
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="e-customization">
			<div class="e-btns">
				<div class="transition">
					<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link btn"><em><?php esc_html_e( 'view details', 'alex-zane' ); ?></em></a>
				</div>
				<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
					sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s"><em>%s</em></a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( isset( $quantity ) ? $quantity : 1 ),
						esc_attr( $product->id ),
						esc_attr( $product->get_sku() ),
						esc_attr( isset( $class ) ? $class : 'add-to-cart btn' ),
						esc_html( $product->add_to_cart_text() )
					),
					$product );
				?>
			</div>
		</div>
		<div class="e-item-info transition">
			<b><a href="<?php the_permalink(); ?>" class="transition"><?php the_title(); ?></a></b>
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>
	</div>
</li>
