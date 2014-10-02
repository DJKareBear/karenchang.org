<?php
/**
 * The Template for displaying portfolios.
 *
 */
define( 'GALLERY_PAGE', true );

if(defined('CALLED_FROM_FRONT_PAGE')){
    //reset cause we called the_post earlier
    rewind_posts();
}

if ( have_posts() ){
    the_post();
    if(post_password_required()){
        define( 'A13_PAGE_PROTECTED', true );
        get_header();
        echo '<article>';
        echo get_the_password_form();
        echo '</article>';
        get_footer();
    }
    else{
        global $apollo13;

        get_header();

        echo a13_make_media_collection();
//        <div id="a13-gallery">
//            <a class="g-item" href="http://wordpress.com/image.jpg">
//                <i>
//                    <img src="thumb.jpg" alt="">
//                </i>
//            </a>
//        </div>

        //shows all meta fields of post in multi dimensional array
//        var_dump($custom = get_post_custom($post->ID));

        get_footer();
    } //end of else (password_protected)
}