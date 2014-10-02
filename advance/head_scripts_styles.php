<?php

/*
 * Frontend theme scripts
 */
if(!function_exists('a13_theme_scripts')){
    function a13_theme_scripts($special_pass = false){
        global $apollo13;

        if((is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])) && !$special_pass){
            return;
        }

        /* We add some JavaScript to pages with the comment form
          * to support sites with threaded comments (when in use).
          */
        if ( is_singular() && get_option( 'thread_comments' ) ){
            wp_enqueue_script( 'comment-reply' );
        }

        $script_depends = array( 'apollo13-plugins' );

        //plugins used in theme (cheat sheet)
        wp_register_script('apollo13-plugins', TPL_JS . '/plugins.js',
            array('jquery'), //depends
            THEME_VER, //version number
            true //in footer
        );


        //APOLLO Slider
        wp_register_script( 'a13-slider', TPL_JS . '/a13-slider.js', array('jquery'), THEME_VER, true);

        //Jackbox lightbox
        wp_register_script( 'jackbox', TPL_JS . '/jackbox/js/jackbox-packed.min.js', array('jquery'), THEME_VER, true);

        //for audio posts and bg music
        wp_register_script('apollo13-audio', TPL_JS . '/audio/jquery.jplayer.min.js',array('jquery'), '2.2.0', true );

        $is_gallery         = defined('GALLERY_PAGE');
        $is_work            = defined('WORK_PAGE');
        $is_works_list      = defined('WORKS_LIST_PAGE');
        $is_gallery_list    = defined('GALLERIES_LIST_PAGE');

        //add masonry if needed
        if(
            (a13_is_post_list())
        ||  ($is_gallery && $apollo13->get_meta('_theme') == 'bricks')
        ||  ($is_works_list)
        ||  ($is_gallery_list)
        ){
            array_push($script_depends, 'jquery-masonry');
        }

        if(
            ($is_gallery && $apollo13->get_meta('_theme') == 'slider')
        ||  ($is_work && $apollo13->get_meta('_theme') == 'slider')

        ){
            array_push($script_depends, 'a13-slider');
        }

        //lightbox
        if($apollo13->get_option( 'advance', 'apollo_lightbox' ) == 'on'){
            array_push($script_depends, 'jackbox');
        }

        //options passed to JS
        $apollo_params = a13_js_parameters();
        //hand written scripts for theme
        wp_enqueue_script('apollo13-scripts', TPL_JS . '/script.js', $script_depends, THEME_VER, true );
        //transfer options
        wp_localize_script( 'apollo13-plugins', 'ApolloParams', $apollo_params );

        //remove admin bar margin in html element
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
}

