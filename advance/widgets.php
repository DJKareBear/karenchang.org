<?php
if(!function_exists('a13_add_sidebars')){
    function a13_add_sidebars() {
        /**
         * Register widgets areas
         */
        // Shown on blog
        register_sidebar( array(
            'name' => __be( 'Blog sidebar' ),
            'id' => 'blog-widget-area',
            'description' => __be( 'Widgets from this sidebar will appear on blog, single post, search results, archive page and 404 error page.' ),
            'before_widget' => '<div id="%1$s" class="blog-widget widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>',
        ) );

        class Apollo13_Widget_Recent_Posts extends WP_Widget {

            function __construct() {
                $widget_ops = array('classname' => 'widget_recent_posts widget_about_posts', 'description' => __be( 'The most recent posts on your site' ) );
                parent::__construct('recent-posts', __be( 'Recent Posts' ), $widget_ops);
                $this->alt_option_name = 'widget_recent_entries';

                add_action( 'save_post', array(&$this, 'flush_widget_cache') );
                add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
                add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
            }

            function widget($args, $instance) {
                global $apollo13;
                $cache = wp_cache_get('widget_recent_entries', 'widget');

                if ( !is_array($cache) ){
                    $cache = array();
                }

                if ( isset($cache[$args['widget_id']]) ) {
                    echo $cache[$args['widget_id']];
                    return;
                }

                ob_start();
                extract($args);

                $title = apply_filters('widget_title', empty($instance['title']) ? __fe('Recent Posts' ) : $instance['title'], $instance, $this->id_base);
                if ( ! $number = absint( $instance['number'] ) ){
                    $number = 10;
                }

                $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
                if ($r->have_posts()) :
                    echo $before_widget;

                    if( $title ){
                        echo $before_title . $title . $after_title;
                    }

                    $iter = 1;
                    while ($r->have_posts()) : $r->the_post();
                        $page_title = get_the_title();
                        $class = ''; //empty for easily commenting out
//                        $img = a13_make_post_image( get_the_ID(), 'sidebar-post' );
//                        $class = (!$img)? '' : ' full';
//                        $class .= ($iter === 1 ? ' first-item' : '');

                        echo '<div class="item'.$class.'">';
//                        if(strlen($img)){
//                            echo '<a class="thumb" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $img . '</a>';
//                        }
                        echo
                            '<a class="post-title" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $page_title . '</a>'
                            .a13_posted_on()
//                            .'<a class="comments" href="' . get_comments_link() . '" title="' . get_comments_number() . ' ' . __fe( 'comment(s)' ). '">'.get_comments_number().' '.__fe( 'comment(s)' ).'</a>'
                        ;

                        //if user want excpert also and post is not password proteced
                        if(!empty( $instance['content'] ) && !post_password_required()){
                            echo  '<a class="content" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">';
                            $text = get_the_content('');
                            $text = strip_shortcodes( $text );
                            $text = wp_trim_words( $text, 30, '' );
                            echo $text;
                            echo '</a>';
                        }
                        echo '</div>';

                        $iter++;
                    endwhile;

                    echo $after_widget;

                    // Reset the global $the_post as this query will have stomped on it
                    wp_reset_postdata();

                endif;

                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set('widget_recent_entries', $cache, 'widget');
            }

            function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = (int) $new_instance['number'];
                $instance['content'] = isset($new_instance['content']);

                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_recent_entries']) )
                    delete_option('widget_recent_entries');

                return $instance;
            }

            function flush_widget_cache() {
                wp_cache_delete('widget_recent_entries', 'widget');
            }

            function form( $instance ) {
                $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
                $number = isset($instance['number']) ? absint($instance['number']) : 5;
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _be('Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _be('Number of posts to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><input id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="checkbox" <?php checked(isset($instance['content']) ? $instance['content'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('content'); ?>"><?php _be('Add posts excerpt'); ?></label></p>
            <?php
            }
        }
        unregister_widget('WP_Widget_Recent_Posts');
        register_widget('Apollo13_Widget_Recent_Posts');


        class Apollo13_Widget_Popular_Posts extends WP_Widget {

            function __construct() {
                $widget_ops = array('classname' => 'widget_popular_entries widget_about_posts', 'description' => __be( 'The most popular posts on your site' ) );
                parent::__construct('popular-posts', __be( 'Popular Posts' ), $widget_ops);
                $this->alt_option_name = 'widget_popular_entries';

                add_action( 'save_post', array(&$this, 'flush_widget_cache') );
                add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
                add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
            }

            function widget($args, $instance) {
                global $apollo13;
                $cache = wp_cache_get('widget_popular_entries', 'widget');

                if ( !is_array($cache) ){
                    $cache = array();
                }

                if ( isset($cache[$args['widget_id']]) ) {
                    echo $cache[$args['widget_id']];
                    return;
                }

                ob_start();
                extract($args);

                $title = apply_filters('widget_title', empty($instance['title']) ? __fe('Popular Posts' ) : $instance['title'], $instance, $this->id_base);
                if ( ! $number = absint( $instance['number'] ) ){
                    $number = 10;
                }

                $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'ignore_sticky_posts' => true));
                if ($r->have_posts()) :
                    echo $before_widget;

                    if( $title ){
                        echo $before_title . $title . $after_title;
                    }

                    $iter = 1;
                    while ($r->have_posts()) : $r->the_post();
                        $page_title = get_the_title();
                        $class = ''; //empty for easily commenting out
//                        $img = a13_make_post_image( get_the_ID(), 'sidebar-post' );
//                        $class = (!$img)? '' : ' full';
//                        $class .= ($iter === 1 ? ' first-item' : '');

                        echo '<div class="item'.$class.'">';
//                        if(strlen($img)){
//                            echo '<a class="thumb" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $img . '</a>';
//                        }
                        echo
//                            a13_posted_on().
                            '<a class="post-title" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $page_title . '</a>'
                            .'<a class="comments" href="' . get_comments_link() . '" title="' . get_comments_number() . ' ' . __fe( 'comment(s)' ). '">'.get_comments_number().' '.__fe( 'comment(s)' ).'</a>'
                        ;

                        //if user want excpert also and post is not password proteced
                        if(!empty( $instance['content'] ) && !post_password_required()){
                            echo  '<a class="content" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">';
                            $text = get_the_content('');
                            $text = strip_shortcodes( $text );
                            $text = wp_trim_words( $text, 30, '' );
                            echo $text;
                            echo '</a>';
                        }
                        echo '</div>';

                        $iter++;
                    endwhile;

                    echo $after_widget;

                    // Reset the global $the_post as this query will have stomped on it
                    wp_reset_postdata();

                endif;

                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set('widget_popular_entries', $cache, 'widget');
            }

            function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = (int) $new_instance['number'];
                $instance['content'] = isset($new_instance['content']);

                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_popular_entries']) )
                    delete_option('widget_popular_entries');

                return $instance;
            }

            function flush_widget_cache() {
                wp_cache_delete('widget_popular_entries', 'widget');
            }

            function form( $instance ) {
                $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
                $number = isset($instance['number']) ? absint($instance['number']) : 5;
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _be('Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _be('Number of posts to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><input id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="checkbox" <?php checked(isset($instance['content']) ? $instance['content'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('content'); ?>"><?php _be('Add posts excerpt'); ?></label></p>
            <?php
            }
        }
        register_widget('Apollo13_Widget_Popular_Posts');


        class Apollo13_Widget_Related_Posts extends WP_Widget {

            function __construct() {
                $widget_ops = array('classname' => 'widget_related_entries widget_about_posts', 'description' => __be( 'Related posts to current post' ) );
                parent::__construct('related-posts', __be( 'Related Posts' ), $widget_ops);
                $this->alt_option_name = 'widget_related_entries';

                add_action( 'save_post', array(&$this, 'flush_widget_cache') );
                add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
                add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
            }

            function widget($args, $instance) {
                global $apollo13;
                $cache = wp_cache_get('widget_related_entries', 'widget');

                if ( !is_array($cache) ){
                    $cache = array();
                }

                if ( isset($cache[$args['widget_id']]) ) {
                    echo $cache[$args['widget_id']];
                    return;
                }

                ob_start();
                extract($args);

                $title = apply_filters('widget_title', empty($instance['title']) ? __fe('Related Posts' ) : $instance['title'], $instance, $this->id_base);
                if ( ! $number = absint( $instance['number'] ) ){
                    $number = 10;
                }

                global $post;

                $__search = wp_get_post_tags($post->ID);
                $search_string = 'tags__in';
                //if no tags try categories
                if( !count($__search) ){
                    $__search = wp_get_post_categories($post->ID);
                    $search_string = 'category__in';
                }

                if ( count($__search) ) {

                    $r = new WP_Query(array($search_string => $__search,'post__not_in' => array($post->ID), 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
                    if ($r->have_posts()) :
                        echo $before_widget;

                        if( $title ){
                            echo $before_title . $title . $after_title;
                        }

                        $iter = 1;
                        while ($r->have_posts()) : $r->the_post();
                            $page_title = get_the_title();
                            $class = ''; //empty for easily commenting out
//                            $img = a13_make_post_image( get_the_ID(), 'sidebar-post' );
//                            $class = (!$img)? '' : ' full';
//                            $class .= ($iter === 1 ? ' first-item' : '');

                            echo '<div class="item'.$class.'">';
//                            if(strlen($img)){
//                                echo '<a class="thumb" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $img . '</a>';
//                            }
                            echo
                                '<a class="post-title" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">' . $page_title . '</a>'
                                .a13_posted_on()
//                                .'<a class="comments" href="' . get_comments_link() . '" title="' . get_comments_number() . ' ' . __fe( 'comment(s)' ). '">'.get_comments_number().' '.__fe( 'comment(s)' ).'</a>'
                            ;

                            //if user want excpert also and post is not password proteced
                            if(!empty( $instance['content'] ) && !post_password_required()){
                                echo  '<a class="content" href="' . get_permalink() . '" title="' . esc_attr($page_title) . '">';
                                $text = get_the_content('');
                                $text = strip_shortcodes( $text );
                                $text = wp_trim_words( $text, 30, '' );
                                echo $text;
                                echo '</a>';
                            }
                            echo '</div>';

                            $iter++;
                        endwhile;

                        echo $after_widget;

                        // Reset the global $the_post as this query will have stomped on it
                        wp_reset_postdata();

                    endif;

                    $cache[$args['widget_id']] = ob_get_flush();
                    wp_cache_set('widget_related_entries', $cache, 'widget');
                }
            }

            function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = (int) $new_instance['number'];
                $instance['content'] = isset($new_instance['content']);

                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_related_entries']) )
                    delete_option('widget_related_entries');

                return $instance;
            }

            function flush_widget_cache() {
                wp_cache_delete('widget_related_entries', 'widget');
            }

            function form( $instance ) {
                $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
                $number = isset($instance['number']) ? absint($instance['number']) : 5;
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _be('Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _be('Number of posts to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><input id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="checkbox" <?php checked(isset($instance['content']) ? $instance['content'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('content'); ?>"><?php _be('Add posts excerpt'); ?></label></p>
            <?php
            }
        }
        register_widget('Apollo13_Widget_Related_Posts');


        class Apollo13_Widget_Recent_Comments extends WP_Widget {

            function __construct() {
                $widget_ops = array('classname' => 'widget_recent_comments', 'description' => '' . __be( 'The most recent comments' ) );
                parent::__construct('recent-comments', __be( 'Recent Comments' ), $widget_ops);
                $this->alt_option_name = 'widget_recent_comments';

                add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
                add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
            }

            function flush_widget_cache() {
                wp_cache_delete('widget_recent_comments', 'widget');
            }

            function widget( $args, $instance ) {
                global $comments, $comment, $apollo13;

                $cache = wp_cache_get('widget_recent_comments', 'widget');

                if ( ! is_array( $cache ) )
                    $cache = array();

                if ( isset( $cache[$args['widget_id']] ) ) {
                    echo $cache[$args['widget_id']];
                    return;
                }

                extract($args, EXTR_SKIP);
                $output = '';
                $title = apply_filters('widget_title', empty($instance['title']) ? __fe('Recent Comments' ) : $instance['title']);

                if ( ! $number = absint( $instance['number'] ) )
                    $number = 5;

                $comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) );
                $output .= $before_widget;
                if ( $title )
                    $output .= $before_title . $title . $after_title;


                if ( $comments ) {
                    $iter = 1;
                    foreach ( (array) $comments as $comment) {
                        $output .= '<div class="item'.($iter === 1? ' first-item' : '').'">' ;
                        $output .= '    <span class="author">' . get_comment_author() . '</span> ';
                        $output .= __be('on' );
                        $output .= '    <a class="post-title" href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>';
                        if(!empty( $instance['content'] )){
                            $output .=  '    <a class="content" href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . a13_get_comment_excerpt( $comment->comment_ID, 30 ) . '</a>';
                        }
                        $output .= '</div>';
                        $iter++;
                    }
                }

                $output .= $after_widget;

                echo $output;
                $cache[$args['widget_id']] = $output;
                wp_cache_set('widget_recent_comments', $cache, 'widget');
            }

            function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = absint( $new_instance['number'] );
                $instance['content'] = isset($new_instance['content']);

                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_recent_comments']) )
                    delete_option('widget_recent_comments');

                return $instance;
            }

            function form( $instance ) {
                $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
                $number = isset($instance['number']) ? absint($instance['number']) : 5;
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _be('Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _be('Number of comments to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

            <p><input id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="checkbox" <?php checked(isset($instance['content']) ? $instance['content'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('content'); ?>"><?php _be('Add comments excerpt'); ?></label></p>
            <?php
            }
        }
        unregister_widget('WP_Widget_Recent_Comments');
        register_widget('Apollo13_Widget_Recent_Comments');




        class Apollo13_Widget_Recent_Works extends WP_Widget {

            function __construct() {
                $widget_ops = array('classname' => 'widget_recent_works', 'description' => __be( 'Your most recent added works' ) );
                parent::__construct('recent-works', __be( 'Recent Works' ), $widget_ops);
                $this->alt_option_name = 'widget_recent_works';

                add_action( 'save_post', array(&$this, 'flush_widget_cache') );
                add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
                add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
            }

            function widget($args, $instance) {
                global $apollo13;
                $cache = wp_cache_get('widget_recent_works', 'widget');

                if ( !is_array($cache) )
                    $cache = array();

                if ( isset($cache[$args['widget_id']]) ) {
                    echo $cache[$args['widget_id']];
                    return;
                }

                ob_start();
                extract($args);

                $title = apply_filters('widget_title', empty($instance['title']) ? __fe('Recent Works' ) : $instance['title'], $instance, $this->id_base);
                if ( ! $number = absint( $instance['number'] ) )
                    $number = 10;

                $r = new WP_Query(array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_type' => CUSTOM_POST_TYPE_WORK,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'date'
                ));
                if ($r->have_posts()) :
                    echo $before_widget;

                    if( $title ){
                        echo $before_title . $title . $after_title;
                    }

                    echo '<div class="clearfix">';

                    while ($r->have_posts()) : $r->the_post();
                        //title
                        $page_title = get_the_title();

                        //image
                        $img = a13_make_work_image(get_the_ID(), 'sidebar-size' );
                        ?>
                    <div class="item"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr($page_title); ?>"><?php
                        echo $img; ?></a></div>
                    <?php
                    endwhile;

                    echo '</div>';

                    echo $after_widget;

                    // Reset the global $the_post as this query will have stomped on it
                    wp_reset_postdata();

                endif;

                $cache[$args['widget_id']] = ob_get_flush();
                wp_cache_set('widget_recent_works', $cache, 'widget');
            }

            function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['number'] = (int) $new_instance['number'];

                $this->flush_widget_cache();

                $alloptions = wp_cache_get( 'alloptions', 'options' );
                if ( isset($alloptions['widget_recent_works']) )
                    delete_option('widget_recent_works');

                return $instance;
            }

            function flush_widget_cache() {
                wp_cache_delete('widget_recent_works', 'widget');
            }

            function form( $instance ) {
                $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
                $number = isset($instance['number']) ? absint($instance['number']) : 5;
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _be('Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

            <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _be('Number of posts to show:' ); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
            <?php
            }
        }
        register_widget('Apollo13_Widget_Recent_Works');


        unregister_widget('WP_Widget_Search');
    }
}

add_action( 'widgets_init', 'a13_add_sidebars' );


?>