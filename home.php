<?php
/**
 * The Template for displaying blog.
 *
 */

get_header(); ?>

<article id="content" class="clearfix">
    <header id="begin-of-content">
        <?php a13_blog_info_bar() ?>
    </header>

    <div id="col-mask">

        <div id="post-list">

            <?php
            /* Run the loop to output the post.
             * If you want to overload this in a child theme then include a file
             * called loop-single.php and that will be used instead.
             */
            get_template_part( 'loop' );
            ?>
            <?php a13_blog_nav(); ?>

        </div>

        <?php get_sidebar(); ?>

    </div>

</article>

<?php get_footer(); ?>