if(!function_exists('a13_js_parameters')){
    function a13_js_parameters(){
        global $apollo13;

        $params = array(
            /* GLOBAL OPTIONS */
            'ajaxurl'           => admin_url('admin-ajax.php'),
            'jsurl'             => TPL_JS,
            'defimgurl'         => TPL_GFX . '/holders/photo.jpg',
            'validation_class'  => VALIDATION_CLASS,
            'load_more'         => __fe('Load more'),
        );

        if(defined('WORK_PAGE') ){
            if($apollo13->get_meta('_theme') == 'slider'){
                $params['fit_variant']          = $apollo13->get_meta( '_fit_variant' );
                $params['autoplay']             = $apollo13->get_meta( '_autoplay' );
                $params['random']               = $apollo13->get_meta( '_random' );
                $params['transition']           = $apollo13->get_meta( '_transition' );
                $params['transition_speed']     = $apollo13->get_option( 'cpt_work', 'transition_time' );
                $params['slide_interval']       = $apollo13->get_option( 'cpt_work', 'slide_interval' );
            }
        }
        elseif( defined('WORKS_LIST_PAGE') ){
            $params['brick_width']          = $apollo13->get_option( 'cpt_work', 'brick_width' );
            $params['brick_height']         = $apollo13->get_option( 'cpt_work', 'brick_height' );
            $params['brick_margin']         = $apollo13->get_option( 'cpt_work', 'brick_margin' );
        }
        elseif( defined('GALLERIES_LIST_PAGE') ){
            $params['brick_width']          = $apollo13->get_option( 'cpt_gallery', 'gl_brick_width' );
            $params['brick_height']         = $apollo13->get_option( 'cpt_gallery', 'gl_brick_height' );
            $params['brick_margin']         = $apollo13->get_option( 'cpt_gallery', 'gl_brick_margin' );
        }
        elseif( defined('GALLERY_PAGE') ){
            if($apollo13->get_meta('_theme') == 'slider'){
                $params['fit_variant']          = $apollo13->get_meta( '_fit_variant' );
                $params['autoplay']             = $apollo13->get_meta( '_autoplay' );
                $params['random']               = $apollo13->get_meta( '_random' );
                $params['transition']           = $apollo13->get_meta( '_transition' );
                $params['transition_speed']     = $apollo13->get_option( 'cpt_gallery', 'transition_time' );
                $params['slide_interval']       = $apollo13->get_option( 'cpt_gallery', 'slide_interval' );
            }
            elseif($apollo13->get_meta('_theme') == 'bricks'){
                $params['brick_width']          = $apollo13->get_option( 'cpt_gallery', 'brick_width' );
                $params['brick_height']         = $apollo13->get_option( 'cpt_gallery', 'brick_height' );
                $params['brick_margin']         = $apollo13->get_option( 'cpt_gallery', 'brick_margin' );
            }
        }
        //blog or archive
        elseif(a13_is_post_list()){
            $params['brick_width']          = $apollo13->get_option( 'blog', 'brick_width' );
            $params['brick_margin']         = $apollo13->get_option( 'blog', 'brick_margin' );
            $params['per_page']             = get_option( 'posts_per_page' );
        }

        //options transferred to js files
        return $params;
    }
}

/*
 * Adds CSS files to theme
 */
if(!function_exists('a13_theme_styles')){
    function a13_theme_styles($special_pass = false){
        if((is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])) && !$special_pass){
            return;
        }

        global $apollo13;

        $user_css_depends = array('main-style');

        //main styles
        wp_register_style( 'main-style', TPL_URI . '/style.css', false, THEME_VER);

        //for audio post format support
        wp_register_style('audio-css', TPL_CSS . '/pink.flag/jplayer.pink.flag.css', array('main-style'), THEME_VER);

        wp_register_style('jackbox', TPL_JS . '/jackbox/css/jackbox.min.css', false, THEME_VER);
        wp_enqueue_style('jackbox');

        wp_register_style('user-css', $apollo13->user_css_name(true), $user_css_depends, THEME_VER);
        wp_enqueue_style('user-css');
    }
}

/*
 * if there is something that can't be added in theme_styles or theme_scripts, add it here
 */
if(!function_exists('a13_theme_head')){
    function  a13_theme_head(){
        if(is_admin() || 'wp-login.php' == basename($_SERVER['PHP_SELF'])){
            return;
        }
        //add here your scripts and other things

        global $apollo13;

        //WEB FONTS LOADING
        $fonts = array( 'families' => array());
        //check if classic or google font is selected
        //colon in name = google font
        $temp = $apollo13->get_option('fonts', 'normal_fonts');
        (strpos($temp, ':') !== false)? array_push($fonts['families'], $temp) : false;
        $temp = $apollo13->get_option('fonts', 'titles_fonts');
        (strpos($temp, ':') !== false)? array_push($fonts['families'], $temp) : false;
        $temp = $apollo13->get_option('fonts', 'nav_menu_fonts');
        (strpos($temp, ':') !== false)? array_push($fonts['families'], $temp) : false;

        if(sizeof($fonts['families'])):
            $fonts = json_encode($fonts);
    ?>

    <script type="text/javascript">
        WebFontConfig = {
            google: <?php echo $fonts; ?>,
            active: function() {
                //tell listeners that fonts are loaded
                jQuery(document.body).trigger('webfontsloaded');
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                    '://ajax.googleapis.com/ajax/libs/webfont/1.0.31/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <?php
        endif;
    }
}

add_action( 'wp_print_scripts', 'a13_theme_scripts' );
add_action( 'wp_print_styles', 'a13_theme_styles' );
add_action( 'wp_head', 'a13_theme_head' );