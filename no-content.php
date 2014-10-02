<?php
/**
 * Used in 404 page, sitemap and no search results page
 */
    global $empty_error_msg;
?>
<?php if( is_404() || isset($empty_error_msg)) : ?>
    <span class="info-404"><a href="javascript:history.go(-1)"><?php _fe( 'Go back' ); ?></a> <?php _fe( 'or use Site Map below:' ); ?></span>

<?php else:
    //site map page content
    if ( have_posts() ){
        while ( have_posts() ){
            the_post();
            the_content();
        }
    }
endif;
    ?>
    <ul>
        <?php
        if ( has_nav_menu( 'header-menu' ) ){
            echo '<li><strong>' . __fe('Main navigation') . '</strong>';
            wp_nav_menu( array(
                    'container'       => false,
                    'link_before'     => '',
                    'link_after'      => '',
                    'menu_class'      => '',
                    'theme_location'  => 'header-menu' )
            );
            echo '</li>';
        }

        wp_list_pages(array('title_li' => __fe('<strong>Pages</strong>')));
        wp_list_categories(array('title_li' => __fe('<strong>Categories</strong>')));


        /* List albums */
        global $wp_query, $apollo13;

        $original_query = $wp_query;

        $args = array(
            'posts_per_page'      => -1,
            'offset'              => -1,
            'post_type'           => CUSTOM_POST_TYPE_WORK,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        );

        //make query for albums
        $wp_query = new WP_Query( $args );

        if ($wp_query->have_posts()) :
            echo '<li>' . __fe('<strong>Works</strong>');
            echo '<ul>';

            while ( have_posts() ) :
                the_post();
                echo '<li><a href="'. get_permalink() . '">' . get_the_title() . '</a></li>';
            endwhile;

            echo '</ul>';
            echo '</li>';
        endif;

        //restore previous query
        $wp_query = $original_query;
        wp_reset_postdata();
        ?>
    </ul>
