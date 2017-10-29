<?php
/**
 * Index Page
 *
 * @package alex-zane
 * @since 1.0.0
 *
 */

add_action( 'widgets_init',       'alex_zane_register_widgets' );
add_action( 'wp_enqueue_scripts', 'alex_zane_enqueue_scripts');
add_action( 'wp_head',            'alex_zane_custom_styles', 8);
add_action( 'tgmpa_register',     'alex_zane_include_required_plugins' );

/*
 * Register sidebar.
 */
if ( ! function_exists('alex_zane_register_widgets' ) ) {
    function alex_zane_register_widgets() {
        // register sidebars
        register_sidebar(
            array(
                'id'            => 'sidebar-1',
                'name'          => esc_html__( 'Sidebar' , 'alex-zane'),
                'before_widget' => '<div class="wpc-widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="wpc-title-w">',
                'after_title'   => '</h3>',
                'description'   => esc_html__( 'Drag the widgets for sidebars.', 'alex-zane')
            )
        );
    }
}

/**
* @ return null
* @ param none
* @ loads all the js and css script to frontend
**/
if ( ! function_exists('alex_zane_enqueue_scripts' ) ) {
    function alex_zane_enqueue_scripts() {

        // general settings
        if( ( is_admin() ) ) { return; }


        // enqueue style
        wp_enqueue_style( 'bootstrap',                   ALEX_ZANE_URI . '/assets/css/bootstrap.min.css' );
        wp_enqueue_style( 'alex-zane_core-style',        ALEX_ZANE_URI . '/style.css' );
        wp_enqueue_style( 'alex-zane_style',             ALEX_ZANE_URI . '/assets/css/style.css' );
        wp_enqueue_style( 'alex-zane_fullPage',          ALEX_ZANE_URI . '/assets/css/jquery.fullPage.css' );
        wp_enqueue_style( 'font-awesome',      ALEX_ZANE_URI . '/assets/css/font-awesome.min.css' );
        wp_enqueue_style( 'photoswipe',        ALEX_ZANE_URI . '/assets/css/photoswipe.css' );
        wp_enqueue_style( 'alex-zane_default-skin',      ALEX_ZANE_URI . '/assets/css/default-skin/default-skin.css' );
        wp_enqueue_style( 'animate',           ALEX_ZANE_URI . '/assets/css/animate.css' );

        // woocommerce
        wp_enqueue_style( 'alex-zane-slick', ALEX_ZANE_URI . '/assets/css/slick.css' );
        wp_enqueue_style( 'alex-zane-woocommerce', ALEX_ZANE_URI . '/assets/css/ecommerce.css' );

        // add TinyMCE style
        add_editor_style();

        wp_enqueue_script( 'jquery-migrate' );

        // including jQuery plugins
        wp_localize_script('jquery-scripts', 'get',
            array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'siteurl' => get_template_directory_uri()
            )
        );

        if ( is_singular() ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // enqueue script
        wp_enqueue_script( 'jquery.fullPage',      ALEX_ZANE_URI  . '/assets/js/jquery.fullPage.min.js',        array( 'jquery' ), false, true );
        wp_enqueue_script( 'imagesloaded',  ALEX_ZANE_URI  . '/assets/js/imagesloaded.pkgd.min.js',  array( 'jquery' ), false, true );
        wp_enqueue_script( 'masonry',       ALEX_ZANE_URI  . '/assets/js/masonry.pkgd.min.js',              array( 'jquery' ), false, true );
        wp_enqueue_script( 'smooth-scroll', ALEX_ZANE_URI  . '/assets/js/website-smooth-scroll.js',     array( 'jquery' ), false, true );
        wp_enqueue_script( 'photoswipe',    ALEX_ZANE_URI  . '/assets/js/photoswipe.min.js',               array( 'jquery' ), false, true );
        wp_enqueue_script( 'photoswipe-ui', ALEX_ZANE_URI  . '/assets/js/photoswipe-ui-default.min.js',  array( 'jquery' ), false, true );
        wp_enqueue_script( 'alex-zane_js-main',          ALEX_ZANE_URI  . '/assets/js/main.js',                          array( 'jquery' ), false, true );
        wp_enqueue_style( 'dynamic-css', admin_url('admin-ajax.php').'?action=dynamic_css', '', '1.2');

        // woocommerce
        wp_enqueue_script( 'alex-zane_slick', ALEX_ZANE_URI  .'/assets/js/slick.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'alex-zane_mixitup', ALEX_ZANE_URI  .'/assets/js/mixitup.min.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'alex-zane_woocommerce', ALEX_ZANE_URI  .'/assets/js/ecommerce.js', array( 'jquery' ), false, true );

    }
}
/**
* Include plugins
**/
if ( ! function_exists('alex_zane_include_required_plugins' ) ) {
    function alex_zane_include_required_plugins() {

        $plugins = array(
            array(
                'name'                  => esc_html__( 'Contact Form 7', 'alex-zane' ), // The plugin name
                'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => esc_html__( 'WooCommerce', 'alex-zane' ), // The plugin name
                'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => esc_html__( 'Visual Composer', 'alex-zane' ), // The plugin name
                'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
                'source'                => 'http://demo.qodearena.com/projects/plugins/js_composer.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => esc_html__( 'Alex Zane Plugins', 'alex-zane' ), // The plugin name
                'slug'                  => 'alex-zane-plugins', // The plugin slug (typically the folder name)
                'source'                => ALEX_ZANE_F_PATH . '/plugins/alex-zane-plugins.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '2.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
        );

        // Change this to your theme text domain, used for internationalising strings

        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain'            => 'alex-zane',                 // Text domain - likely want to be the same as your theme.
            'default_path'      => '',                          // Default absolute path to pre-packaged plugins
            'menu'              => 'tgmpa-install-plugins',     // Menu slug
            'has_notices'       => true,                        // Show admin notices or not
            'is_automatic'      => true,                        // Automatically activate plugins after installation or not
            'message'           => '',                          // Message to output right before the plugins table
            'strings'           => array(
                'page_title'                                => esc_html__( 'Install Required Plugins', 'alex-zane' ),
                'menu_title'                                => esc_html__( 'Install Plugins', 'alex-zane' ),
                'installing'                                => esc_html__( 'Installing Plugin: %s', 'alex-zane' ), // %1$s = plugin name
                'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'alex-zane' ),
                'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'alex-zane' ), // %1$s = plugin name(s)
                'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'alex-zane' ), // %1$s = plugin name(s)
                'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'alex-zane' ),
                'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'alex-zane' ),
                'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'alex-zane' ),
                'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'alex-zane' ),
                'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'alex-zane' ), // %1$s = dashboard link
                'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );

        tgmpa( $plugins, $config );
    }
}

/*
 * Custom styles from Theme Options.
 */
if ( ! function_exists('alex_zane_custom_styles' ) ) {
    function alex_zane_custom_styles() {
        /* Get custom style options from CodeStar and print it into CSS. */
    }
}

if ( ! function_exists('alex_zane_get_post_likes' ) ) {
    function alex_zane_get_post_likes( $postID ) {
      $count_key = 'post_views_likes';
      $count = get_post_meta( $postID, $count_key, true );
      if( $count == '' ){
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return "0";
      }
      return $count;
    }
}

/*
 * Show count likes in admin panel.
 */
if ( ! function_exists('alex_zane_add_meta_box' ) ) {
    function alex_zane_add_meta_box() {
      add_meta_box( 'post_views_likes', 'Post likes', 'alex_zane_view_meta_box', 'post', 'normal', 'high' );
    }
}
add_action( 'add_meta_boxes', 'alex_zane_add_meta_box' );

/*
 * Show count likes form in admin panel.
 */
if ( ! function_exists('alex_zane_view_meta_box' ) ) {
    function alex_zane_view_meta_box() {
      global $post;
      $values = get_post_custom( $post->ID );

      $post_views_likes = isset( $values['post_views_likes'] ) ? esc_attr( $values['post_views_likes'][0] ) : '';
      ?>
        <label for="post_views_likes"><?php esc_html_e( 'Coutn likes', 'alex-zane' ); ?></label>
        <input type="text" name="post_views_likes" id="post_views_likes" value="<?php echo esc_attr($post_views_likes); ?>" />
      <?php  
    }
}
/*
 * Save count likes in admin panel.
 */
if ( ! function_exists('alex_zane_meta_box_save' ) ) {
    function alex_zane_meta_box_save( $post_id ) {
        if( isset( $_POST['post_views_likes'] ) ) {
          update_post_meta( $post_id, 'post_views_likes', $_POST['post_views_likes'] );
        }
    }
    add_action( 'save_post', 'alex_zane_meta_box_save' );
}

/*
 * Make like.
 */
if ( ! function_exists('alex_zane_post_like' ) ) {
    function alex_zane_post_like() {
      $post_id = $_POST['id'];
      $big_size = $_POST['size'];
      $count = get_post_meta( $post_id, 'post_views_likes', true );
      $likes = array();

      if( ! empty( $_COOKIE['likes'] ) ) {
        $likes = explode( ',', rawurldecode($_COOKIE['likes']) );
      }

      if( ! in_array($post_id, $likes) ) {
        $count++;
        update_post_meta( $post_id, 'post_views_likes', $count );
        $cookie = ( isset( $_COOKIE['likes'] ) ) ? $_COOKIE['likes'] . ',' . $post_id : $post_id;
        setcookie( 'likes', $cookie, time()+60*60*24*30, '/' );
      }
      if (!empty($big_size)) {
          print esc_html( $count );
      } else {
          print '<i class="fa fa-heart">' . esc_html( $count ) . '</i>';
      }
      wp_die();
    }
}
add_action( 'wp_ajax_alex_zane_post_like', 'alex_zane_post_like' );
add_action( 'wp_ajax_nopriv_alex_zane_post_like', 'alex_zane_post_like' );

if ( ! function_exists('alex_zane_comment_nav' ) ) {
    function alex_zane_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        ?>
        <nav class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'alex-zane' ); ?></h2>
            <div class="nav-links">
                <?php
                    if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'alex-zane' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'alex-zane' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
}

// cs framework missing
if (! function_exists('cs_get_option')) {
   function cs_get_option(){
    return '';
   }
   function cs_get_customize_option(){
    return '';
   }
}

// woocommerce missing
if ( !class_exists('WooCommerce') ) {
    function is_shop() { return null; }
    function is_cart() { return null; }
    function is_product() { return null; }
    function is_checkout() { return null; }
}