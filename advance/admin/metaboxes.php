<?php

/*
 * Metaboxes in different post types
 */
function a13_admin_meta_boxes(){
    add_meta_box(
        'apollo13_shortcodes',
        __be( TPL_ALT_NAME . ' Shortcodes' ),
        'a13_meta_shortcodes',
        'post',
        'normal',
        'high'
    );
    add_meta_box(
        'apollo13_theme_options',
        __be( 'Blog post details' ),
        'a13_meta_main_opts',
        'post',
        'normal',
        'high',
        array('func' => 'apollo13_metaboxes_post')//callback
    );
    add_meta_box(
        'apollo13_shortcodes',
        __be( TPL_ALT_NAME . ' Shortcodes' ),
        'a13_meta_shortcodes',
        'page',
        'normal',
        'high'
    );
    add_meta_box(
        'apollo13_theme_options',
        __be( 'Page details' ),
        'a13_meta_main_opts',
        'page',
        'normal',
        'low',
        array('func' => 'apollo13_metaboxes_page')//callback
    );
    add_meta_box(
        'apollo13_shortcodes',
        __be( TPL_ALT_NAME . ' Shortcodes' ),
        'a13_meta_shortcodes',
        CUSTOM_POST_TYPE_WORK,
        'normal',
        'high'
    );
    add_meta_box(
        'apollo13_theme_options',
        __be( 'Work details' ),
        'a13_meta_main_opts',
        CUSTOM_POST_TYPE_WORK,
        'normal',
        'low',
        array('func' => 'apollo13_metaboxes_cpt_work')//callback
    );
    add_meta_box(
        'apollo13_theme_options_1',
        __be( 'Work media - Add images' ),
        'a13_meta_main_opts',
        CUSTOM_POST_TYPE_WORK,
        'normal',
        'low',
        array('func' => 'apollo13_metaboxes_cpt_images')//callback
    );
    add_meta_box(
        'apollo13_theme_options',
        __be( 'Gallery details' ),
        'a13_meta_main_opts',
        CUSTOM_POST_TYPE_GALLERY,
        'normal',
        'low',
        array('func' => 'apollo13_metaboxes_cpt_gallery')//callback
    );
    add_meta_box(
        'apollo13_theme_options_1',
        __be( 'Gallery media - Add images' ),
        'a13_meta_main_opts',
        CUSTOM_POST_TYPE_GALLERY,
        'normal',
        'low',
        array('func' => 'apollo13_metaboxes_cpt_images')//callback
    );
}


/*
 * Displays metabox for Shortcodes
 */
function a13_meta_shortcodes( $post ){
    require_once (TPL_SHORTCODES_DIR . '/shortcodes-generate.php');
    $raw = apollo13_shortcodes();

    $categories = '<select id="shortcode-categories" name="shortcode-categories"><option value="">' . __be( 'Select category' ) . '</option>';
    $inHtml = '';

    foreach($raw as $cats){
        $categories .= '<option value="' . $cats['id'] . '">' . $cats['name'] . '</option>';
        $bufor = '';
        $subcategories = '';
        //generate subcats and fields
        foreach($cats['codes'] as $code){
            $subcategories .= '<option value="' . $code['code'] . '">' . $code['name'] . '</option>';

            $fields = '<div id="apollo13-' . $code['code'] . '-fields" class="shortcodes-fields apollo13-settings">';
            foreach($code['fields'] as $field){
                $fields .= apollo13_shortcodes_make_field( $field, $code['code'] );
            }
            $fields .= '</div>';
            $bufor .= $fields;
        }
        if ( $subcategories != '' ){
            $subid = 'apollo13-' . $cats['id'] . '-codes';
            $subcategories = '<select id="' . $subid . '" name="' . $subid . '" class="shortcodes-codes">' . $subcategories . '</select>';
        }
        $inHtml .= $subcategories;
        $inHtml .= $bufor;
    }

    $categories .= '</select>';

    $html = '<div id="shortcode-generator">';
    $html .= $categories;
    $html .= $inHtml;
    $html .= '<div class="buttons-parent"><span class="button" id="send-to-editor">' . __be( 'Insert code in editor' ) . '</span></div>';
    $html .= '</div>';
    echo $html;
}


