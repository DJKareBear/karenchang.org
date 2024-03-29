<?php


/*
 * Register custom post type for special use
 */
if(!function_exists('a13_cpt_gallery_register')){
    function a13_cpt_gallery_register(){

        $labels = array(
            'name' =>           __be( 'Galleries' ),
            'singular_name' =>  __be( 'Gallery' ),
            'add_new' =>        __be( 'Add New' ),
            'add_new_item' =>   __be( 'Add New Gallery' ),
            'edit_item' =>      __be( 'Edit Gallery' ),
            'new_item' =>       __be( 'New Gallery' ),
            'view_item' =>      __be( 'View Gallery' ),
            'search_items' =>   __be( 'Search Galleries' ),
            'not_found' =>      __be( 'Nothing found' ),
            'not_found_in_trash' => __be( 'Nothing found in Trash' ),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'query_var' => true,
            'menu_position' => 5,
            'rewrite' =>  array('slug' => CUSTOM_POST_TYPE_GALLERY_SLUG),
            'supports' => array( 'title','thumbnail' ),
        );


        register_post_type( CUSTOM_POST_TYPE_GALLERY , $args );

        $type_labels = array(
            'name' => __be( 'Galleries Types' ),
            'singular_name' => __be( 'Gallery type' ),
            'search_items' =>  __be( 'Search Galleries Types' ),
            'popular_items' =>  __be( 'Popular Galleries Types' ),
            'all_items' => __be( 'All Galleries Types' ),
            'parent_item' => __be( 'Parent Gallery type' ),
            'parent_item_colon' => __be( 'Parent Gallery type:' ),
            'edit_item' => __be( 'Edit Gallery type' ),
            'update_item' => __be( 'Update Gallery type' ),
            'add_new_item' => __be( 'Add New Gallery type' ),
            'new_item_name' => __be( 'New Gallery type Name' ),
            'menu_name' => __be( 'Gallery type' ),
        );

        register_taxonomy(CPT_GALLERY_TAXONOMY, array(CUSTOM_POST_TYPE_GALLERY),
            array(
                "hierarchical" => false,
                "label" => __be('Galleries Types'),
                "labels" => $type_labels,
                "rewrite" => true,
                'show_admin_column' => true
            )
        );
    }
}



/*
 * Making cover for galleries in Galleries list
 */
if(!function_exists('a13_make_gallery_image')){
    function a13_make_gallery_image( $gallery_id, $thumb_size, $hidden = false ){
        if(empty($gallery_id)){
            $gallery_id = get_the_ID();
        }
        if ( has_post_thumbnail($gallery_id) ) {
            $src = wp_get_attachment_image_src( get_post_thumbnail_id ( $gallery_id ), $thumb_size );
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

add_action( 'init', 'a13_cpt_gallery_register' );