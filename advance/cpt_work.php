<?php


/*
 * Register custom post type for special use
 */
if(!function_exists('a13_cpt_work_register')){
    function a13_cpt_work_register(){
        global $apollo13;

        $labels = array(
            'name' =>           __be( 'My Works' ),
            'singular_name' =>  __be( 'Work' ),
            'add_new' =>        __be( 'Add New' ),
            'add_new_item' =>   __be( 'Add New Work' ),
            'edit_item' =>      __be( 'Edit Work' ),
            'new_item' =>       __be( 'New Work' ),
            'view_item' =>      __be( 'View Work' ),
            'search_items' =>   __be( 'Search Works' ),
            'not_found' =>      __be( 'Nothing found' ),
            'not_found_in_trash' => __be( 'Nothing found in Trash' ),
            'parent_item_colon' => ''
        );

        $supports = array( 'title','thumbnail','editor' );
        if($apollo13->get_option('cpt_work', 'comments') == 'on')
            array_push($supports, 'comments');

        $args = array(
            'labels' => $labels,
            'public' => true,
            'query_var' => true,
            'menu_position' => 5,
            'rewrite' =>  array('slug' => CUSTOM_POST_TYPE_WORK_SLUG),
            'supports' => $supports,
        );

        register_post_type( CUSTOM_POST_TYPE_WORK , $args );

        $genre_labels = array(
            'name' => __be( 'Works Genres' ),
            'singular_name' => __be( 'Genre' ),
            'search_items' =>  __be( 'Search Genres' ),
            'popular_items' =>  __be( 'Popular Genres' ),
            'all_items' => __be( 'All Genres' ),
            'parent_item' => __be( 'Parent Genre' ),
            'parent_item_colon' => __be( 'Parent Genre:' ),
            'edit_item' => __be( 'Edit Genre' ),
            'update_item' => __be( 'Update Genre' ),
            'add_new_item' => __be( 'Add New Genre' ),
            'new_item_name' => __be( 'New Genre Name' ),
            'menu_name' => __be( 'Genre' ),
        );

        register_taxonomy(CPT_WORK_TAXONOMY, array(CUSTOM_POST_TYPE_WORK),
            array(
                "hierarchical" => false,
                "label" => __be('Works Genres'),
                "labels" => $genre_labels,
                "rewrite" => true,
                'show_admin_column' => true
            )
        );

    }
}



/*
 * Making cover for works in Works list
 */
if(!function_exists('a13_make_work_image')){
    function a13_make_work_image( $work_id, $thumb_size, $hidden = false ){
        if(empty($work_id)){
            $work_id = get_the_ID();
        }
        if ( has_post_thumbnail($work_id) ) {
            $src = wp_get_attachment_image_src( get_post_thumbnail_id ( $work_id ), $thumb_size );
            $src = $src[0];
        }
        else{
            $src = TPL_GFX . '/holders/photo.jpg';
        }

        $style = '';
        if($hidden){
            $style = ' style="visibility: hidden;"';
        }

        return '<img src="'.esc_url($src).'" alt=""'.$style.' />';
    }
}


/*
 * For printing categories(taxonomies) of custom type post
 */
if(!function_exists('a13_cpt_work_posted_in')){
    function a13_cpt_work_posted_in( $separator = '<span>/</span>' ) {
        $term_list = wp_get_post_terms(get_the_ID(), CPT_WORK_TAXONOMY, array("fields" => "all"));;
        $count_terms = count( $term_list );
        $html = '';
        $iter = 1;
        if( $count_terms ){
            foreach($term_list as $term) {
                $html .= '<a href="' . esc_url(get_term_link($term)) . '">' . $term->name . '</a>';
                if( $count_terms != $iter ){
                    $html .= $separator;
                }
                $iter++;
            }
        }

        return $html;
    }
}



/*
 * Collection of photos
 */
