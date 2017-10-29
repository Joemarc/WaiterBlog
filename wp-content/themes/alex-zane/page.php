<?php
/**
 * Index Page
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
get_header();

$right_column = '';
$show_sidebar = cs_get_option('show_sidebar');
if (!$show_sidebar) {
	$base_column = ' col-md-12';
} else {
	$base_column = 'col-md-9 is_sidebar';
	$right_column = 'col-md-3 is_sidebar';
}

while ( have_posts() ): 
    the_post();
	$content = get_the_content();
    
	if (stristr($content, 'vc_') && class_exists('Vc_Manager') && class_exists('ALEXZANE_Plugins')): ?>
		<div class="content vc-content">
			<?php the_content(); ?> 
		</div> 
	<?php else: ?>
		<div class="content">
			<?php if ( is_cart() || is_checkout() ) {
				get_template_part( 'template-parts/page', 'shop' ); 
			} else {
                get_template_part( 'template-parts/page', 'blog' );
            } ?>
		</div>
	<?php endif;

endwhile;
get_footer();
