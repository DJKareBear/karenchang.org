<?php
/**
 * The Template for displaying all single posts.
 *
 */

global $apollo13;
get_header(); ?>

<?php the_post(); ?>

<article id="content" class="clearfix">
    <header id="begin-of-content">
        <div class="post-meta"><?php echo a13_date_and_author(); a13_post_comments('<span class="separator">/</span>'); ?></div>
        <?php a13_blog_info_bar(get_the_title()) ?>
    </header>

    <div id="col-mask">

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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

            <?php echo a13_posted_in(); ?>

            <?php if($apollo13->get_option( 'blog', 'author_info' ) == 'on'): ?>
            <div class="about-author clearfix">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
                <div class="author-inside">
                    <strong class="author-name"><?php the_author(); ?>
                        <?php
                        $u_url = get_the_author_meta( 'user_url' );
                        if( ! empty( $u_url ) ){
                            echo '<a href="' . esc_url($u_url) . '" class="url">(' . $u_url . ')</a>';
                        }
                        ?></strong>
                    <div class="author-description">
                        <?php the_author_meta( 'description' ); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php comments_template( '', true ); ?>
        </div>



        <?php get_sidebar(); ?>

    </div>

</article>

<?php get_footer(); ?>
