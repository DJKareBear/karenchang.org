<?php

/*
 * For getting URL of current page
 */
if(!function_exists('a13_current_url')){
    function a13_current_url(){
        global $wp;

        //no permalinks
        if($wp->request === NULL){
            $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        }
        else{
            $current_url = trailingslashit(home_url(add_query_arg(array(),$wp->request)));
        }

        return $current_url;
    }
}


/*
 * Check if current page is type of Posts list
 */
if(!function_exists('a13_is_post_list')){
    function a13_is_post_list(){
        return is_home() || (is_archive() && !defined('WORKS_LIST_PAGE')) || is_search();
    }
}


/*
 * Title META tag
 */
if(!function_exists('a13_wp_title')){
    function a13_wp_title( $title, $sep ) {
        global $paged, $page;

        if ( is_feed() )
            return $title;

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            $title = "$title $sep $site_description";

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 )
            $title = "$title $sep " . sprintf( __fe( 'Page %s' ), max( $paged, $page ) );

        return $title;
    }
}


/*
 * Date of post
 */
if(!function_exists('a13_posted_on')){
    function a13_posted_on( $date_format = '' ) {
        return sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
            get_the_date( 'c' ),
            ( strlen( $date_format ) ? get_the_date( $date_format ) : get_the_date() )
        );
    }
}


/*
 * Date and author
 */
if(!function_exists('a13_date_and_author')){
    function a13_date_and_author( ) {
        global $apollo13;

        $return = '';
        $single = is_single();
        $post_list = a13_is_post_list();

        //return date
        if(
            ($single && $apollo13->get_option('blog', 'post_date') == 'on')
            ||
            ($post_list && $apollo13->get_option('blog', 'blog_date') == 'on')
        ){
            $return .= a13_posted_on();
        }

        //return author
        if(
            ($single && $apollo13->get_option('blog', 'post_author') == 'on')
            ||
            ($post_list && $apollo13->get_option('blog', 'blog_author') == 'on')
        ){
            $return .=
                sprintf( __fe( ' by <a class="author" href="%1$s" title="%2$s">%3$s</a>' ),
                    esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )),
                    sprintf( esc_attr( __fe( 'View all posts by %s' ) ), get_the_author() ),
                    get_the_author()
                );
        }

        return $return;
    }
}


/*
 * comments & edit links
 */
if(!function_exists('a13_post_comments')){
    function a13_post_comments($before = '') {
        global $apollo13;

        $single = is_single();

        //display comments number
        if(
            ($single && $apollo13->get_option('blog', 'post_comments') == 'on')
            ||
            (a13_is_post_list() && $apollo13->get_option('blog', 'blog_comments') == 'on')
        ){
            echo $before . '<span class="comments"><a href="' . esc_url(get_comments_link()) . '" title="'
                . sprintf(__fe( '%d Comment(s)' ), get_comments_number()) . '">'
                . sprintf(__fe( '%d Comment(s)' ), get_comments_number()) . '</a></span>';
        }

        //edit link(only for admin)
        if($single)
            edit_post_link( __fe( 'Edit' ), $before );
    }
}


/*
 * Post tags
 */
if(!function_exists('a13_post_tags')){
    function a13_post_tags() {
        $tags = '';
        $tag_list = get_the_tag_list( '',' ' );
        if ( $tag_list ) {
            $tags = '<span class="tags">'.$tag_list.'</span>';
        }

        return $tags;
    }
}

/*
 * Categories that post was posted in
 */
if(!function_exists('a13_post_categories')){
    function a13_post_categories( ) {
        $cats = '';
        $cat_list = get_the_category_list(' ');
        if ( $cat_list ) {
            $cats = '<span class="cats">'.$cat_list.'</span>';
        }

        return $cats;
    }
}


/*
 * Categories and Tags that post was posted in
 */
if(!function_exists('a13_posted_in')){
    function a13_posted_in() {
        global $apollo13;

        $return = '';
        $single = is_single();
        $post_list = a13_is_post_list();
        $work = get_post_type() == CUSTOM_POST_TYPE_WORK;

        //return categories
        if(
            ($single && $apollo13->get_option('blog', 'post_cats') == 'on')
            ||
            ($post_list && $apollo13->get_option('blog', 'blog_cats') == 'on')
        ){
            $return .= a13_post_categories().' ';
        }

        //return tags
        if(
            ($single && $apollo13->get_option('blog', 'post_tags') == 'on')
            ||
            ($post_list && $apollo13->get_option('blog', 'blog_tags') == 'on')
        ){
            $return .= a13_post_tags();
        }

        //return taxonomy for works
        if($work){
            $return .= a13_cpt_work_posted_in('');
        }

        if(strlen(trim($return))) //trim if only space is present(page type in search result for example)
            $return = '<div class="posted-in">'.$return.'</div>';

        return $return;
    }
}


