<?php
/**
 * The Sidebar
 *
 */
    global $apollo13;

	if( defined('FULL_WIDTH') && FULL_WIDTH ){
        //no sidebar
    }
	else{
        $sidebar = a13_has_active_sidebar();
        if($sidebar !== false){
            echo '<aside id="secondary" class="widget-area" role="complementary">';
            dynamic_sidebar( $sidebar );
            echo '</aside>';
        }
    }