<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 */
global $apollo13;
?>


<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php
if ( ! have_posts() ):
    global $empty_error_msg;
    $empty_error_msg = true; //set to anything
    ?>
    <div class="real-content empty-blog">

    <?php
    _fe( 'Apologies, but no results were found for the requested archive.' );
    get_template_part( 'no-content');
    ?>

    </div>
    <?php

else:

    //fix for front page pagination
    //used in ajax call for pages like http://page.com/blog/page/2/
    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    echo '<div id="masonry-parent" data-page="'.esc_attr($paged).'">';

    while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>

            <?php get_template_part( 'content', get_post_format() ); ?>

		</div>

    <?php endwhile; // End the loop. Whew.

    echo '</div>'; //#masonry-parent

endif;