/*
* Return subtitle for page/post
*/
if(!function_exists('a13_subtitle')){
    function a13_subtitle($tag = 'h2') {
        $s = get_post_meta(get_the_ID(), '_subtitle', true);
        if(strlen($s))
            $s = '<'.$tag.'>'.$s.'</'.$tag.'>';

        return $s;
    }
}


/*
* Modify password form
*/
if(!function_exists('custom_password_form')){
    function custom_password_form($content) {
        //copy of function
        //get_the_password_form()
        //from \wp-includes\post-template.php ~1222
        //with small changes
        $post = get_post();

        $output = '
        <form class="password-form"  action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
            <p>' . __fe("This post is password protected. To view it please enter your password below:") . '</p>
            <p class="inputs"><input name="post_password" type="password" size="20" /><input type="submit" name="Submit" value="' . esc_attr(__fe("Submit")) . '" /></p>
        </form>
        ';

        return $output;
    }
}


/*
* Checks if current page has active sidebar
 * returns false if there is no active sidebar,
 * if there is active sidebar it returns its name
*/
if(!function_exists('a13_has_active_sidebar')){
    function a13_has_active_sidebar() {
        if( is_home() || is_archive() || is_search() || is_single() ){
            if( is_active_sidebar('blog-widget-area' )){
                return 'blog-widget-area';
            }
        }

        return false;
    }
}


/*
* Get classes for body element
*/
if(!function_exists('a13_body_classes')){
    function a13_body_classes( $classes ) {
        global $apollo13;

        //forms validation
        $classes[] = ($apollo13->get_option( 'advance', 'apollo_validation' ) == 'on')? VALIDATION_CLASS : '';

        //protected album
        if(defined('A13_PAGE_PROTECTED')){
            $classes[] = 'password-protected';
        }

        if(defined('WORK_PAGE')){
        }

        if(defined('WORKS_LIST_PAGE')){
            $classes[] = 'works-list-page';
        }

        if(defined('GALLERIES_LIST_PAGE')){
            $classes[] = 'galleries-list-page';
        }

        if(defined('FRONT_PAGE_SLIDER')){
            $classes[] = 'front-page-slider';
        }

        if(is_page_template('contact.php')){
            $classes[] = 'contact-page';
        }

        //page with posts list
        if(a13_is_post_list() && !defined('NO_STYLED_PAGE'))
            $classes[] = 'posts-list';

        //no results page
        if(defined('NO_STYLED_PAGE'))
            $classes[] = 'no-results';

        return $classes;
    }
}


/*
* Get classes for mid element
*/
if(!function_exists('a13_get_mid_classes')){
    function a13_get_mid_classes() {
        global $apollo13;

        //check if there is active sidebar for current page
        $force_full_width = false;
        if(a13_has_active_sidebar() === false){
            $force_full_width = true;
        }

        //mid classes for type of layout align and widget area display(on/off)
        $mid_classes = '';

        //404 error page, no-result page, etc.
        if(defined('NO_STYLED_PAGE')){
            $mid_classes .= ' static-left';
        }
        elseif(is_page()){
            $mid_classes .= ' '.$apollo13->get_meta('_page_layout');
            $mid_classes .= ' '.$apollo13->get_meta('_page_color');
            $mid_classes .= ' cross-'.$apollo13->get_meta('_hiding_cross');
        }
        //check if page has enabled sidebar
        else{
            if(
                $force_full_width
                ||
                    //blog & attachment
                    ((is_home() || is_attachment()) && $apollo13->get_option('blog', 'blog_sidebar') == 'off')
                    //archive | search
                ||  ((is_archive() || is_search()) && $apollo13->get_option('blog', 'archive_sidebar') == 'off')
                    //single post
                ||  (is_single() && $apollo13->get_meta('_widget_area') == 'off')
                    //single work
                ||  (defined('WORK_PAGE'))
            ){
                define('FULL_WIDTH', true); /* so we don't have to check again in sidebar.php */
                $mid_classes .= ' full-width';
            }
        }

        return $mid_classes;
    }
}

/*
 * Prints HTML for background image
 */
if(!function_exists('a13_bg_image')){
    function a13_bg_image() {
        global $apollo13;
        //we use background image option only for static pages and galleries
        if(!(is_page() || defined( 'GALLERY_PAGE' ))) return;

        $html = '';
        $fit = '';

        //page/gallery individual
        if(get_post_meta(get_the_ID(), '_bg_settings', true) == 'bg_image'){
            $bg_image = get_post_meta(get_the_ID(), '_bg_image', true);
            $bg_color = get_post_meta(get_the_ID(), '_bg_image_color', true);
            $fit = get_post_meta(get_the_ID(), '_bg_image_fit', true);
        }
        //global setting
        else{
            $bg_image = $apollo13->get_option( 'appearance', 'body_image' );
            $bg_color = $apollo13->get_option( 'appearance', 'body_bg_color' );
            $fit = $apollo13->get_option( 'appearance', 'body_image_fit' );
        }

        if(!empty($bg_image) || !empty($bg_color)){
            $html = '<div id="bg-image" style="'
                    .'background-image:url('.esc_url($bg_image).'); '
                    .(!empty($bg_color)? (' background-color:'.$bg_color.';') : '')
                    .'"'
                    .' class="'.esc_attr($fit).'"></div>';
        }

        echo $html;
    }
}


