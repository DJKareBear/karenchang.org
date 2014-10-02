<?php
/**
 * The template for displaying all pages.
 *
 */

get_header(); ?>
<?php if ( have_posts() ) : the_post(); ?>

    <article id="content">
        <header>
            <h1 id="begin-of-content" class="page-title"><?php the_title(); ?></h1>
            <?php echo a13_subtitle(); ?>
        </header>

        <?php a13_top_image_video(); ?>

        <div class="real-content">

            <?php the_content(); ?>

            <div class="clear"></div>

            <?php
                wp_link_pages( array(
                        'before' => '<div id="page-links">'.__fe('Pages: '),
                        'after'  => '</div>')
                );
            ?>
        </div>

    </article>

<?php endif; ?>

<?php get_footer(); ?>