<?php
global $apollo13;
$media_width = (int)$apollo13->get_option( 'blog', 'brick_width' ) -80;//80 = masonry brick padding(left + right)

echo '<div class="post-meta">';
    echo a13_date_and_author();
    a13_post_comments('<span class="separator">/</span>');
echo '</div>';

echo '<h2 class="post-title"><a href="'. esc_url(get_permalink()) . '">' . get_the_title() . '</a></h2>';
a13_top_image_video( true, $media_width );

?>

<div class="real-content">

    <?php
        if($apollo13->get_option('blog', 'excerpt_type') == 'auto' || is_search()){
            if(strpos($post->post_content, '<!--more-->')){
                the_content(''/*__fe('Read more' )*/);
            }
            else{
                the_excerpt();
            }
        }
        //manual post cutting
        else{
            the_content(''/*__fe('Read more' )*/);
        }
    ?>
    <div class="clear"></div>
</div>

<?php echo a13_posted_in(); ?>