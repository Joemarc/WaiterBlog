<?php
/**
 *
 * Default page
 * @since 1.0
 * @version 1.2.0
 *
 */

global $post;

$right_column = '';
$show_sidebar = cs_get_option('show_sidebar');
if (!$show_sidebar) {
    $base_column = ' col-md-12';
} else {
    $base_column = 'col-md-9 is_sidebar';
    $right_column = 'col-md-3 is_sidebar';
}
?>

<div class="no_vc row">
    <div class="<?php echo esc_attr( $base_column );?>">
        <?php
        // get count like
        $count = get_post_meta( $post->ID, 'post_views_likes', true );
        // get comments
        $count_comments = get_comments_number(); ?>

        <p class="blog-post-meta col-sm-10 col-sm-push-1"><?php the_time( get_option( 'date_format' ) ); ?></p>

        <p class="col-sm-2">
            <i class="fa fa-comments"><?php echo esc_html( $count_comments ); ?></i>
        </p>
        <article class="col-sm-10 col-sm-push-1">

            <?php the_post_thumbnail(); ?>

            <?php the_title( '<h2 class="section-heading">', '</h2>' );
            the_post_thumbnail( );
            the_content();

            $arg_pager = array(
                'before'           => '<div class="pager_post">',
                'after'            => '</div>',
                'echo'             => 1
            );
            wp_link_pages( $arg_pager );
            ?>

            <?php $categories = apply_filters( 'the_category_list', get_the_category( $post->ID ), $post->ID );
            if ( $categories ) { ?>
                <div class="alex-zane-tag col-sm-12">
                    <?php echo '<h3>' . esc_html__( 'categories', 'alex-zane' ) . '</h3>';
                    foreach ($categories as $key => $category) {
                        $name_category = $category->name;
                        $link_category = get_term_link( $category->term_id );
                        echo '<a href="' . esc_url( $link_category ) . '"><i class="fa fa-tag"> ' . esc_html( $name_category ) .'</i></a>';
                    } ?>
                </div>
            <?php } ?>

            <?php if ( get_the_tags( $post->ID ) ) { ?>
                <div class="alex-zane-tag col-sm-12">
                    <?php echo '<h3>' . esc_html__( 'tags', 'alex-zane' ) . '</h3>';
                    foreach (get_the_tags( $post->ID ) as $tag) {
                        $name_tag = $tag->name;
                        $link_tag = get_term_link( $tag->term_id );

                        echo '<a href="' . esc_url( $link_tag ) . '"><i class="fa fa-tag"> ' . esc_html( $name_tag ) .'</i></a>';
                    } ?>
                </div>
            <?php } ?>

        </article>

        <?php $socials_share_options = cs_get_option('socials_share_options');
        if (!empty($socials_share_options)) { ?>
            <!-- Social Icons -->
            <div class="social-icons col-sm-10 col-sm-push-1">
                <h3> <?php esc_html_e('Share','alex-zane'); ?></h3>

                <?php foreach ($socials_share_options as $social) {
                    $ar_icon = explode('-',$social['social_icon']); ?>
                    <a href="<?php echo esc_url($social['social_link']); ?>" class="btn <?php echo esc_attr($ar_icon[1]); ?>">
                        <i class="<?php echo esc_attr($social['social_icon']); ?> fa-2x"></i>
                    </a>
                <?php } ?>
            </div>
            <!-- /Social Icons -->
        <?php }

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() ) {
            comments_template( '', true );
        } ?>

    </div>

    <!-- START SIDEBAR -->
    <?php if ( $show_sidebar || !class_exists( 'CSFramework' ) ) { ?>
        <div class="<?php echo esc_attr($right_column);?>">
            <?php get_sidebar(); ?>
        </div>
    <?php } ?>
    <!-- END SIDEBAR -->

</div>