/*
 * Prints favicon
 */
if(!function_exists('a13_favicon')){
    function a13_favicon() {
        global $apollo13;
        $fav_icon = $apollo13->get_option( 'appearance', 'favicon' );
        if(!empty($fav_icon))
            echo '<link rel="shortcut icon" href="'.esc_url($fav_icon).'" />';
    }
}


/*
 * Prints search form with custom id for each displayed form one one page
 */
if(!function_exists('a13_search_form')){
    function a13_search_form() {
        static $search_id = 1;
        $field_search = '';
        $helper_search = get_search_query() == '' ? true : false;
        $field_search = '<input' .
            ' placeholder="' . esc_attr(__fe('Search' )) . '" ' .
            'type="search" name="s" id="s' . $search_id . '" value="' .
            esc_attr( $helper_search ? '' : get_search_query() ) .
            '" />';

        $form = '
                <form class="search-form" role="search" method="get" id="searchform' . $search_id . '" action="' . home_url( '/' ) . '" >
                    <fieldset class="semantic">
                        ' . $field_search . '
                        <input type="submit" id="searchsubmit' . $search_id . '" title="'. esc_attr( __fe('Search' ) ) .'" value=" " />
                    </fieldset>
                </form>';

        //next call will have different ID
        $search_id++;
        return $form;
    }
}


/*
 * Function serving theme contact form
 */
if(!function_exists('a13_contact_form')){
    function a13_contact_form( $email_to = '' ){
        static $contact_id = 1;
        static $email_send_already = false;
        static $title_msg      = '';
        static $success        = false;

        $using_captcha  = function_exists( 'cptch_display_captcha_custom' );

        $name_error     = false;
        $email_error    = false;
        $content_error  = false;
        $subject_error  = false;
        $captcha_error  = false;

        $name    = isset($_POST['apollo13-contact-name'])?trim($_POST['apollo13-contact-name']):'';
        $email   = isset($_POST['apollo13-contact-email'])?trim($_POST['apollo13-contact-email']):'';
        $subject = isset($_POST['apollo13-contact-subject'])?trim($_POST['apollo13-contact-subject']):'';
        $content = isset($_POST['apollo13-contact-content'])?trim($_POST['apollo13-contact-content']):'';

        if( isset( $_POST['apollo13-contact-form'] ) ){
            $site = get_bloginfo('name');

            if( empty( $email_to ) || ! is_email( $email_to ) ){
                $email_to = get_option('admin_email');
            }

            if( empty( $name ) )
                $name_error = true;
            if( empty( $email ) || ! is_email( $email ) )
                $email_error = true;
            if( empty( $subject ) )
                $subject_error = true;
            if( empty( $content ) )
                $content_error = true;
            if( $using_captcha && cptch_check_custom_form() !== true )
                $captcha_error = true;

            if( $name_error == false && $email_error == false && $content_error == false && $subject_error == false && $captcha_error == false){
                $mail_subject = $site . __fe( ' - message from contact form' );
                $body =
//                    __fe( 'Site' ) . ': ' . $site . "\n\n" .
                      __fe( 'Name' ) . ': ' . $name . "\n\n"
                    . __fe( 'Email' ) . ': ' . $email . "\n\n"
                    . __fe( 'Subject' ) . ': ' . $subject . "\n\n"
                    . __fe( 'Message' ) . ': ' . $content;
                $headers = 'From: ' . " $name <$email>\r\n";
                $headers .= 'Reply-To: ' ." $email\r\n";

                if(!$email_send_already){
                    //to not send multiple emails if there is more then just one contact form on page
                    $email_send_already = true;

                    if( wp_mail( $email_to, $mail_subject, $body, $headers ) ){
                        $title_msg = __fe( 'Success sending form.' );
                        $success = true;
                    }
                    else{
                        $title_msg = __fe( 'Something wrong. Please try again.' );
                    }
                }
            }
            else{
                $title_msg = __fe( 'Error in form.' );
            }
        }

        //if message sent empty text of message(anti spam)
        if($success){
            $content = '';
        }

        //if some message to show
        $msg_to_show = empty($title_msg)? false : true;

        //captcha plugin
        $captcha = '';
        if( function_exists( 'cptch_display_captcha_custom' ) ) {
            $cptch_options = get_option( 'cptch_options' );

            $captcha = '<p class="input-row'.($captcha_error ? ' error"' : '').'">'
                        . ("" != $cptch_options['cptch_label_form'] ? ('<label>'. stripslashes( $cptch_options['cptch_label_form'] ) .'</label>') : '')
                        . '<input type="hidden" name="cntctfrm_contact_action" value="true" />'
                        . cptch_display_captcha_custom()
                        . '</p>';
        }

        $html = '
                        <form action="' . esc_url(a13_current_url()) . '" method="post" name="apollo-contact-form" class="contact-form message-form clearfix">
                            <div class="form-info'.($success? '' : ' error').'" data-error-msg="'.esc_attr(__fe('Please correct form' )).'"'.($msg_to_show? ' style="display: block;"' : '').'>'. $title_msg .'</div>
                            <p class="input-row'.($name_error ? ' error"' : '').'">
                                <label for="apollo13-contact-name'.$contact_id.'">' . __fe( 'Name' ).'*' . '</label>
                                <input id="apollo13-contact-name'.$contact_id.'" name="apollo13-contact-name" type="text" aria-required="true" value="' . esc_attr( $name ) . '" />
                            </p>
                            <p class="input-row'.($email_error ? ' error"' : '').'">
                                <label for="apollo13-contact-email'.$contact_id.'">' . __fe( 'Email' ).'*' . '</label>
                                <input id="apollo13-contact-email'.$contact_id.'" name="apollo13-contact-email" type="text" aria-required="true" value="' . esc_attr( $email ) . '" class="email" />
                            </p>
                            <p class="input-row'.($subject_error ? ' error"' : '').'">
                                <label for="apollo13-contact-subject'.$contact_id.'">' . __fe( 'Subject' ).'*' . '</label>
                                <input class="placeholder" id="apollo13-contact-subject'.$contact_id.'" aria-required="true" name="apollo13-contact-subject" type="text" value="' . esc_attr( $subject ) . '" />
                            </p>'
                            .$captcha.
                            '<p class="input-row full'.($content_error ? ' error"' : '').'">
                                <label for="apollo13-contact-content'.$contact_id.'">' . __fe( 'Message' ).'*' . '</label>
                                <textarea id="apollo13-contact-content'.$contact_id.'" aria-required="true" name="apollo13-contact-content" rows="10" cols="40">' . esc_textarea($content) . '</textarea>
                            </p><span class="info">' . __fe( 'required' ) . ' *</span>
                            <p class="form-submit">
                                <input type="hidden" name="apollo13-contact-form" value="send" />
                                <input type="submit" value="' . esc_attr(__fe( 'Submit form' )) . '" />
                            </p>
                        </form>';



        $contact_id++;//new id for next form

        return $html;
    }
}


