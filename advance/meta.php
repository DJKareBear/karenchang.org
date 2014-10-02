<?php
/*
 * id - must be
 *
 * TYPES:
 * +fieldset
 * radio
 * +wp_dropdown_albums
 * +input
 * +textarea
 * +color
 * +upload
 * +select
 * slider
 * social
 * +switch
 * !multi-upload
 * !hidden
 * !mover
 * !adder
 * +end-switch
 *
 * */

	function apollo13_metaboxes_post(){
		$meta = array(
			array(
				'name' => '',
				'type' => 'fieldset',
			),
            array(
                'name' => __be( 'Post media' ),
                'desc' =>__be( 'Choose between Image and Video/Audio. For image use Featured Image Option' ),
                'id' => 'image_or_video',
                'default' => 'post_image',
                'options' => array(
                    'post_image' => __be( 'Image' ),
                    'post_video' => __be( 'Video/Audio' ),
//                    'post_slides' => __be( 'Album slider' )
                ),
                'switch' => true,
                'type' => 'select',
            ),
            array(
                'name' => 'post_image',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Image behavior' ),
                'desc' => '',
                'id' => 'image_stretch',
                'default' => 'align-center',
                'options' => array(
                    'align-left'   => __be( 'Align left' ),
                    'align-right'  => __be( 'Align right' ),
                    'align-center' => __be( 'Center' ),
                    'stretch-full' => __be( 'Take full space' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Image size' ),
                'desc' => '',
                'id' => 'image_size',
                'default' => 'auto',
                'options' => array(
                    'auto'      => __be( 'Automatic' ),
                    'medium'    => __be( 'Medium' ),
                    'big'       => __be( 'Big' ),
                    'original'  => __be( 'Original' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'post_image',*/
                'type' => 'switch-group-end'
            ),
            array(
                'name' => 'post_video',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Link to video/audio' ),
                'desc' => '',
                'id' => 'post_video',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Video behavior' ),
                'desc' => '',
                'id' => 'video_align',
                'default' => 'stretch-full',
                'options' => array(
                    'align-left'   => __be( 'Align left' ),
//                    'align-right'  => __be( 'Align right' ),
                    'align-center' => __be( 'Center' ),
                    'stretch-full' => __be( 'Take full space' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Video size' ),
                'desc' => '',
                'id' => 'video_size',
                'default' => 'medium',
                'options' => array(
                    'medium'    => __be( 'Medium' ),
                    'big'       => __be( 'Big' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'post_video',*/
                'type' => 'switch-group-end'
            ),
            /*array(
                'name' => 'post_slides',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Select gallery or work items set' ),
                'desc' => '',
                'id' => 'post_slides',
                'default' => '0',
                'pre_options' => array(
                    '0' => __be( 'None' )
                ),
                'type' => 'wp_dropdown_albums',
            ),
            array(*/
                /*'name' => 'post_slides',*/
                /*'type' => 'switch-group-end'
            ),*/
            array(
                /*'id' => 'image_or_video',  just for readability */
                'type' => 'end-switch',
            ),
            array(
                'name' => __be( 'Sidebar' ),
                'desc' => __be( 'If turned off, content will take full width.' ),
                'id' => 'widget_area',
                'global_value' => 'G',
                'default' => 'G',
                'parent_option' => array('blog', 'post_sidebar'),
                'options' => array(
                    'G'   => __be( 'Global settings' ),
                    'on'  => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'select',
            ),
		);
		
		return $meta;
	}
	
	function apollo13_metaboxes_page(){
		$meta = array(
			array(
				'name' => '',
				'type' => 'fieldset'
			),
            array(
                'name' => __be( 'Subtitle' ),
                'desc' => '',
                'id' => 'subtitle',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Menu short description' ),
                'desc' => __be( 'It works only for first level menu items.' ),
                'id' => 'menu_desc',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Menu icon' ),
                'desc' => __be( 'It works only for first level menu items.' ) .' '. __be( ' You can see available icons at <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a>. You have to use code of icon that looks like <code>icon-medkit</code>. To add more icons separate them with white space.' ),
                'id' => 'menu_icon',
                'default' => '',
                'placeholder' => 'icon-phone',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Post media' ),
                'desc' =>__be( 'Choose between Image and Video/Audio. For image use Featured Image Option' ),
                'id' => 'image_or_video',
                'default' => 'post_image',
                'options' => array(
                    'post_image' => __be( 'Image' ),
                    'post_video' => __be( 'Video/Audio' ),
//                    'post_slides' => __be( 'Album slider' )
                ),
                'switch' => true,
                'type' => 'select',
            ),
            array(
                'name' => 'post_image',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Image behavior' ),
                'desc' => '',
                'id' => 'image_stretch',
                'default' => 'align-center',
                'options' => array(
                    'align-left'   => __be( 'Align left' ),
                    'align-right'  => __be( 'Align right' ),
                    'align-center' => __be( 'Center' ),
                    'stretch-full' => __be( 'Take full space' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Image size' ),
                'desc' => '',
                'id' => 'image_size',
                'default' => 'auto',
                'options' => array(
                    'auto'      => __be( 'Automatic' ),
                    'medium'    => __be( 'Medium' ),
                    'big'       => __be( 'Big' ),
                    'original'  => __be( 'Original' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'post_image',*/
                'type' => 'switch-group-end'
            ),
            array(
                'name' => 'post_video',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Link to video/audio' ),
                'desc' => '',
                'id' => 'post_video',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Video behavior' ),
                'desc' => '',
                'id' => 'video_align',
                'default' => 'stretch-full',
                'options' => array(
                    'align-left'   => __be( 'Align left' ),
//                    'align-right'  => __be( 'Align right' ),
                    'align-center' => __be( 'Center' ),
                    'stretch-full' => __be( 'Take full space' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Video size' ),
                'desc' => '',
                'id' => 'video_size',
                'default' => 'medium',
                'options' => array(
                    'medium'    => __be( 'Medium' ),
                    'big'       => __be( 'Big' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'post_video',*/
                'type' => 'switch-group-end'
            ),
            /*array(
                'name' => 'post_slides',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Select gallery or work items set' ),
                'desc' => '',
                'id' => 'post_slides',
                'default' => '0',
                'pre_options' => array(
                    '0' => __be( 'None' )
                ),
                'type' => 'wp_dropdown_albums',
            ),
            array(*/
                /*'name' => 'post_slides',*/
                /*'type' => 'switch-group-end'
            ),*/
            array(
                /*'id' => 'image_or_video',  just for readability */
                'type' => 'end-switch',
            ),
            array(
                'name' => __be( 'Page layout' ),
                'desc' => '',
                'id' => 'page_layout',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('appearance', 'page_layout'),
                'options' => array(
                    'G'            => __be( 'Global settings' ),
                    'static-left'   => __be( 'Left' ),
                    'static-right'  => __be( 'Right' ),
                    'static-center' => __be( 'Center' ),
                    'static-full'   => __be( 'Full width' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Content color' ),
                'desc' => '',
                'id' => 'page_color',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('appearance', 'page_color'),
                'options' => array(
                    'G'     => __be( 'Global settings' ),
                    'content-light' => __be( 'Light' ),
                    'content-dark'  => __be( 'Dark' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Show "hiding cross"' ),
                'desc' => '',
                'id' => 'hiding_cross',
                'default' => 'auto',
                'options' => array(
                    'auto' => __be( 'Automatic' ),
                    'off'  => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Background image' ),
                'desc' =>__be( 'You can use global settings or overwrite them here' ),
                'id' => 'bg_settings',
                'default' => 'bg_global',
                'type' => 'radio',
                'options' => array(
                    'bg_global' => __be( 'Global settings' ),
                    'bg_image' => __be( 'Use custom image' )
                ),
                'switch' => true,
            ),
            array(
                'name' => 'bg_image',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Background image file' ),
                'desc' => '',
                'id' => 'bg_image',
                'default' => '',
                'button_text' => __be('Upload Image'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'How to fit background image' ),
                'desc' => __be( 'In Internet Explorer 8 and lower whatever you will choose(except <em>repeat</em>) it will look like "Just center"' ),
                'id' => 'bg_image_fit',
                'default' => 'cover',
                'options' => array(
                    'cover'     => __be( 'Cover' ),
                    'contain'   => __be( 'Contain' ),
                    'fitV'      => __be( 'Fit Vertically' ),
                    'fitH'      => __be( 'Fit Horizontally' ),
                    'center'    => __be( 'Just center' ),
                    'repeat'    => __be( 'Repeat' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Background color' ),
                'desc' => __be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'bg_image_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                /*'name' => 'bg_image',*/
                'type' => 'switch-group-end'
            ),
            array(
                /*'id' => 'bg_settings',  just for readability */
                'type' => 'end-switch',
            ),
		);
		
		return $meta;
	}
	
	function apollo13_metaboxes_cpt_work(){
		$meta = array(
			array(
				'name' => '',
				'type' => 'fieldset'
			),
            array(
                'name' => __be( 'Subtitle' ),
                'desc' => '',
                'id' => 'subtitle',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Menu short description' ),
                'desc' => __be( 'It works only for first level menu items.' ),
                'id' => 'menu_desc',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Menu icon' ),
                'desc' => __be( 'It works only for first level menu items.' ) .' '. __be( ' You can see available icons at <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a>. You have to use code of icon that looks like <code>icon-medkit</code>. To add more icons separate them with white space.' ),
                'id' => 'menu_icon',
                'default' => '',
                'placeholder' => 'icon-phone',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Alternative Link' ),
                'desc' => __be('If you fill this then clicking in your work on works list will not lead to single work page but to link from this field.'),
                'id' => 'alt_link',
                'default' => '',
                'type' => 'input',
            ),
            array(
                'name' => __be( 'Items order' ),
                'desc' => __be( 'It will display your images/videos from first to last, or another way.' ),
                'id' => 'order',
                'default' => 'ASC',
                'options' => array(
                    'ASC' => __be( 'First on list, first displayed' ),
                    'DESC' => __be( 'First on list, last displayed' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Internet address' ),
                'desc' => '',
                'id' => 'www',
                'default' => '',
                'placeholder' => 'http://link-to-somewhere.com',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Custom info 1' ),
                'desc' => __be('If empty it won\'t be displayed. Use pattern <b>Field name: Field value</b>. Colon(:) is most important to get full result.'),
                'id' => 'custom_1',
                'default' => '',
                'placeholder' => 'Label: value',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Custom info 2' ),
                'desc' => __be('If empty it won\'t be displayed. Use pattern <b>Field name: Field value</b>. Colon(:) is most important to get full result.'),
                'id' => 'custom_2',
                'default' => '',
                'placeholder' => 'Label: value',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Custom info 3' ),
                'desc' => __be('If empty it won\'t be displayed. Use pattern <b>Field name: Field value</b>. Colon(:) is most important to get full result.'),
                'id' => 'custom_3',
                'default' => '',
                'placeholder' => 'Label: value',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Custom info 4' ),
                'desc' => __be('If empty it won\'t be displayed. Use pattern <b>Field name: Field value</b>. Colon(:) is most important to get full result.'),
                'id' => 'custom_4',
                'default' => '',
                'placeholder' => 'Label: value',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Custom info 5' ),
                'desc' => __be('If empty it won\'t be displayed. Use pattern <b>Field name: Field value</b>. Colon(:) is most important to get full result.'),
                'id' => 'custom_5',
                'default' => '',
                'placeholder' => 'Label: value',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Present media in:' ),
                'desc' => '',
                'id' => 'theme',
                'default' => 'scroller',
                'options' => array(
                    'scroller'      => __be( 'Scroller' ),
                    'slider'        => __be( 'Slider' ),
                    'full_photos'   => __be('Full width photos')
                ),
                'switch' => true,
                'type' => 'select',
            ),
            array(
                'name' => 'slider',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Fit images' ),
                'desc' => __be( 'How will images fit area. <strong>Fit when needed</strong> is best for small images, that shouldn\'t be streched to bigger sizes, only to smaller(to keep them visible).' ),
                'id' => 'fit_variant',
                'default' => '0',
                'options' => array(
                    '0' => __be( 'Fit always' ),
                    '1' => __be( 'Fit landscape' ),
                    '2' => __be( 'Fit portrait' ),
                    '3' => __be( 'Fit when needed' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Autoplay' ),
                'desc' => __be( 'If autoplay is on, album items will start sliding on page load' ),
                'id' => 'autoplay',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('cpt_work', 'autoplay'),
                'options' => array(
                    'G' => __be( 'Global settings' ),
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Transition type' ),
                'desc' => __be( 'Animation between slides.' ),
                'id' => 'transition',
                'default' => '-1',
                'global_value' => '-1',
                'parent_option' => array('cpt_work', 'transition_type'),
                'options' => array(
                    '-1' => __be( 'Global settings' ),
                    '0' => __be( 'None' ),
                    '1' => __be( 'Fade' ),
                    '2' => __be( 'Carousel' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Random slide order' ),
                'desc' => '',
                'id' => 'random',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('cpt_work', 'random'),
                'options' => array(
                    'G' => __be( 'Global settings' ),
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'slider',*/
                'type' => 'switch-group-end'
            ),
            array(
                /*'id' => 'theme',  just for readability */
                'type' => 'end-switch',
            ),
		);
		
		return $meta;
	}

	function apollo13_metaboxes_cpt_gallery(){
		$meta = array(
			array(
				'name' => '',
				'type' => 'fieldset'
			),
            array(
                'name' => __be( 'Menu short description' ),
                'desc' => __be( 'It works only for first level menu items.' ),
                'id' => 'menu_desc',
                'default' => '',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Menu icon' ),
                'desc' => __be( 'It works only for first level menu items.' ) .' '. __be( ' You can see available icons at <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a>. You have to use code of icon that looks like <code>icon-medkit</code>. To add more icons separate them with white space.' ),
                'id' => 'menu_icon',
                'default' => '',
                'placeholder' => 'icon-phone',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Items order' ),
                'desc' => __be( 'It will display your images/videos from first to last, or another way.' ),
                'id' => 'order',
                'default' => 'ASC',
                'options' => array(
                    'ASC' => __be( 'First on list, first displayed' ),
                    'DESC' => __be( 'First on list, last displayed' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Theme' ),
                'desc' => '',
                'id' => 'theme',
                'default' => 'bricks',
                'options' => array(
                    'slider' => __be( 'Slider' ),
                    'bricks' => __be( 'Bricks' ),
                ),
                'switch' => true,
                'type' => 'select',
            ),
            array(
                'name' => 'slider',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Fit images' ),
                'desc' => __be( 'How will images fit area. <strong>Fit when needed</strong> is best for small images, that shouldn\'t be streched to bigger sizes, only to smaller(to keep them visible).' ),
                'id' => 'fit_variant',
                'default' => '0',
                'options' => array(
                    '0' => __be( 'Fit always' ),
                    '1' => __be( 'Fit landscape' ),
                    '2' => __be( 'Fit portrait' ),
                    '3' => __be( 'Fit when needed' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Autoplay' ),
                'desc' => __be( 'If autoplay is on, album items will start sliding on page load' ),
                'id' => 'autoplay',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('cpt_gallery', 'autoplay'),
                'options' => array(
                    'G' => __be( 'Global settings' ),
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Transition type' ),
                'desc' => __be( 'Animation between slides.' ),
                'id' => 'transition',
                'default' => '-1',
                'global_value' => '-1',
                'parent_option' => array('cpt_gallery', 'transition_type'),
                'options' => array(
                    '-1' => __be( 'Global settings' ),
                    '0' => __be( 'None' ),
                    '1' => __be( 'Fade' ),
                    '2' => __be( 'Carousel' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Random slide order' ),
                'desc' => '',
                'id' => 'random',
                'default' => 'G',
                'global_value' => 'G',
                'parent_option' => array('cpt_gallery', 'random'),
                'options' => array(
                    'G' => __be( 'Global settings' ),
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'slider',*/
                'type' => 'switch-group-end'
            ),
            array(
                'name' => 'bricks',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Hover Effect' ),
                'desc' => '',
                'id' => 'hover_type',
                'default' => 'cover-loop',
                'type' => 'radio',
                'options' => array(
                    'cover-loop' => __be( 'Cover' ),/* cause of CSS class collision */
                    'uncover' => __be( 'Uncover' )
                ),
            ),
            array(
                /*'name' => 'bricks',*/
                'type' => 'switch-group-end'
            ),
            array(
                /*'id' => 'theme',  just for readability */
                'type' => 'end-switch',
            ),
            array(
                'name' => __be( 'Background image' ),
                'desc' =>__be( 'You can use global settings or overwrite them here' ),
                'id' => 'bg_settings',
                'default' => 'bg_global',
                'type' => 'radio',
                'options' => array(
                    'bg_global' => __be( 'Global settings' ),
                    'bg_image' => __be( 'Use custom image' )
                ),
                'switch' => true,
            ),
            array(
                'name' => 'bg_image',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Background image file' ),
                'desc' => '',
                'id' => 'bg_image',
                'default' => '',
                'button_text' => __be('Upload Image'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'How to fit background image' ),
                'desc' => __be( 'In Internet Explorer 8 and lower whatever you will choose(except <em>repeat</em>) it will look like "Just center"' ),
                'id' => 'bg_image_fit',
                'default' => 'cover',
                'options' => array(
                    'cover'     => __be( 'Cover' ),
                    'contain'   => __be( 'Contain' ),
                    'fitV'      => __be( 'Fit Vertically' ),
                    'fitH'      => __be( 'Fit Horizontally' ),
                    'center'    => __be( 'Just center' ),
                    'repeat'    => __be( 'Repeat' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Background color' ),
                'desc' => __be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'bg_image_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                /*'name' => 'bg_image',*/
                'type' => 'switch-group-end'
            ),
            array(
                /*'id' => 'bg_settings',  just for readability */
                'type' => 'end-switch',
            ),
		);

		return $meta;
	}

	function apollo13_metaboxes_cpt_images(){
		$meta = array(
			array(
				'name' => '',
				'type' => 'fieldset'
			),
			array(
				'name' => __be( 'Multi upload' ),
				'desc' => '',
				'id' => 'multi-upload',
				'type' => 'multi-upload-WP3.5',
			),
			array(
				'name' => '',
				'type' => 'fieldset',
				'additive' => true,
				'default' => '1',
				'title' => '1',
                'for_thumbs' => true,
				'id' => 'image_count'
			),
            array(
                'name' => __be( 'Choose image or video' ),
                'desc' =>__be( 'Choose between Image or Video' ),
                'id' => 'image_or_video',
                'default' => 'post_image',
                'type' => 'radio',
                'switch' => true,
                'options' => array(
                    'post_image' => __be( 'Image' ),
                    'post_video' => __be( 'Video' )
                ),
            ),
            array(
                'name' => 'post_image',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Attachment id' ),
                'desc' => '',
                'id' => 'post_image_id',
                'default' => '',
                'for_thumb' => true,
                'type' => 'hidden'
            ),
            array(
                'name' => __be( 'Upload image' ),
                'desc' => '',
                'id' => 'post_image',
                'default' => '',
                'button_text' => __be('Upload Image'),
                'for_thumb' => true,
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'Link' ),
                'desc' => __be('Alternative link'),
                'id' => 'post_image_link',
                'default' => '',
                'type' => 'input',
            ),
            array(
                'name' => __be( 'Color under photo' ),
                'desc' => __be( 'Leave empty to use album default.' ) . ' ' . __be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'bg_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                /*'name' => 'post_image',*/
                'type' => 'switch-group-end'
            ),
            array(
                'name' => 'post_video',
                'type' => 'switch-group'
            ),
            array(
                'name' => __be( 'Link to video' ),
                'desc' => '',
                'id' => 'post_video',
                'default' => '',
                'input_class' => 'for-thumb-title-video',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Video Thumb' ),
                'desc' => __be( 'Displayed instead of video placeholder in some cases. If none, placeholder will be used(for youtube movies default thumbnail will show).' ),
                'id' => 'video_thumb',
                'default' => '',
                'button_text' => __be('Upload Image'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'Autoplay video' ),
                'desc' => '',
                'id' => 'video_autoplay',
                'default' => '0',
                'options' => array(
                    '1'  => __be( 'On' ),
                    '0' => __be( 'Off' ),
                ),
                'type' => 'select',
            ),
            array(
                /*'name' => 'post_video',*/
                'type' => 'switch-group-end'
            ),
            array(
                /*'id' => 'image_or_video',  just for readability */
                'type' => 'end-switch',
            ),
            array(
                'name' => __be( 'Title' ),
                'desc' => '',
                'id' => 'post_image_name',
                'default' => '',
                'input_class' => 'for-thumb-title',
                'type' => 'input'
            ),
            array(
                'name' => __be( 'Description' ),
                'desc' => '',
                'id' => 'post_image_desc',
                'default' => '',
                'type' => 'textarea',
            ),
			array(
				'id' => 'image_position',
				'default' => '1',
				'type' => 'mover',
			),
			array(
				'name' => __be( 'Add next image or video' ),
				'desc' => '',
				'default' => '1',
				'type' => 'adder',
			),
		);
		
		return $meta;
	}