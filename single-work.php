<?php
/**
 * The Template for displaying portfolio items.
 *
 */
    global $apollo13;
    define( 'WORK_PAGE', true );

    the_post();

    if(post_password_required()){
        define( 'A13_PAGE_PROTECTED', true );
        get_header();

        echo '<article>';
        echo get_the_password_form();
        echo '</article>';

        get_footer();
    }
    else{
        get_header();
?>

<article id="content" class="clearfix">
    <header id="begin-of-content">
        <div class="post-meta"><?php echo ($apollo13->get_option('cpt_work', 'subtitle') == 'on' ? a13_subtitle('span') : ''); ?></div>
        <?php a13_blog_info_bar(get_the_title()) ?>
    </header>

    <div id="col-mask">

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php echo a13_make_media_collection(); ?>
            <div class="real-content">
                <?php the_content(); ?>

                <div class="clear"></div>

                <div class="meta-data">
                    <?php

                    //internet address
                    $temp = get_post_meta(get_the_ID(), '_www', true);
                    if(strlen($temp)){
                        echo '<a class="project-site" href="'.$temp.'">'.__fe('Visit Site').'</a>';
                    }

                    //like plugin
                    if( function_exists('dot_irecommendthis') ) dot_irecommendthis();

                    //custom fields
                    $fields = '';
                    for($i = 1; $i < 6; $i++){
                        $temp = get_post_meta(get_the_ID(), '_custom_'.$i, true);
                        if(strlen($temp)){
                            $pieces = explode(':', $temp, 2);
                            if(sizeof($pieces) == 1){
                                $fields .= '<span>'.make_clickable($temp).'</span>';
                            }
                            else{
                                $fields .= '<span><em>'.$pieces[0].'</em>'.make_clickable($pieces[1]).'</span>';
                            }
                        }
                    }
                    if(strlen($fields)){
                        echo '<div class="fields">'.$fields.'</div>';
                    }
                    ?>
                </div>
            </div>

            <?php
                if($apollo13->get_option('cpt_work', 'genres') == 'on'){
                    echo a13_posted_in();
                }

                if($apollo13->get_option('cpt_work', 'comments') == 'on'){
                    comments_template( '', true );
                }
            ?>
        </div>

    </div>

</article>

<?php
        get_footer();
    }//end of non password protected
?>


<?php
    /*
            <div id="addthis-toolbox">
            addthis_print_widget( null, null, 'small_toolbox' )
            </div>
    */
    //shows all meta fields of post in multi dimensional array
    //var_dump($custom = get_post_custom($post->ID));
?>
