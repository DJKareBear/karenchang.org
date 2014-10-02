<?php
/**
 * The template for displaying all pages.
 *
 */

global $apollo13;
get_header(); ?>
<?php if ( have_posts() ) : the_post(); ?>

    <div id="a13-revo-slider">
        <?php putRevSlider( $apollo13->get_option( 'settings', 'fp_revoslider' ) ); ?>
    </div>

<?php endif; ?>

<?php get_footer(); ?>