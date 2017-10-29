<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     2.0.0
 */
?>
<main class="e-main-content products">
    <div class="e-tab-filter-wrapper">
        <div class="e-tab-filter">
            <ul class="e-filters">
                <li class="placeholder">
                    <a data-type="all" href="#">all</a> <!-- selected option on mobile -->
                </li>
                <li class="filter"><a class="selected" href="#0" data-type="all">all</a></li>
                <?php foreach ( get_terms( 'product_cat', '' ) as $item ): ?>
                    <li class="filter" data-filter=".<?php echo esc_attr( $item->slug ); ?>"><a href="#0" data-type="<?php echo esc_attr( $item->slug ); ?>"><?php echo esc_html( $item->name ); ?></a></li>
                <?php endforeach; ?>
            </ul> <!-- e-filters -->
        </div> <!-- e-tab-filter -->
    </div> <!-- e-tab-filter-wrapper -->
    <section class="e-gallery">
        <ul class="sort">