/*
 * Generates inputs in metaboxes
 */
function a13_meta_main_opts( $post, $metabox ){

    // Use nonce for verification
    wp_nonce_field( 'apollo13_customization' , 'apollo13_noncename' );

    require_once (TPL_ADV_DIR . '/meta.php');
    $metaboxes = $metabox['args']['func']();

    $fieldset_open = false;
    $switches = array();
    $additive_mode = false;
    $thumbs_mode = false;

    echo '<div class="apollo13-settings apollo13-metas">';

    foreach( $metaboxes as &$meta ){
        //modes and modificators
        $value = '';
        if ( isset( $meta['id'] ) ){
            $value = get_post_meta($post->ID, '_' . $meta['id'] , true);

            //use default if no value
            if( !strlen($value) ){
                $value = ( isset( $meta['default'] )? $meta['default'] : '' );
            }
        }

        if ( isset( $meta['switch'] ) && $meta['switch'] == true ) {
            echo '<div class="switch">';
            //add to switches array
            array_push($switches, $value);
        }

        $params = array(
            'style' => '',
            'value' => $value
        );

        /*
        * print tag according to type
        */

        if ( $meta['type'] == 'fieldset' ) {
            if ( $fieldset_open ) {
                a13_close_meta_fieldset($thumbs_mode);
            }

            $title = '';
            $class = ' static';
            if( isset( $meta['additive'] ) && $meta['additive'] == true ){
                $class = ' additive';
                $title = ' title="' . $meta['title'] . '"';//number of element
                $additive_mode = true;

                //only one copy of counter input
                if( $meta['title'] == 1 ){
                    echo '<input id="' . $meta['id'] . '" name="' . $meta['id'] . '" type="hidden" class="counter-input" value="' . $value . '" />';
                    //we change table here to print multiple pattern of fields
                    a13_additive_array_trick($metaboxes, $value);
                }
            }

            echo '<div class="fieldset' . $class . '"' . $title . '>';
            $fieldset_open = true;

            if(isset($meta['for_thumbs']) && $meta['for_thumbs'] ==  true){
                $thumbs_mode = true;
                echo '
                    <div class="thumb-info">
                        <img style="display: none;" src="" alt="" />
                        <span class="thumb-show-fields" data-swaptext="' . __be('Hide') . '">' . __be('Show') . '</span>
                        <span class="thumb-title"></span>
                    </div>
                    <div class="thumb-fields" style="display: none;">';
            }
        }

        //checks for all normal options
        elseif( a13_print_form_controls($meta, $params, true ) ){
            continue;
        }

        /***********************************************
         * SPECIAL field types
         ************************************************/

        elseif ( $meta['type'] == 'switch-group' ) {
            $style_group = ' style="display: none;"';
            $switch_value = end($switches);
            //check if current group should be visible
            if(strlen($switch_value && $switch_value == $meta['name'])){
                $style_group = '';
            }

            echo '<div class="switch-group" data-switch="'.$meta['name'].'"'.$style_group.'>';
        }

        elseif ( $meta['type'] == 'switch-group-end' ) {
            echo '</div>';
        }

        elseif ( $meta['type'] == 'end-switch' ) {
            //remove last added switch
            array_pop($switches);
            echo '</div>';
//            var_dump($switches);
        }

        /* position marking */
        elseif ( $meta['type'] == 'mover' ) {

            ?>

        <div class="mover">
            <input id="<?php echo $meta['id']; ?>" type="hidden" class="position" name="<?php echo $meta['id']; ?>" value="<?php echo $value; ?>" />
        </div>

        <?php

        }

        elseif ( $meta['type'] == 'adder' ) {
            if ( $fieldset_open ) {
                a13_close_meta_fieldset($thumbs_mode);
                $fieldset_open = false;
                $additive_mode = false;
                $thumbs_mode = false;
            }
            echo '<div class="add-more-parent"><span class="button button-hero add-more-fields"><span>+</span>' . $meta['name'] . '</span></div>';
        }

        elseif ( $meta['type'] == 'multi-upload' ) {
            global $wp_version;
            if( version_compare($wp_version,"3.3",">=") ){
                // so here's the actual uploader
                // most of the code comes from media.php and handlers.js

                ?>

            <h4 style="text-align: center;"><?php _be( 'Multi upload area' ); ?></h4>
            <div id="plupload-upload-ui" class="hide-if-no-js">
                <div id="drag-drop-area">
                    <div class="drag-drop-inside">
                        <div class="loading">
                            <p class="drag-drop-info"><?php _be('Uploading files...' ); ?></p>
                        </div>
                        <div class="not-loading">
                            <p class="drag-drop-info"><?php _be('Drop files here' ); ?></p>
                            <p><?php _ex('or', 'Uploader: Drop files here - or - Select Files', TPL_SLUG); ?></p>
                            <p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e( __be('Select Files') ); ?>" class="button" /></p>
                        </div>
                    </div>
                </div>
                <div class="file-list"></div>
            </div>

            <?php
                $plupload_init = array(
                    'runtimes'            => 'html5,silverlight,flash,html4',
                    'browse_button'       => 'plupload-browse-button',
                    'container'           => 'plupload-upload-ui',
                    'drop_element'        => 'drag-drop-area',
                    'file_data_name'      => 'async-upload',
                    'multiple_queues'     => true,
                    'max_file_size'       => wp_max_upload_size().'b',
                    'url'                 => admin_url('admin-ajax.php'),
                    'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
                    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
                    'filters'             => array(array('title' => __be( 'Allowed Files' ), 'extensions' => '*')),
                    'multipart'           => true,
                    'urlstream_upload'    => true,

                    // additional post data to send to our ajax hook
                    'multipart_params'    => array(
                        '_ajax_nonce'   => wp_create_nonce('photo-upload'),
                        'action'        => 'album_multi_upload',            // the ajax action name
                        'post_id'       => get_the_ID()
                    )
                );
                ?>

            <script type="text/javascript">

                jQuery(document).ready(function($){

                    // create the uploader and pass the config from above
                    var apollo_uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>),
                        upload_div = $('#plupload-upload-ui'),
                        AMU = A13_ADMIN.mupload;

                    // checks if browser supports drag and drop upload, makes some css adjustments if necessary
                    apollo_uploader.bind('Init', function(up){

                        if(up.features.dragdrop){
                            upload_div.addClass('drag-drop');
                            $('#drag-drop-area')
                                .bind('dragover.wp-uploader', function(){ upload_div.addClass('drag-over'); })
                                .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ upload_div.removeClass('drag-over'); });

                        }else{
                            upload_div.removeClass('drag-drop');
                            $('#drag-drop-area').unbind('.wp-uploader');
                        }
                    });

                    apollo_uploader.init();

                    // a file was added in the queue
                    apollo_uploader.bind('FilesAdded', AMU.filesAdded );

                    //update upload progress
                    apollo_uploader.bind('UploadProgress', AMU.uploadProgress );

                    // a file was uploaded
                    apollo_uploader.bind('FileUploaded', AMU.fileUploaded );

                    // upload of all file has completed
                    apollo_uploader.bind('UploadComplete', AMU.uploadComplete );
                });

            </script>

            <?php
            }
        }

        elseif ( $meta['type'] == 'multi-upload-WP3.5' ) {
            global $wp_version;
            if( version_compare($wp_version,"3.5",">=") ){
                echo '<div class="a13-mu-container">
                        <input id="a13-multi-upload" type="button" value="'.esc_attr( __be('Select/Upload many images') ).'" class="button button-hero" />
                        <p class="desc">'.__be('To mark more items in Media Library hold <code>Ctrl</code> or <code>Cmd</code> key while selecting them.').'</p>
                     </div>';
            }
        }
    } //end foreach

    unset($meta);// be safe, don't loose your hair :-)

    //close fieldset
    if ( $fieldset_open ) {
        a13_close_meta_fieldset($thumbs_mode);
    }

    echo '</div>';//.apollo13-settings .apollo13-metas
}


