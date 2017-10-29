<?php
/**
 * Index Page
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */
get_header(); 

// show/hide sidebar
$show_sidebar = cs_get_option('show_sidebar');
if ( $show_sidebar || !class_exists( 'CSFramework' ) ) {
    $base_column = 'col-md-9 is_sidebar';
    $right_column = 'col-md-3 is_sidebar';
} else {
    $base_column = ' col-md-12';
}
?>



<!--Content-->
<div class="content no_vc">

    <!-- Row -->
    <div class="row">
        
        <div class="<?php echo esc_attr( $base_column );?> single-content">
            <?php if ( have_posts() ) { ?>
            <?php while ( have_posts() ) : the_post();

                // get count like
                $count = get_post_meta( $post->ID, 'post_views_likes', true ); 
                // get comments
                $count_comments = get_comments_number(); ?>

                <p class="blog-post-meta col-sm-10 col-sm-push-1"><?php the_time( get_option( 'date_format' ) ); ?></p>

                <p class="col-sm-2">
                    <a href="#" class="alex-zane-like-it" data-post="<?php echo esc_attr( $post->ID ); ?>" data-url="<?php echo esc_attr( admin_url('admin-ajax.php') ); ?>">
                        <i class="fa fa-heart"><?php echo esc_html( $count ); ?></i>
                    </a>
                    <i class="fa fa-comments"><?php echo esc_html( $count_comments ); ?></i>
                </p>
                <article class="col-sm-10 col-sm-push-1">

                    <?php the_title( '<h2 class="section-heading">', '</h2>' ); ?>
                    <?php the_content(); ?>

                    <?php 
                    $arg_pager = array(
                            'before'           => '<div class="pager_post">',
                            'after'            => '</div>',
                            'echo'             => 1
                        );
                    wp_link_pages( $arg_pager );
                    ?>

                    <div class="like col-sm-10 col-sm-push-1">
                        <a href="#" class="alex-zane-like-it" data-size="big3" data-post="<?php echo esc_attr( $post->ID ); ?>" data-url="<?php echo esc_attr( admin_url('admin-ajax.php') ); ?>">
                            <i class="fa fa-heart like-heart fa-3"></i>
                        </a>
                        <span class="like-count"><?php echo esc_html( $count ); ?></span> 
                    </div>

                    <?php $categories = apply_filters( 'the_category_list', get_the_category( $post->ID ), $post->ID );
                        if ( $categories ) { ?>
                        <div class="alex-zane-tag col-sm-12">
                            <?php echo '<h3>' . esc_html__( 'categories', 'alex-zane' ) . '</h3>';
                            foreach ($categories as $key => $category) {
                                $name_category = $category->name;
                                $link_category = get_term_link( $category );
                                echo '<a href="' . esc_url( $link_category ) . '"><i class="fa fa-tag"> ' . esc_html( $name_category ) .'</i></a>';
                            } ?>
                        </div>
                    <?php } ?>

                    <?php if ( get_the_tags( $post->ID ) ) { ?> 
                        <div class="alex-zane-tag col-sm-12">
                        <?php echo '<h3>' . esc_html__( 'tags', 'alex-zane' ) . '</h3>';
                        foreach (get_the_tags( $post->ID ) as $tag) {
                            $name_tag = $tag->name;
                            $link_tag = get_term_link( $tag );

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
                <?php } ?>

                

                <?php if ( comments_open() ) { ?>

                        <?php comments_template( '', true ); ?>

                <?php } ?>

                

            <?php endwhile; ?>
            <?php } ?>

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
