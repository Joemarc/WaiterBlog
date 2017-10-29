<?php
/**
 * Footer template.
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
// get footer text
$footer_text = cs_get_option( 'footer_text');

// footer options
$classes = '';
$page_options = get_post_meta( $page_id , '_custom_page_options', true );
if (!empty($page_options)) {
    $classes = $page_options['fixed_footer'] ? ' fixed' : '';
    $classes .= $page_options['style_footer'] == 'light' ? ' white' : '';
}

if ( !is_shop() ) {
    if ( !has_shortcode( get_the_content(), 'alex_vertical_slider' ) ) {
      $classes .= ' enable_bg';
    }
}

?>
    <!-- Back to top button -->
    <a href="#" class="back-top btn">
        <i class="fa fa-angle-up fa-2x"></i>
    </a>

    <!-- START FOOTER -->
    <footer id="footer" class="wpc-footer <?php echo esc_attr($classes); ?>">
        <?php if (! empty($footer_text) ){ ?>
            <?php echo wp_kses_post( wpautop( do_shortcode($footer_text) ) ); ?>
        <?php } else { ?>
            <?php esc_html('&copy; Alex Zane ' . date('Y') . '. All rights reserved.'); ?>
        <?php } ?>
    </footer>
    <!-- END FOOTER -->

</div>
</main>
<!-- /Container -->

<?php wp_footer(); ?>
</body>
</html>
