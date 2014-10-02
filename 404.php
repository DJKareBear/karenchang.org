<?php
/**
Template Name: Sitemap
 * The template for displaying 404 pages (Not Found) and Sitemap.
 *
 */

global $empty_error_msg;
$not_styled_page = is_404() || isset($empty_error_msg);
$title = '';

/* 404 or empty archive/search*/
if($not_styled_page){
    define('NO_STYLED_PAGE', true);
    $title = isset($empty_error_msg)? $empty_error_msg : __fe( 'Error 404' );
}
//sitemap
else{
    $title = get_the_title();
}
get_header(); ?>

    <article id="content">
        <header>
            <h1 id="begin-of-content" class="page-title"><?php echo $title; ?></h1>
            <?php echo $not_styled_page? '' : a13_subtitle(); ?>
        </header>

        <?php $not_styled_page? false : a13_top_image_video(); ?>

        <div class="real-content">
            <?php get_template_part( 'no-content'); ?>
            <div class="clear"></div>
        </div>
    </article>

<?php get_footer(); ?>