/*
 * Sets the post excerpt length to 30 words.
 */
if(!function_exists('a13_excerpt_length')){
    function a13_excerpt_length( $length ) {
        return 30;
    }
}


/*
* This filter is used by wp_trim_excerpt() function.
* By default it set to echo '[...]' more string at the end of the excerpt.
*/
if(!function_exists('a13_new_excerpt_more')){
    function a13_new_excerpt_more($more) {
        global $post;
        return '<p><a class="more-link" href="'. esc_url(get_permalink($post->ID)) . '">' . __fe('Read more' ) . '</a></p>';
    }
}


/*
* Make excerpt for comments
* used in widgets
*/
if(!function_exists('a13_get_comment_excerpt')){
    function a13_get_comment_excerpt($comment_ID = 0, $num_words = 20) {
        $comment = get_comment( $comment_ID );
        $comment_text = strip_tags($comment->comment_content);
        $blah = explode(' ', $comment_text);
        if (count($blah) > $num_words) {
            $k = $num_words;
            $use_dotdotdot = 1;
        } else {
            $k = count($blah);
            $use_dotdotdot = 0;
        }
        $excerpt = '';
        for ($i=0; $i<$k; $i++) {
            $excerpt .= $blah[$i] . ' ';
        }
        $excerpt .= ($use_dotdotdot) ? '[...]' : '';
        return apply_filters('get_comment_excerpt', $excerpt);
    }
}


/*
* It replaces WP default action while closing children comments block
* Useful to save your nerves
*/
if(!function_exists('a13_comment_end')){
    function a13_comment_end( $comment, $args, $depth ) {
        echo '</div>';
        return;
    }
}


