<?php
/**
 * The main tamplate file.
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
get_header(); 

//style blog
$style_blog = cs_get_option('style_blog');
$style_blog = $style_blog != '' ? ' ' . $style_blog . ' col-md6 col-sm-6 col-xs-12' : '';


// show/hide sidebar
$right_column = '';
$show_sidebar = cs_get_option('show_sidebar');
if ( $show_sidebar || !class_exists( 'CSFramework' ) ) {
	$base_column = 'col-md-9 is_sidebar';
	$right_column = 'col-md-3 is_sidebar';
} else {
	$base_column = ' col-md-12';
}


?>
<!--Content-->
<div class="content">

	<div class="row">

	<!-- Row -->
		<div class="<?php echo esc_attr( $base_column );?> add-bg">
			<div class="masonry row transition no_vc">
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<!-- Blog Item -->
						<?php 
						$format = get_post_format();
						$format = ( $format === false) ? 'default' : $format;
						$classes_post =  'format-' . get_post_format() . ' blog-content-item';
						$classes_post .= $style_blog ? ' ' . $style_blog . ' col-md6 col-sm-6 col-xs-12' : ' blog-item';
						?>

						<div <?php post_class( esc_attr( $classes_post) ); ?>>

							<?php 
							if( is_sticky() ){  ?>
							<i title="<?php esc_html_e( 'Sticky Post', 'alex-zane' ); ?>" class="sticky-icon fa fa-thumb-tack fa-2x"></i>
							<?php }
							// get template format
							get_template_part('template-parts/content', $format);
							?>
							

						</div>
						<!-- /Blog Item -->
					<?php endwhile; ?>
					
					

				<?php else : ?>

					<div id="wpc-empty-result">
						<p><?php esc_html_e('Sorry, no posts matched your criteria.', 'alex-zane' ); ?></p>
						<?php get_search_form( true ); ?>
					</div>

				<?php endif; ?>
			</div>

			<ul class="pager">
				<?php if ( get_previous_posts_link() ){ ?>
				<li class="prev">
					<?php previous_posts_link( esc_html__('Previous','alex-zane') ); ?>
				</li>
				<?php } ?>
				<?php if ( get_next_posts_link() ){ ?>
				<li class="next">
					<?php next_posts_link( esc_html__('Next', 'alex-zane') ); ?>
				</li>
				<?php } ?>
			</ul>
		</div>

		<!-- START SIDEBAR -->
		<?php if ( $show_sidebar || !class_exists( 'CSFramework' ) ) { ?>
		<div class="<?php echo esc_attr($right_column);?>">
			<?php get_sidebar(); ?>
		</div>
		<?php } ?>
        <!-- END SIDEBAR -->

	</div>
	
</div>
<?php get_footer();
