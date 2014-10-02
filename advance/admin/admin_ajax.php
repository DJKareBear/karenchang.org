<?php
add_action('wp_ajax_a13_font_details', 'a13_font_details');

function a13_font_details() {
    $searched_font = $_POST['font'];
    $google_fonts = json_decode(file_get_contents( TPL_ADV_DIR . '/inc/google-font-json' ));

    $font = '';
    $found = false;

    foreach( $google_fonts->items as $font ) {
        if($font->family == $searched_font){
            $found = true;
            break;
        }

    }

    echo  json_encode($found? $font :  false);

    die(); // this is required to return a proper result
}