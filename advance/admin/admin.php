<?php

/*
 * Scripts and styles added in admin area
 */
if(!function_exists('a13_admin_head')){
    function a13_admin_head(){
        // color picker
        wp_register_script('jquery-wheelcolorpicker', TPL_JS . '/jquery.wheelcolorpicker/jquery.wheelcolorpicker.js', array('jquery'), '1.3.2' );

        //main admin scripts
        wp_register_script('apollo13-admin', TPL_JS . '/admin-script.js',
            array(
                'jquery',   //dom operation
// Old media uploader
//                'media-upload',  //upload files
//                'thickbox',  //thickbox for file uploader
//                'plupload-all', //multi-upload in metaboxes
                'jquery-wheelcolorpicker', //color picker
                'jquery-ui-slider', //slider for font-size setting
                'jquery-ui-sortable' //sortable socials and metas
            ),
            THEME_VER
        );

        //scripts for shortcode generator
        wp_register_script('apollo13-shortcodes', TPL_JS . '/admin-shortcodes.js', array('apollo13-admin'), THEME_VER);
        wp_enqueue_script('apollo13-shortcodes');

        //options transfered to js files
        $admin_params = array(
            'colorDir' => TPL_JS . '/jquery.wheelcolorpicker'
        );
        wp_localize_script( 'apollo13-admin', 'AdminParams', $admin_params );

        //styles for uploading window
        wp_enqueue_style('thickbox');

        //some styling for admin options
        wp_enqueue_style( 'admin-css', TPL_CSS . '/admin-css.css', false, THEME_VER, 'all' );
        wp_enqueue_style( 'apollo-jquery-ui', TPL_CSS . '/ui-lightness/jquery-ui-1.8.19.custom.css', false, THEME_VER, 'all'  );

    }
}
/*
 * Scripts in admin_enqueue_scripts hook
 */
if(!function_exists('a13_admin_scripts')){
    function a13_admin_scripts(){
        wp_enqueue_media();
    }
}


/**
 * Adds menu with settings for theme
 */
if(!function_exists('a13_admin_pages')){
    function a13_admin_pages() {
        add_menu_page(TPL_ALT_NAME . ' theme', TPL_ALT_NAME . ' theme', 'manage_options', 'apollo13_settings', 'a13_show_settings_page', TPL_GFX . '/admin/icon.png' );
        add_submenu_page('apollo13_settings', __be( 'Main settings' ), __be( 'Main settings' ), 'manage_options', 'apollo13_settings', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Appearance' ), __be( 'Appearance' ), 'manage_options', 'apollo13_appearance', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Blog &amp; Archives' ), __be( 'Blog &amp; Archives' ), 'manage_options', 'apollo13_blog', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Fonts' ), __be( 'Fonts' ), 'manage_options', 'apollo13_fonts', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Works' ), __be( 'Works' ), 'manage_options', 'apollo13_cpt_work', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Galleries' ), __be( 'Galleries' ), 'manage_options', 'apollo13_cpt_gallery', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Social' ), __be( 'Social' ), 'manage_options', 'apollo13_social', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Contact page' ), __be( 'Contact page' ), 'manage_options', 'apollo13_contact', 'a13_show_settings_page');
        add_submenu_page('apollo13_settings', __be( 'Advance' ), __be( 'Advance' ), 'manage_options', 'apollo13_advance', 'a13_show_settings_page');
    }
}

/**
 * Settings page template
 */
if(!function_exists('a13_show_settings_page')){
    function a13_show_settings_page() {
        if (!current_user_can('manage_options')){
            wp_die( __be( 'You do not have sufficient permissions to access this page.' ) );
        }
        global $title;  //get the title of page from <title> tag
        //get options list for current settings page
        $func = $_GET['page'] . '_options';
        $option_list = $func();
        //get name of options we will change
        $options_name = str_replace( 'apollo13_', '', $_GET['page']);

        ?>
    <div class="wrap apollo13-settings apollo13-options metabox-holder" id="apollo13-settings">

        <h2><img id="a13-logo" src="<?php echo esc_url(TPL_GFX .'/admin/icon_big.png'); ?>" /><?php echo $title; ?></h2>
        <div class="apollo-help">
            <p><span>!</span><?php printf( __be( 'If you need any help check <a href="%s" target="_blank">documentation</a> or <a href="%s" target="_blank">visit our support forum</a>' ), esc_url(DOCS_LINK), 'https://customerpanel.me/support-forums/' ); ?></p>
        </div>
        <?php
        if ( isset( $_POST[ 'theme_updated' ] ) ) {
            ?>
            <div id="message" class="updated">
                <p><?php printf( __be( 'Template updated. <a href="%s">Visit your site</a> to see how it looks.' ), esc_url(home_url( '/' )) ); ?></p>
            </div>
            <?php
        }
        a13_print_options( $option_list, $options_name );
        ?>

    </div>
    <?php
    }
}

//flush if settings has changed (important for CUSTOM POST TYPES and their slugs)
function a13_flush_for_cpt(){
    if ( defined( 'APOLLO13_SETTINGS_CHANGED' ) && APOLLO13_SETTINGS_CHANGED ) {
        flush_rewrite_rules();
    }
}

add_action( 'init', 'a13_flush_for_cpt', 20 ); /* run after register of CPT's */
add_action( 'admin_menu', 'a13_admin_pages' );
add_action( 'admin_init', 'a13_admin_head' );
add_action( 'admin_enqueue_scripts', 'a13_admin_scripts');