/*
* Changes default comment template
* Closing </div> for this block is produced by comment_end()
* It is strange, I know :-)
*/
if(!function_exists('a13_comment')){
    function a13_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :
            case '' :
                ?>
                    <div <?php comment_class( 'comment-block' ); ?> id="comment-<?php comment_ID(); ?>">

                        <div class="comment-inside">
                            <a class="avatar" href="<?php esc_url(get_comment_author_url()); ?>" title=""><?php echo get_avatar( $comment, 40 ) ; ?></a>
                            <div class="comment-info">
                                <span class="author"><?php comment_author_link(); ?></span>
                                <?php
                                    printf( '<a class="time" href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                        esc_url( get_comment_link( $comment->comment_ID ) ),
                                        esc_attr(get_comment_time( 'c' )),
                                        /* translators: 1: date, 2: time */
                                        sprintf( __fe( '%1$s at %2$s' ), get_comment_date(), get_comment_time() )
                                    );
                                    comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                                ?>
                            </div>
                            <div class="comment-text">
                                <?php if ( $comment->comment_approved == '0' ) : ?>
                                <p><em class="comment-awaiting-moderation"><?php _fe( 'Your comment is awaiting moderation.' ); ?></em></p>
                                <?php endif; ?>
                                <?php comment_text(); ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php
                break;
            case 'pingback'  :
            case 'trackback' :
                ?>
            <div <?php comment_class( 'comment-block' ); ?> id="comment-<?php comment_ID(); ?>">
                <div class="comment-inside clearfix">
                    <p><?php _fe( 'Pingback:' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( '(' . __fe( 'Edit' ) . ')', ' ' ); ?></p>
                </div>
                    <?php
                break;
        endswitch;
    }
}


/*
* Displays header menu
*/
if(!function_exists('a13_header_menu')){
    function a13_header_menu(){
        /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.
         * The menu assiged to the primary position is the one used.
         * If none is assigned, the menu with the lowest ID is used.
         */
        if ( has_nav_menu( 'header-menu' ) ):
            wp_nav_menu( array(
                    'container'       => false,
                    'link_before'     => '<span>',
                    'link_after'      => '</span>',
                    'menu_class'      => 'top-menu',
                    'theme_location'  => 'header-menu',
                    'walker'          => new A13_menu_walker)
            );
        else:
            echo '<ul class="top-menu">';
            wp_list_pages(
                array(
                    'link_before'     => '<span>',
                    'link_after'      => '</span>',
                    'title_li' 		  => ''
                )
            );
            echo '</ul>';
        endif;
    }
}

