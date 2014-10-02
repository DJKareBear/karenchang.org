<?php
function apollo13_shortcode_column($atts, $content = null, $code) {
	return '<div class="'.$code.'">' . do_shortcode($content) . '</div>';
}

add_shortcode('left50', 'apollo13_shortcode_column');
add_shortcode('right50', 'apollo13_shortcode_column');

add_shortcode('left33', 'apollo13_shortcode_column');
add_shortcode('center33', 'apollo13_shortcode_column');
add_shortcode('right33', 'apollo13_shortcode_column');

add_shortcode('left25', 'apollo13_shortcode_column');
add_shortcode('right25', 'apollo13_shortcode_column');
add_shortcode('center25', 'apollo13_shortcode_column');

add_shortcode('left20', 'apollo13_shortcode_column');
add_shortcode('right20', 'apollo13_shortcode_column');
add_shortcode('center20', 'apollo13_shortcode_column');

function apollo13_shortcode_clear() {
   return '<div class="clear"></div>';
}
add_shortcode('clear', 'apollo13_shortcode_clear');

function apollo13_shortcode_line() {
   return '<div class="line">&nbsp;</div>';
}
add_shortcode('line', 'apollo13_shortcode_line');