function a13_close_meta_fieldset($thumbs_mode){
    if($thumbs_mode == true){
        echo '</div>';
    }
    echo '</div>';
}


/*
 * Saving metas in post
 */
function a13_save_post($post_id){
    static $done = 0;
    $done++;
    if( $done > 1 ){
        return;//no double saving same things
    }

    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if( ! isset( $_POST['apollo13_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['apollo13_noncename'], 'apollo13_customization' ) )
        return;

    require_once (TPL_ADV_DIR . '/meta.php');

    $metaboxes = array();

    switch( $_POST['post_type'] ){
        case 'post':
            $metaboxes = apollo13_metaboxes_post();
            break;
        case 'page':
            $metaboxes = apollo13_metaboxes_page();
            break;
        case CUSTOM_POST_TYPE_WORK:
            $metaboxes = array_merge( apollo13_metaboxes_cpt_work(), apollo13_metaboxes_cpt_images() );
            break;
        case CUSTOM_POST_TYPE_GALLERY:
            $metaboxes = array_merge( apollo13_metaboxes_cpt_gallery(), apollo13_metaboxes_cpt_images() );
            break;
    }

    //saving meta
    foreach( $metaboxes as &$meta ){
        if( $meta['type'] == 'fieldset' && isset( $meta['additive'] ) && $meta['additive'] == true ){
            if( $meta['title'] == 1 ){
                //we change table here to save multiple pattern of fields
                a13_additive_array_trick($metaboxes, $_POST[ $meta['id'] ]);
            }
        }
        if( isset( $meta['id'] ) && isset( $_POST[ $meta['id'] ] ) && $meta['type'] != 'adder' ){
            $val = $_POST[ $meta['id'] ];
            update_post_meta( $post_id, '_' . $meta['id'] , $val );
        }
    }
}


/*
* Function to modify meta array by coping multiple fields pattern(additive fields) inside array
*/
function a13_additive_array_trick(&$array, $iterations = 1){
    //rewind one element to save current position, so we can return to it after operations
    prev($array);
    $current = key( $array );
    $array_part_copy = array();

    //get all fields from additive fieldset
    do{
        $array_part_copy[ key( $array ) ] = current( $array );
    }
    while( ($next_elem = next( $array )) && $next_elem['type'] != 'adder' );

    $length_to_cut_off = count($array_part_copy);

    //make new array part
    $new_array_part = array();
    for( $iter = 1; $iter <= $iterations; $iter++ ){
        foreach( $array_part_copy as $meta ){
            if( $meta['type'] == 'fieldset'){
                $meta['title'] = $iter;
            }
            else{
                //rewrite id
                if( isset( $meta['id'] ) ){
                    $meta['id'] .= '_' . $iter;
                }

                //switch group
                if( $meta['type'] == 'switch-group' ){
                    $meta['name'] .= '_' . $iter;
                }

                //rewrite switch radios/options
                if( isset( $meta['options'] ) && isset( $meta['switch'] )  ){
                    $new_arr = array();
                    foreach( $meta['options'] as $html_value => $html_option ) {
                        $new_arr[ $html_value . '_' . $iter ] = $html_option;
                    }
                    $meta['options'] = $new_arr;

                    //alter also default value
                    if( isset( $meta['default']) && !empty($meta['default']) ){
                        $meta['default'] .= '_' . $iter;
                    }
                }
            }
            $new_array_part[] = $meta;
        }
    }

    //combine tables
    array_splice( $array, $current, $length_to_cut_off, $new_array_part );

    //rewind array to proper place
    reset( $array );
    while ( key( $array ) !== $current ) next( $array );
    //point to next
    next( $array );
}




add_action( 'add_meta_boxes', 'a13_admin_meta_boxes');
//Do something with the data entered
add_action( 'save_post', 'a13_save_post' );