class A13_menu_walker extends Walker_Nav_Menu {

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     * @param int $id Menu item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $menu_desc = $depth === 0? trim(get_post_meta($item->object_id, '_menu_desc', true)) : '';
        $menu_icon = $depth === 0? trim(get_post_meta($item->object_id, '_menu_icon', true)) : '';
        //checking for icons
        if(strlen($menu_icon)){
            $icons = explode(' ', $menu_icon);
            $menu_icon = '';
            foreach($icons as $icon){
                if(strlen($icon))
                    $menu_icon .= '<i class="'.esc_attr( $icon ).'"></i>';
            }
        }

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= strlen($menu_icon)? '<span class="m_icon">'.$menu_icon.'</span>' : '';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= strlen($menu_desc)? '<span class="m_desc">'.$menu_desc.'</span>' : '';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


/*
* Return HTML for social icons
*/
if(!function_exists('a13_social_icons')){
    function a13_social_icons(){
        global $apollo13;

        $icons_set = $apollo13->get_option( 'social', 'social-icons-set' );

        //compare positions
        function cmp($a, $b)
        {
            if ($a['pos'] == $b['pos']) {
                return 0;
            }
            return ($a['pos'] < $b['pos']) ? -1 : 1;
        }

        $socials = (array)$apollo13->get_option( 'social', 'social_services' );
        uasort($socials, "cmp");
        $soc_html = '';
        $has_active = false;

        foreach( $socials as $id => $value ){
            if( ! empty($value['value']) ){
                $soc_html .= '<a target="_blank" href="' . esc_url($value['value']) . '" title="' . esc_attr(__fe( 'Follow us on ' ) . $apollo13->all_theme_options[ 'social' ][ 'social_services' ][ $id ]['name']) . '"><img src="' . esc_url(TPL_GFX.'/social-icons/'.$icons_set.'/'.$id.'.png').'" alt="" /></a>';
                $has_active = true;
            }
        }

        if($has_active){
            $soc_html = '<div class="socials">'.$soc_html.'</div>';
        }

        echo $soc_html;
    }
}


/*
* Function that return featured image or video for post
*/
if(!function_exists('a13_top_image_video')){
    function a13_top_image_video($link_it = false, $width = 'auto', $height = 0){
        global $apollo13;

        //check if media should be displayed
        if(
            (is_single() && $apollo13->get_option('blog', 'post_media') == 'off')
            ||
            (a13_is_post_list() && $apollo13->get_option('blog', 'blog_media') == 'off')
        )
            return;

        $post_id =  get_the_ID();
        $is_post = is_single();
        $is_page = is_page();
        $img_or_vid = get_post_meta($post_id, '_image_or_video', true);
        $align = '';
        $size = '';

        if( empty( $img_or_vid ) || $img_or_vid == 'post_image' ){
            $thumb_size = 'apollo-post-thumb';

            if($is_post || $is_page){
                $align = ' '.get_post_meta($post_id, '_image_stretch', true);
                $size = get_post_meta($post_id, '_image_size', true);

                if($size == 'big') $thumb_size = 'apollo-post-thumb-big';
                elseif($size == 'original') $thumb_size = 'full';
                elseif($size == 'auto'){
                    if( defined('FULL_WIDTH') || $apollo13->get_meta( '_widget_area' ) == 'off'){
                        $thumb_size = 'apollo-post-thumb-big';
                    }
                }
            }
            $img = a13_make_post_image($post_id, $thumb_size);

            if( !empty( $img ) ){
                if($link_it){
                    $img = '<a href="'.esc_url(get_permalink()).'">'.$img.'<em></em></a>';
                }
                ?>
                <div class="item-image post-media<?php echo $align; ?>">
                    <?php echo $img; ?>
                </div>
                <?php
            }
        }

        elseif( $img_or_vid == 'post_video' ){
            if($width === 'auto'){
                $width = 600;
            }

            if($is_post || $is_page){
                $align = ' '.get_post_meta($post_id, '_video_align', true);
                $size = get_post_meta($post_id, '_video_size', true);
                if($size == 'big') $width = 960;
            }

            $src = get_post_meta($post_id, '_post_video', true);
            if( !empty( $src ) ){
                ?>
                <div class="item-video post-media width-<?php echo $size.$align; ?>">
                    <?php
                    if( $height == 0){
                        $height = ceil((9/16) * $width);
                    }

                    $v_code = wp_oembed_get($src, array(
                        'width' => $width,
                        'height' => $height
                        )
                    );

                    //if no code, try theme function
                    if($v_code === false){
                        echo a13_get_movie($src, $width, $height);
                    }
                    else{
                        echo $v_code;
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
}


/*
 * Pagination for blog pages
 */
if(!function_exists('a13_blog_nav')){
    function a13_blog_nav() {
        //if WP Painate plugin is installed and active
        if(function_exists('wp_paginate')) {
            wp_paginate();
        }
        //theme pagination
        else{
            global $paged, $wp_query;
            //safe copy for operations
            $c_paged = $paged;

            $max_page = $wp_query->max_num_pages;

            if ( $max_page > 1 ) : ?>
                <div id="posts-nav" class="navigation">
                    <?php
                    echo '<span class="nav-previous">';
                    previous_posts_link( __fe( 'Previous' ) );
                    echo '</span>';

                    //if first page
                    if($c_paged === 0){
                        $c_paged = 1;
                    }
                    for($page = 1; $page <= $max_page; $page++){
                        if($page == $c_paged)
                            echo '<span class="current">'.$page.'</span>';
                        else
                            echo '<a href="'.esc_url(get_pagenum_link($page)).'" title="'.esc_attr($page).'">'.$page.'</a>';
                    }

                    echo '<span class="nav-next">';
                    next_posts_link( __fe( 'Next' ) );
                    echo '</span>';
                    ?>
                </div>
            <?php endif;
        }
    }
}


/*
 * Filter and RSS for blog
 */
if(!function_exists('a13_blog_info_bar')){
    function a13_blog_info_bar($title = '') {
        global $apollo13;

        $title = empty($title)? get_the_title(get_option('page_for_posts')) : $title;
        if ( !empty( $title ) ){
            echo '<h1 class="page-title">' . $title . '</h1>';
        }

/*        //search form
        if($apollo13->get_option( 'blog', 'info_bar_search' ) == 'on')
            echo a13_search_form();*/

        $rss = ($apollo13->get_option( 'blog', 'info_bar_rss' ) == 'on');
        //$filter = ($apollo13->get_option( 'blog', 'info_bar_filter' ) == 'on');

        if(is_single()){
            a13_post_nav();
        }
        elseif(is_home() && ($rss /*|| $filter*/)){
        ?>
        <div class="tools">
            <?php /*if($filter): ?>
            <div id="blog-filters">
                <span class="action" id="filter-activate"><?php _fe('Filter by'); ?></span>
                <div>
                    <div class="cat-parent">
                        <h3><?php printf( __fe( 'Categories' ), 10); ?></h3>
                        <ul>
                            <?php
                            wp_list_categories(array(
                                'orderby'            => 'count',
                                'order'              => 'DESC',
                                'show_count'         => 1,
                                'number'             => 10,
                                'title_li'           => ''
                            ));
                            ?>
                        </ul>
                    </div>

                    <div class="tag-parent">
                        <h3><?php printf( __fe( 'Tags' ), 10); ?></h3>
                        <ul>
                            <?php
                            $tags = get_tags(array(
                                'orderby'            => 'count',
                                'order'              => 'DESC',
                                'number'             => 10,
                                'title_li'           => ''
                            ));
                            foreach ($tags as $tag){
                                $tag_link = get_tag_link($tag->term_id);
                                echo '<li><a href="'.$tag_link.'" title="'.sprintf( '%s Tag', $tag->name).'" class="'.$tag->slug.'">'.$tag->name.'</a> ('.$tag->count.')</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php

            endif; */ /*$filter*/

            if($rss)
                echo '<a href="'.esc_url(get_bloginfo('rss2_url')).'" class="rss-link">'.__fe('RSS').'</a>';
            ?>

        </div>
        <?php

        } /*$rss || $filter*/
    }
}


/*
 * Filter and RSS for blog
 */
if(!function_exists('a13_post_nav')){
    function a13_post_nav() {
        global $apollo13;
        $show_back_btn = true;
        $href = '';

        if( defined( 'WORK_PAGE' )){
            $works_id = $apollo13->get_option( 'cpt_work', 'cpt_work_page' );
            $title = __fe( 'Back to Works list');
            if($works_id !== '0'){
                $href = get_permalink($works_id);
            }
            //works list as front page
            elseif($apollo13->get_option( 'settings', 'fp_variant' ) == 'works_list'){
                $href = home_url( '/' );
            }
            else{
                $show_back_btn = false;
            }
        }
        else{
            $href = (get_option( 'page_for_posts') !== '0')? get_permalink(get_option( 'page_for_posts')) : home_url();
            $title = __fe( 'Back to Blog' );
        }

        echo '<div class="posts-nav">';
            next_post_link( '<span class="prev">%link</span>' );
            echo $show_back_btn? '<a href="'.esc_url($href).'" title="'.esc_attr($title).'" class="to-blog">'.$title.'</a>' : '';
            previous_post_link( '<span class="next">%link</span>' );
        echo '</div>';
    }
}


/*
 * Making images
 */
if(!function_exists('a13_make_post_image')){
    function a13_make_post_image( $post_id, $thumb_size){
        if(empty($post_id)){
            $post_id = get_the_ID();
        }
        if ( has_post_thumbnail($post_id) ) {
            return get_the_post_thumbnail($post_id, $thumb_size );
        }

        return false;
    }
}


/*
 * Detection of type of movie
 * returns array(type, video_id)
 */
if(!function_exists('a13_detect_movie')){
    function a13_detect_movie($src){
        //used to check if it is audio file
        $parts = pathinfo($src);
        $ext = isset($parts['extension'])? strtolower($parts['extension']) : false;

        //http://www.youtube.com/watch?v=e8Z0YTWDFXI
        if (preg_match("/(youtube\.com\/watch\?)?v=([a-zA-Z0-9\-_]+)&?/s", $src, $matches)){
            $type = 'youtube';
            $video_id = $matches[2];
        }
        //http://youtu.be/e8Z0YTWDFXI
        elseif (preg_match("/(https?:\/\/youtu\.be\/)([a-zA-Z0-9\-_]+)&?/s", $src, $matches)){
            $type = 'youtube';
            $video_id = $matches[2];
        }
        // regexp $src http://vimeo.com/16998178
        elseif (preg_match("/(vimeo\.com\/)([0-9]+)/s", $src, $matches)){
            $type = 'vimeo';
            $video_id = $matches[2];
        }
        elseif(strlen($ext) && in_array($ext, array('mp3', 'ogg', 'm4a'))){
            $type = 'audio';
            $video_id = $src;
        }
        else{
            $type = 'html5';
            $video_id = $src;
        }

        return array(
            'type' => $type,
            'video_id' => $video_id
        );
    }
}


/*
 * Returns movie thumb(for youtube, vimeo)
 */
if(!function_exists('a13_get_movie_thumb_src')){
    function a13_get_movie_thumb_src( $video_res, $thumb = '' ){
        if(!empty($thumb)){
            return $thumb;
        }

        $type = $video_res['type'];
        $v_id = $video_res['video_id'];

        if ( $type == 'youtube' ){
            return 'http://img.youtube.com/vi/'.$v_id.'/hqdefault.jpg';
        }
        elseif ( $type == 'vimeo' ){
            return TPL_GFX . '/holders/vimeo.jpg';
        }
        elseif ( $type == 'html5' ){
            return TPL_GFX . '/holders/video.jpg';
        }

        return false;
    }
}


/*
 * Returns movie link to insert it in iframe
 */
if(!function_exists('a13_get_movie_link')){
    function a13_get_movie_link( $video_res, $params = array()){
        $type = $video_res['type'];
        $v_id = $video_res['video_id'];

        if ( $type == 'youtube' ){
            return 'http://www.youtube.com/embed/'.$v_id.'?enablejsapi=1&amp;controls=1&amp;fs=1&amp;hd=1&amp;loop=0&amp;rel=0&amp;showinfo=1&amp;showsearch=0&amp;wmode=transparent';
        }
        elseif ( $type == 'vimeo' ){
            return 'http://player.vimeo.com/video/'.$v_id.'?api=1&amp;title=1&amp;loop=0';
        }
        else{
            return TPL_ADV . '/inc/videojs/player.php?src=' . $v_id . '&amp;w=' . $params['width'] . '&amp;h=' . $params['height'];
        }
    }
}


/*
 * Returns movie iframe or link to movie
 */
if(!function_exists('a13_get_movie')){
    function a13_get_movie( $src, $width = 295, $height = 0 ){
        if( $height == 0){
            $height = ceil((9/16) * $width);
        }

        $video_res  = a13_detect_movie($src);
        $type       = $video_res['type'];
        if($type == 'audio'){
            return a13_get_audio_player($video_res['video_id']);
        }
        else{
            $link       = a13_get_movie_link($video_res, array( 'width' => $width, 'height' => $height ));

            return '<iframe id="crazy'.$type . mt_rand() . '" style="height: ' . $height . 'px; width: ' . $width . 'px; border: none;" src="' . esc_url($link) . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
        }
    }
}


/*
 * Returns audio player HTML
 */
if(!function_exists('a13_get_audio_player')){
    function a13_get_audio_player($src){
        static $player_count = 0;

        //add script for audio
        wp_enqueue_script('apollo13-audio');
        wp_enqueue_style('audio-css');

//        used in lazy load(unfinished)
//        if(defined('A13_AJAX_CALL')){
//            a13_print_script_tag('apollo13-audio');
//            a13_print_style_tag('audio-css');
//        }


        $parts = pathinfo($src);
        $ext = isset($parts['extension'])? strtolower($parts['extension']) : false;
        $setMedia = $ext.':"'.$src.'"';

        $html = '
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
	jQuery("#jquery_jplayer_'.$player_count.'").jPlayer({
		ready: function (event) {
			jQuery(this).jPlayer("setMedia", {'.$setMedia.'});
		},
		play: function() { // To avoid both jPlayers playing together.
			jQuery(this).jPlayer("pauseOthers");
		},
		swfPath: "'.TPL_JS.'/audio/",
		supplied: "'.$ext.'",
		wmode: "window",
		cssSelectorAncestor: "#jp_container_'.$player_count.'"
	});
});
//]]>
</script>


		<div id="jp_container_'.$player_count.'" class="jp-audio">
            <div id="jquery_jplayer_'.$player_count.'" class="jp-jplayer"></div>
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>

						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
					<ul class="jp-toggles">
						<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>';

        $player_count++;

        return $html;
    }
}


/**
 * ADDING THUMBNAIL TO RSS
 */
if(!function_exists('a13_rss_post_thumbnail')){
    function a13_rss_post_thumbnail($content) {
        global $post;
        if(has_post_thumbnail($post->ID)) {
            $content = '<p>' . get_the_post_thumbnail($post->ID, 'medium') .
                '</p>' . get_the_excerpt();
        }
        else
            $content = get_the_excerpt();

        return $content;
    }
}

//!!!!!!!!!!!!!!!!
//NEXT 3 functions come from unfinished lazy load for blog
// There is no promise it will be done, as it produces many issues that are not easy to solve.

/**
 * PRINT SCRIPT TAG
 */
if(!function_exists('a13_print_script_tag')){
    function a13_print_script_tag($name){
        global $wp_scripts;

//        var_dump($wp_scripts->registered[$name]->src);
        echo '<script type="text/javascript" src="'.$wp_scripts->registered[$name]->src.'"></script>'."\n";
    }
}


/**
 * PRINT STYLE TAG
 */
if(!function_exists('a13_print_style_tag')){
    function a13_print_style_tag($name){
        global $wp_styles;

//        var_dump($wp_styles->registered[$name]->src);
        echo '<link rel="stylesheet" href="'.$wp_styles->registered[$name]->src.'" type="text/css" media="all" />'."\n";
    }
}


/*
 * AJAX calls for lazy load of blog posts
 */
function ajax_blog_lazy_load() {
    global $wp_query;

    //register scripts & styles from front-end
    a13_theme_scripts(true);
    a13_theme_styles(true);

    $paged = $_POST['page'];

    $args = array(
        'post_type=page' => 'post',
        'paged' => $paged
    );

    $wp_query->query( $args );

    //dirty! emulating is_home()
    $wp_query->is_home = true;

    get_template_part( 'loop' );

    die(); // this is required to return a proper result
}
if(is_admin()){
    add_action('wp_ajax_lazy_blog', 'ajax_blog_lazy_load');
    add_action('wp_ajax_nopriv_lazy_blog', 'ajax_blog_lazy_load');
}



/**
 * FILTER HOOKS
 */
add_filter( 'wp_title', 'a13_wp_title', 10, 2 );
add_filter( 'body_class', 'a13_body_classes' );
add_filter( 'get_search_form','a13_search_form' );
add_filter( 'excerpt_length', 'a13_excerpt_length' );
//add_filter( 'excerpt_more', 'a13_new_excerpt_more' );
add_filter( 'the_password_form', 'custom_password_form');
add_filter( 'the_excerpt_rss', 'a13_rss_post_thumbnail');
add_filter( 'the_content_feed', 'a13_rss_post_thumbnail');
