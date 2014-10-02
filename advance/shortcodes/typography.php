<?php
function apollo13_shortcode_dropcaps($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'bg' => '',
    ), $atts));

    if($bg){
        $bg = ' ' . $bg;
    }
    return '<span class="'.esc_attr('a13-'.$code . $bg ).'">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'apollo13_shortcode_dropcaps');


function apollo13_shortcode_button($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'title'   => '',
        'url'     => false,
        'bgcolor' => false,
        'color'   => false,
        'class'   => 'default'
    ), $atts));
    if( $url ){
        $url = ' href="'.esc_url($url).'"';
    }
    if( $color ){
        $color = ' style="color: ' . $color . ';"';
    }
    if( $class ){
        $class = ' ' . $class;
    }
    else{
        if( $bgcolor ){
            $bgcolor = ' style="background-color: ' . $bgcolor . ';"';
        }
    }
    return '<a'.$url.' class="'.esc_attr('a13-'.$code.' '.$class) . '"' . $bgcolor . ' title="' . $title . '"><span' . $color .  '>' . do_shortcode(($content)) . '</span></a>';
}

add_shortcode('button', 'apollo13_shortcode_button');


function apollo13_shortcode_highlight($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'bg' => 'yellow',
    ), $atts));

    return '<span class="'.esc_attr('a13-'.$code . ' ' . $bg) . '">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'apollo13_shortcode_highlight');


function apollo13_shortcode_image($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'align' => false,
        'img'   => false,
        'url'   => false,
        'alt'   => false,
        'dimensions'   => false,
//        'border'=> 'on'
    ), $atts));
    if( ! $img ){
        return;
    }
    if( ! $url ){
        $url = $img;
    }

    $class = '';
    if( $align == 'left'){
        $class = 'alignleft';
    }
    elseif( $align == 'right'){
        $class = 'alignright';
    }
    elseif( $align == 'center'){
        $class = 'aligncenter';
    }
    else{
        $class = 'alignnone';
    }

//    if( $border == 'off' )
//        $class .= ' no-border';

    return '<a class="alpha-scope ' . $class . '" href="' . esc_url($url) . '" title="' . esc_attr($alt) . '" data-group="def" style="' . esc_attr($dimensions) . '">' .
            '<img src="' . esc_url($img) . '" alt="' . esc_attr($alt) . '" /><em class="cov"></em></a>';
}
add_shortcode('image', 'apollo13_shortcode_image');