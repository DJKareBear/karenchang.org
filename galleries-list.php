<?php

define( 'GALLERIES_LIST_PAGE', true );
get_header();

?>

<?php
    /**
     * The loop that displays items.
     *
     */

    global $wp_query, $paged, $apollo13, $genre_template;


    //settings
    $original_query = $wp_query;
    $offset = -1;
    $paged = 0;
    $per_page = -1;

    $args = array(
        'posts_per_page'      => $per_page,
        'offset'              => $offset,
        'post_type'           => CUSTOM_POST_TYPE_GALLERY,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
    );

    if($genre_template === true){
        $term_slug = get_query_var('term');
        if( ! empty( $term_slug ) ){
            $args[CPT_GALLERY_TAXONOMY] = $term_slug;
            $term_name = get_term_by( 'slug', $term_slug, CPT_GALLERY_TAXONOMY);
        }
    }

    //make query for albums
    $wp_query = new WP_Query( $args );

    /* If there are no posts to display, such as an empty archive page */
    if ( ! have_posts() ) :
?>
    <article id="content" class="clearfix">
        <div class="real-content empty-blog">

            <?php
            _fe( 'Apologies, but no results were found for the requested archive.' );
            get_template_part( 'no-content');
            ?>

        </div>
    </article>
<?php
    /* If there ARE some posts */
    elseif ($wp_query->have_posts()) :
        if($genre_template !== true){
            //prepare filter
            $terms = get_terms(CPT_GALLERY_TAXONOMY, 'hide_empty=1');

            if( count( $terms ) ):
                echo '<ul id="genre-filter" >';

                echo '<li class="label">'.__fe( 'Filter' ).'</li>';
                echo '<li class="selected" data-filter="__all"><a href="' . a13_current_url() . '">' . __fe( 'All' ) . '</a></li>';
                foreach($terms as $term) {
                    echo '<li data-filter="'.$term->slug.'"><a href="'.esc_url(get_term_link($term)).'">' . $term->name . '</a></li>';
                }

                echo '</ul>';
            endif;
        }

        //class with info about resizing items
        //needed cause of type of hover effect
        $no_resize_param = '';
        $temp = $apollo13->get_option('cpt_gallery', 'gl_brick_height' );
        // if 0 then height if fluid
        if(!($temp === '0px' || $temp === '0')){
            $no_resize_param = ' data-no-resize="true"';
        }

        $zoom_class = $apollo13->get_option('cpt_gallery', 'gl_hover_zoom' ) == 'on'? ' hov-zoom' : '';

        echo '<div id="a13-galleries"'.$no_resize_param.' class="'.$apollo13->get_option('cpt_gallery', 'hover_type' ).$zoom_class.'">';

        while ( have_posts() ) :
            the_post();

            //get album genres
            $terms = wp_get_post_terms(get_the_ID(), CPT_GALLERY_TAXONOMY, array("fields" => "all"));
            $pre = 'data-genre-';
            $suf = '="1" ';
            $genre_string = '';

            if( count( $terms ) ):
                foreach($terms as $term) {
                    $genre_string .= $pre.$term->slug.$suf;
                }
            endif;

            echo '<a class="g-item" href="'.esc_url(get_permalink()).'" id="gallery-' . get_the_ID() . '" ' . $genre_string . '>';
            echo '<i>'.a13_make_work_image($post->ID, 'gallery-cover' ).'</i>';
            echo '<em class="cov"><span>' . get_the_title() . '</span></em>';
            echo '</a>';
        endwhile;

        echo '</div>';
    endif;


    //restore previous query
    $wp_query = $original_query;
    wp_reset_postdata();
?>


<?php get_footer(); ?>