if(!function_exists('a13_make_media_collection')){
    function a13_make_media_collection(){
        global $apollo13;

        $ID             = get_the_ID();
        $theme          = $apollo13->get_meta('_theme', $ID);
        $is_slider      = $theme == 'slider';
        $is_scroller    = $theme == 'scroller';
        $is_items       = $theme == 'full_photos';
        $is_bricks      = $theme == 'bricks';
        $is_work        = defined( 'WORK_PAGE' );
        $is_gallery     = defined( 'GALLERY_PAGE' );
        $slides         = array();
        $media_count    = get_post_meta($ID, '_image_count', true);

        //default gallery settings
        $a_desc               = trim( get_post_meta($ID, '_description', true) );

        if( $is_gallery ){
            $thumb_size = 'gallery-bricks';
        }
        elseif( $is_work ){
            if($is_slider){
                $thumb_size = 'work-slider-image';
            }
            else{
                $thumb_size = 'work-image';
            }
        }

        if( $media_count ){
            //sorting order
            $order_asc = true;
            if(($is_work || $is_gallery) && get_post_meta($ID, '_order', true) == 'DESC')
                $order_asc = false;

//            ASC
//            for( $i = 1; $i <= $media_count; $i++ ){
//            DESC
//            for( $i = $media_count; $i >= 1; $i-- ){
            for( $i = ($order_asc? 1 : $media_count); ($order_asc? ($i <= $media_count) : ($i >= 1)); ($order_asc? $i++ : $i--) ){
                //image or video?
                $switch = get_post_meta($ID, '_image_or_video_' . $i, true);

                if( $switch ){
                    //make name for hidden meta field
                    $media = get_post_meta($ID, '_' . $switch, true);

                    if( $media ){
                        //local item settings VS gallery settings
                        //image | video
                        $type               = substr( $switch, 5, 5 );

                        $caption            = trim( get_post_meta($ID, '_post_image_name_' . $i, true) );
                        $desc               = trim( get_post_meta($ID, '_post_image_desc_' . $i, true) );
                        $desc               = (empty($desc))? nl2br($a_desc) : nl2br($desc);

                        if($type == 'image'){
                            $attachment_id      = trim( get_post_meta($ID, '_post_image_id_' . $i, true) );

                            //if this is for single work slider we are not using full width image
                            if($is_slider && $is_work && !empty($attachment_id)){
                                $temp = wp_get_attachment_image_src($attachment_id, 'work-slider-image');
                                if($temp){
                                    $media = $temp[0];
                                }
                            }


                            $link               = trim( get_post_meta($ID, '_post_image_link_' . $i, true) );

                            $bg_color           = trim( get_post_meta($ID, '_bg_color_' . $i, true) );
                            $thumb              = $media;
                            $lbthumb            = $media;
                            //can get normal thumb ?
                            if(!empty($attachment_id)){
                                //main thumbnail
                                if(!$is_items){ //we use full width photos for thumbs
                                    $thumb = wp_get_attachment_image_src($attachment_id, $thumb_size);
                                    if(!$thumb){
                                        $thumb = $media;
                                    }
                                    else{
                                        $thumb = $thumb[0];
                                    }
                                }

                                //lightbox thumb
                                $lbthumb = wp_get_attachment_image_src($attachment_id, 'sidebar-size');
                                if(!$lbthumb){
                                    $lbthumb = $media;
                                }
                                else{
                                    $lbthumb = $lbthumb[0];
                                }
                            }


                            //fill array with values
                            $slides[] = array(
                                'type'              => $type,
                                'image'             => $media,
                                'thumb'             => $thumb,
                                'lbthumb'           => $lbthumb,
                                'title'             => $caption,
                                'desc'              => $desc,
                                'bg_color'          => $bg_color,
                                'link'              => $link,
                            );
                        }

                        elseif($type == 'video'){
                            $v_arr = a13_detect_movie($media);
                            $thumb = a13_get_movie_thumb_src($v_arr, trim( get_post_meta($ID, '_video_thumb_' . $i, true) ) );
                            $movie_link  = a13_get_movie_link($v_arr, array('width' => 500, 'height' => 500));
                            $autoplay = trim( get_post_meta($ID, '_video_autoplay_' . $i, true) );

                            //fill array with values
                            $slides[] = array(
                                'type'              => $type,
                                'image'             => $movie_link,
                                'thumb'             => $thumb,
                                'lbthumb'           => $thumb,
                                'title'             => $caption,
                                'desc'              => $desc,
                                'autoplay'          => $autoplay,
                                'movie_type'        => $v_arr['type'],
                                'link'              => $media
                            );
                        }
                    }
                }
            }

            if( sizeof($slides) ){
                $html = '';
                $desc_html = '';
                foreach($slides as $key => $slide){
                    //description
                    if(!empty($slide['desc'])){
                        $desc_html .= '<div id="g_d_'.$key.'">'.$slide['desc'].'</div>';
                    }

                    //element
                    $html .= "\n".'<a class="' .
                        (($is_bricks || $is_slider)? 'g-item' : '' ) .
                        ($slide['type'] != 'image'? ' '.$slide['type'] : (empty($slide['link'])?'' : ' link')) .
                        '" href="'.esc_url(empty($slide['link'])? $slide['image'] : $slide['link']).'"'.
                        ' data-group="gallery"'.
                        ((!empty($slide['autoplay']) && $slide['autoplay'] == '1')? ' data-autoplay="true"' : '') .
                        (!empty($slide['title'])? (' data-title="'.esc_attr(str_replace('"',"'",$slide['title'])).'"') : '') .
                        (!empty($slide['lbthumb'])? (' data-thumbnail="'.esc_attr($slide['lbthumb']).'"') : '') .
                        (!empty($slide['desc'])? (' data-description="#g_d_'.$key.'"') : '') .
                        (!empty($slide['movie_type'])? (' data-movie_type="'.esc_attr($slide['movie_type']).'"') : '') .
                        (!empty($slide['bg_color'])? (' data-bg_color="'.esc_attr($slide['bg_color']).'"') : '') .
                        ' data-image="'.esc_attr($slide['image']).'"' .
                        ' data-type="'.esc_attr($slide['type']).'"' .
                        '>'.
                        ($is_bricks? '<i>' : '' ) .
                        '<img src="'.esc_url($slide['thumb']).'" alt="" />' .
                        ($is_bricks? '</i>' : '' ) .
                        '</a>';
                }

                $no_resize_param = '';
                if($is_bricks){
                    //class with info about resizing items
                    //needed cause of type of hover effect
                    $temp = $apollo13->get_option('cpt_gallery', 'brick_height' );
                    // if 0 then height if fluid
                    if(!($temp === '0px' || $temp === '0')){
                        $no_resize_param = ' data-no-resize="true"';
                    }
                }
                if($is_bricks || $is_slider){
                    $zoom_class = $apollo13->get_option('cpt_gallery', 'hover_zoom' ) == 'on'? ' hov-zoom' : '';
                    $html = '<div id="a13-gallery"'.$no_resize_param.' class="'.esc_attr($apollo13->get_meta('_theme').' '.$apollo13->get_meta('_hover_type')).$zoom_class.'">'.$html.'</div>';
                    if($is_work){
                        $html = '<div class="in-post-slider">'.$html.'</div>';
                    }
                    return $html . '<div id="g_descs">'.$desc_html.'</div>';
                }
                elseif($is_scroller){
                    return '<div id="a13-scroll-pan"><div id="a13-work-slides" class="clearfix '.$apollo13->get_meta('_theme').'">'.$html.'</div></div>'.
                        '<div id="g_descs">'.$desc_html.'</div>';
                }
                else{
                    return '<div id="a13-full-photos">'.$html.'</div>'.
                        '<div id="g_descs">'.$desc_html.'</div>';
                }

            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}


add_action( 'init', 'a13_cpt_work_register' );