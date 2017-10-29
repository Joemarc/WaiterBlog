<?php
/**
 *
 * Quote
 * @since 1.0
 * @version 1.2.0
 *
 */
$style_blog = cs_get_option('style_blog');
// get count like
$count = get_post_meta( $post->ID, 'post_views_likes', true ); 
// get comments
$count_comments = get_comments_number();

if (get_the_post_thumbnail()) { ?>
<a href="<?php the_permalink(); ?>">
		<?php if (!$style_blog) { ?><div class="col-md6 col-sm-6 col-xs-12"><?php } ?>
		<div class="image_thumbnail">
			<?php the_post_thumbnail('',
					array('class'=>'alex-bg-image') ); ?>
		<?php if (!$style_blog) { ?></div><?php } ?>
	</div>
</a>
<?php } ?>
<?php 
	$class_post_info = !$style_blog ? ' col-md6 col-sm-6 col-xs-12' : '';
	$class_post_info = !get_the_post_thumbnail() ? ' col-md12 col-sm-12 col-xs-12' : $class_post_info;
?>
<div class="post-info<?php echo esc_attr( $class_post_info ); ?>">
	
	<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="date"><?php the_time('j');?>
		<span><i class="fa fa-calendar fa-2x">
			</i><?php the_time('F Y') ?>
		</span>
	</a>

	<?php the_title( 
		'<a href="'. esc_url( get_the_permalink() ) .'"><h3>', '</h3></a>' ); ?>

	<?php 
		echo alex_zane_the_content(
			apply_filters( 'excerpt_length', 28 ),
			esc_html__('read more','alex-zane')
		);
	?>

	<div class="text-left col-xs-4">
		<a href="#" class="alex-zane-like-it" data-post="<?php echo esc_attr( $post->ID ); ?>" data-url="<?php echo esc_attr( admin_url('admin-ajax.php') ); ?>">
			<i class="fa fa-heart"><?php echo esc_html( $count ); ?></i>
		</a>
		<i class="fa fa-comments"><?php echo esc_html( $count_comments ? $count_comments : '' ); ?></i>
	</div>

	<div class="text-right col-xs-8 col-lg-8">
		<a href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'read', 'alex-zane' ); ?>
			<i class="fa fa-arrow-right"></i>
		</a>
	</div>

</div>