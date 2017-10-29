<?php
/**
 * Index Page
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
if ( ! function_exists('alex_zane_comment' ) ) {
	function alex_zane_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;  ?>
			<li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-entry news-comments'); ?>>
				<article class="comment">
					<div class="user-avatar">
						<?php echo get_avatar( $comment, '80', '', '', array('class'=>'img-circle') ); ?>
					</div>
					<div class="comment-content">
						<h5 class="name"><?php echo get_comment_author_link(); ?></h5>
						<div class="comment-meta">
							<span class="post-date">
							<?php echo esc_html( get_comment_time( get_option( 'date_format' ) ) ); ?>
							</span>/
							<?php 
							echo get_comment_reply_link(
								array_merge( $args, array(
									'reply_text'    => esc_html__( 'Reply' ,'alex-zane'),
									'reply_to_text' => esc_html__( 'Reply to %s','alex-zane' ),
									'depth' => $depth,
									'max_depth' => $args['max_depth']
								)
							));
							?> 
						</div>
						<?php $trimmed = trim( get_comment_text(), " ");
							  echo wp_kses_post( wpautop($trimmed) );
						?>
						
					</div>
				</article>
			
	<?php
	} // end function alex_zane_comment
}

if (!function_exists('alex__the_content')) {

    function alex_zane_the_content($limit, $read_more) {
      $content = explode(' ', get_the_content(), $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content);
      } else {
        $content = implode(" ",$content);
      }
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content);
      return $content;
    }
}



/**
 * Disable woocommerce breadcrumb
 * @param $args array
 * @return bool
 */
function woocommerce_breadcrumb( $args = array() ) {
	return false;
}

/**
 * Disable woocommerce title on pages
 * @return bool
 */
function woocommerce_show_page_title_callback() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'woocommerce_show_page_title_callback' );

/**
 * Disable woocommerce sidebar
 * @return bool
 */
function woocommerce_get_sidebar() {
	return false;
}

/**
 * WooCommerce Product Summary Box
 *
 * @see woocommerce_template_single_rating()
 * @see woocommerce_template_single_price()
 * @see woocommerce_template_single_excerpt()
 */
add_action( 'alex_zane_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'alex_zane_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'alex_zane_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
