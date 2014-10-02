<?php

/*
 * TYPES:
 * fieldset
 * radio
 * wp_dropdown_galleries
 * input
 * textarea
 * color
 * upload
 * select
 * slider
 * social
 *
 * */

	function apollo13_settings_options(){
		
		$opt = array(
            array(
                'name' => __be( 'Front page' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_front_page',
                'help' => '#!/main_settings_menu'
            ),
            array(
                'name' => __be( 'What to show on front page?' ),
                'desc' => __be( 'If you choose <strong>Page</strong> then make sure that in Settings->Reading->Front page displays'
                                . ' you selected <strong>A static page</strong>, that you wish to use.<br />' ),

                'id' => 'fp_variant',
                'default' => 'works_list',
                'options' => array(
                    'page'          => __be( 'Page' ),
                    'blog'          => __be( 'Blog' ),
                    'works_list'    => __be( 'Works list' ),
                    'galleries_list'    => __be( 'Galleries list' ),
                    'gallery'       => __be( 'Selected gallery' ),
                    'revo'          => __be( 'Selected Revolution Slider' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Select gallery to use as front page' ),
                'desc' => '',
                'id' => 'fp_gallery',
                'default' => '',
                'type' => 'wp_dropdown_galleries',
            ),
            array(
                'name' => __be( 'Select Revolution Slider to use as front page' ),
                'desc' => '',
                'id' => 'fp_revoslider',
                'default' => '',
                'type' => 'wp_dropdown_revosliders',
            ),


            array(
                'name' => __be( 'Layout texts' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_layout_text'
            ),
            array(
                'name' => __be( 'Under logo text' ),
                'desc' => '',
                'id' => 'under_logo_text',
                'default' => 'Minimalistic theme created for Designers and Creatives.',
                'type' => 'textarea',
            ),
            array(
                'name' => __be( 'Footer text' ),
                'desc' => '',
                'id' => 'footer_text',
                'default' => 'All works is copyrighted
to their respective owners.

Illustrations made by <a href="http://www.behance.net/Chkn" target="_blank">Chkn</a>',
                'type' => 'textarea',
            ),
            array(
                'name' => __be( 'Copyright text' ),
                'desc' => '',
                'id' => 'copyright_text',
                'default' => '&copy; 2013 by Apollo13',
                'type' => 'textarea',
            ),


			array(
				'name' => __be( 'Contact form settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_contact_form'
			),
			array(
				'name' => __be( 'E-mail address where e-mails will be sent:' ),
				'desc' => __be( 'If empty, will use admin site e-mail' ),
				'id' => 'contact_email',
				'default' => '',
				'type' => 'input',
			),


			array(
				'name' => __be( 'Google Analytics' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_google_anal'
			),
			array(
				'name' => __be( 'Enter code here from GA here:' ),
				'desc' => '',
				'id' => 'ga_code',
				'default' => '',
				'type' => 'textarea',
			),
		);
		
		return $opt;
	}

	function apollo13_fonts_options(){
        $classic_fonts = array(
            'default'           => __be( 'Defined in CSS' ),
            'arial'             => __be( 'Arial' ),
            'calibri'           => __be( 'Calibri' ),
            'cambria'           => __be( 'Cambria' ),
            'georgia'           => __be( 'Georgia' ),
            'tahoma'            => __be( 'Tahoma' ),
            'times new roman'   => __be( 'Times new roman' ),
        );

		$opt = array(
			array(
				'name' => __be( 'Fonts settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_fonts',
                'help' => '#!/fonts_menu'
			),

			array(
				'name' => __be( 'Font for normal(content) text:' ),
				'desc' => __be( 'If you choose <strong>classic font</strong> then remember that this setting depends on fonts installed on client device.<br />'.
                                'If you choose <strong>google font</strong> then remember to choose needed variants and subsets. Read more in documentation.<br />'.
                                'For preview google font is loaded with variants regular and 700, and all available subsets.'),
				'id' => 'normal_fonts',
				'default' => 'arial',
				'options' => $classic_fonts,
				'type' => 'font',
			),

			array(
				'name' => __be( 'Font for Titles/Headings:' ),
				'desc' => __be( 'If you choose <strong>classic font</strong> then remember that this setting depends on fonts installed on client device.<br />'.
                                'If you choose <strong>google font</strong> then remember to choose needed variants and subsets. Read more in documentation.<br />'.
                                'For preview google font is loaded with variants regular and 700, and all available subsets.'),
				'id' => 'titles_fonts',
				'default' => 'Montserrat:regular,700',
				'options' => $classic_fonts,
				'type' => 'font',
			),

			array(
				'name' => __be( 'Font for top nav menu, interactive elements, short labels, etc.:' ),
				'desc' => __be( 'If you choose <strong>classic font</strong> then remember that this setting depends on fonts installed on client device.<br />'.
                                'If you choose <strong>google font</strong> then remember to choose needed variants and subsets. Read more in documentation.<br />'.
                                'For preview google font is loaded with variants regular and 700, and all available subsets.'),
				'id' => 'nav_menu_fonts',
				'default' => 'Montserrat:regular,700',
				'options' => $classic_fonts,
				'type' => 'font',
			),
		);
		
		return $opt;
	}

	function apollo13_appearance_options(){
		$opt = array(
            array(
                'name' => __be( 'Main appearance settings' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_main_app_settings',
                'help' => '#!/appearance_menu_main_appearance_settings'
            ),
            array(
                'name' => __be( 'Favicon' ),
                'desc' =>__be( 'Enter an URL or upload an image for favicon. It will appear in adress bar or on tab in browser. Image should be square (16x16px or 32x32px). Paste the full URL (include <code>http://</code>).' ),
                'id' => 'favicon',
                'default' => get_template_directory_uri().'/images/icon.png',
                'button_text' => __be('Upload/Select Image'),
                'media_button_text' => __be('Insert favicon'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'Custom background image' ),
                'desc' =>__be( 'Enter an URL or upload an image for background. Paste the full URL (include <code>http://</code>).' ),
                'id' => 'body_image',
                'default' => '',
                'button_text' => __be('Upload/Select Image'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'How to fit background image' ),
                'desc' => __be( 'In Internet Explorer 8 and lower whatever you will choose(except <em>repeat</em>) it will look like "Just center"' ),
                'id' => 'body_image_fit',
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
                'id' => 'body_bg_color',
                'default' => '#f5f5f5',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Headings/Titles color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'headings_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Headings/Titles color hover' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'headings_color_hover',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Headings/Titles font weight' ),
                'desc' => '',
                'id' => 'headings_weight',
                'default' => 'bold',
                'options' => array(
                    'normal' => __be( 'Normal' ),
                    'bold' => __be( 'Bold' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Headings/Titles text transform' ),
                'desc' => '',
                'id' => 'headings_transform',
                'default' => 'uppercase',
                'options' => array(
                    'none' => __be( 'None' ),
                    'uppercase' => __be( 'Uppercase' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Links color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'links_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Links color hover' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'links_color_hover',
                'default' => '',
                'type' => 'color'
            ),


            array(
                'name' => __be( 'Customize Logo' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_logo_settings',
                'help' => '#!/appearance_menu_customize_logo'
            ),
            array(
                'name' => __be( 'Logo type' ),
                'desc' => '',
                'id' => 'logo_type',
                'default' => 'image',
                'options' => array(
                    'image' => __be( 'Image' ),
                    'text' => __be( 'Text' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( '[Image]Custom logo image' ),
                'desc' =>__be( 'Enter an URL or upload an image for logo. Paste the full URL (include <code>http://</code>).' ),
                'id' => 'logo_image',
                'default' => get_template_directory_uri().'/images/logo.png',
                'button_text' => __be('Upload/Select Image'),
                'media_button_text' => __be('Insert logo'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( '[Image]High DPI logo size in %' ),
                'desc' =>__be( 'It is used for high DPI devices(like Retina in iPad/iPhone). By shrinking image it looks sharp on these devices. Read more in documentation.' ),
                'id' => 'logo_shrink',
                'default' => '90%',
                'unit' => '%',
                'min' => 50,
                'max' => 100,
                'type' => 'slider'
            ),
            array(
                'name' => __be( '[Text]Text in your logo' ),
                'desc' => '',
                'id' => 'logo_text',
                'default' => 'Beach Please',
                'type' => 'input'
            ),
            array(
                'name' => __be( '[Text]Logo text color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'logo_color',
                'default' => '#000000',
                'type' => 'color'
            ),
            array(
                'name' => __be( '[Text]Logo font size' ),
                'desc' =>__be( 'Use slider to set proper font size.' ),
                'id' => 'logo_font_size',
                'default' => '26px',
                'unit' => 'px',
                'type' => 'slider'
            ),


            array(
                'name' => __be( 'Static pages' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_pages'
            ),
            array(
                'name' => __be( 'Page layout' ),
                'desc' => '',
                'id' => 'page_layout',
                'default' => 'static-left',
                'options' => array(
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
                'default' => 'content-light',
                'options' => array(
                    'content-light' => __be( 'Light' ),
                    'content-dark'  => __be( 'Dark' ),
                ),
                'type' => 'radio',
            ),


            array(
                'name' => __be( 'Customize header &amp footer' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_header_app'
            ),
            array(
                'name' => __be( 'Color scheme' ),
                'desc' => '',
                'id' => 'header_color_scheme',
                'default' => 'dark',
                'options' => array(
                    'light' => __be( 'Light' ),
                    'dark'  => __be( 'Dark' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Background color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'header_bg_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Font size' ),
                'desc' =>__be( 'Use slider to set proper font size.' ),
                'id' => 'header_font_size',
                'default' => '11px',
                'unit' => 'px',
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Font color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'header_font_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Links color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'header_link_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Links color hover' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'header_link_hover_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu icons' ),
                'desc' => __be( 'If you won\'t use menu icons then disable this option to make loading of theme slightly faster. You can see available icons at <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a>.' ),
                'id' => 'menu_icons',
                'default' => 'on',
                'options' => array(
                    'off'  => __be( 'Disable' ),
                    'on'   => __be( 'Enable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Menu background color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_bg_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu item description color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_desc_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu main separator color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_sep_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu main links font size' ),
                'desc' =>__be( 'Use slider to set proper font size.' ),
                'id' => 'menu_font_size',
                'default' => '14px',
                'unit' => 'px',
                'min' => 10,
                'max' => 20,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Menu main links color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu main links hover color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_hover_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu main links active page color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'menu_active_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Submenu links font size' ),
                'desc' =>__be( 'Use slider to set proper font size.' ),
                'id' => 'submenu_font_size',
                'default' => '13px',
                'unit' => 'px',
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Submenu hover background color' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'submenu_hover_bg_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'Menu font weight' ),
                'desc' => '',
                'id' => 'menu_weight',
                'default' => 'bold',
                'options' => array(
                    'normal' => __be( 'Normal' ),
                    'bold' => __be( 'Bold' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Menu text transform' ),
                'desc' => '',
                'id' => 'menu_transform',
                'default' => 'uppercase',
                'options' => array(
                    'none' => __be( 'None' ),
                    'uppercase' => __be( 'Uppercase' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Switch on/off header search form' ),
                'desc' => '',
                'id' => 'header_search',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),


            array(
                'name' => __be( 'Custom CSS' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_custom_css',
                'help' => '#!/appearance_menu_custom_css'
            ),
            array(
                'name' => __be( 'Custom CSS' ),
                'desc' => '',
                'id' => 'custom_css',
                'default' => '',
                'type' => 'textarea',
            ),
		);
		
		return $opt;
	}

    function apollo13_blog_options(){

        $opt = array(
            array(
                'name' => __be( 'Blog, Search &amp; Archives appearance' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_blog',
                'help' => '#!/blog_archives_menu'
            ),
            array(
                'name' => __be( 'Type of post excerpts' ),
                'desc' => __be( 'In Manual mode excerpts are used only if you add more tag (&lt;!--more--&gt;).<br />' .
                    'In Automatic mode if you won\'t provide more tag or explicit excerpt, content of post will be cut automatic.<br />' .
                    'This setting only concerns blog list, archive list, search results. <br />' .
                    'Read more in <strong>Adding New Posts/Pages -&gt; Posts list / blog</strong> section in documentation.' ),
                'id' => 'excerpt_type',
                'default' => 'auto',
                'options' => array(
                    'auto'      => __be( 'Automatic' ),
                    'manual'    => __be( 'Manual' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Brick width' ),
                'desc' =>__be( 'Use slider to set proper size. Width set here will be dynamically changed up to 120% to stretch bricks to fill space.' ),
                'id' => 'brick_width',
                'default' => '480px',
                'unit' => 'px',
                'min' => 200,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Brick margin' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'brick_margin',
                'default' => '30px',
                'unit' => 'px',
                'min' => 0,
                'max' => 100,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Blog sidebar' ),
                'desc' => __be( 'It affects look of main blog page.' ),
                'id' => 'blog_sidebar',
                'default' => 'off',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Archive sidebar' ),
                'desc' => __be( 'It affects look of search and archive pages.' ),
                'id' => 'archive_sidebar',
                'default' => 'off',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Background color under post list' ),
                'desc' =>__be( 'Use valid CSS <code>color</code> property values( <code>green, #33FF99, rgb(255,128,0)</code> ), or get your color with color picker tool. Left empty to use default theme value.' ),
                'id' => 'bg_color',
                'default' => '',
                'type' => 'color'
            ),
            array(
                'name' => __be( 'RSS icon' ),
                'desc' => '',
                'id' => 'info_bar_rss',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            /*array(
                'name' => __be( 'Search form' ),
                'desc' => '',
                'id' => 'info_bar_search',
                'default' => 'off',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),*/
            array(
                'name' => __be( 'Display post Media' ),
                'desc' => __be( 'You can set to not display post media(featured image/video/slider) inside of post brick.' ),
                'id' => 'blog_media',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Date' ),
                'desc' => '',
                'id' => 'blog_date',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Author' ),
                'desc' => '',
                'id' => 'blog_author',
                'default' => 'off',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Comments number' ),
                'desc' => '',
                'id' => 'blog_comments',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Tags' ),
                'desc' => '',
                'id' => 'blog_tags',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Categories' ),
                'desc' => '',
                'id' => 'blog_cats',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),

            //------------------------------------
            array(
                'name' => __be( 'Post appearance' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_post'
            ),
            array(
                'name' => __be( 'Post sidebar' ),
                'desc' => __be( 'It affects look of posts. You can change it in each post.' ),
                'id' => 'post_sidebar',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Display post Media' ),
                'desc' => __be( 'You can set to not display post media(featured image/video/slider) inside of post.' ),
                'id' => 'post_media',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Author info in post' ),
                'desc' => __be( 'Will show information about author below post content. Not displayed in blog post list.' ),
                'id' => 'author_info',
                'default' => 'off',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Date' ),
                'desc' => '',
                'id' => 'post_date',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Author' ),
                'desc' => '',
                'id' => 'post_author',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Comments number' ),
                'desc' => '',
                'id' => 'post_comments',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Tags' ),
                'desc' => '',
                'id' => 'post_tags',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Post meta: Categories' ),
                'desc' => '',
                'id' => 'post_cats',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
        );

        return $opt;
    }
	
	function apollo13_cpt_work_options(){
			
		$opt = array(
			array(
				'name' => __be( 'Works list main settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_works',
                'help' => '#!/works_menu'
			),
			array(
				'name' => __be( 'Work slug name' ),
				'desc' => __be( 'Don\'t change this if you don\'t have to. Remember that if you use nice permalinks(eg. <code>yoursite.com/page-about-me</code>, <code>yoursite.com/album/damn-empty/</code>) then <strong>NONE of your static pages</strong> should have same slug as this, or pagination will break and other problems may appear.' ),
				'id' => 'cpt_post_type_work',
				'default' => 'work',
				'type' => 'input',
			),
            array(
                'name' => __be( 'Comments' ),
                'desc' => '',
                'id' => 'comments',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Show subtitle in single view' ),
                'desc' => '',
                'id' => 'subtitle',
                'default' => 'off',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Show work genres in single view' ),
                'desc' => '',
                'id' => 'genres',
                'default' => 'on',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),


			array(
				'name' => __be( 'Works list page settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_works_list',
                'help' => '#!/works_menu'
			),
			array(
				'name' => __be( 'Works main page' ),
				'desc' => __be( 'Select page that is your Works list page. It will make working some features. If you setup Work list as your front page then you don\'t have to set any page here.' ),
				'id' => 'cpt_work_page',
				'default' => 0,
				'type' => 'wp_dropdown_pages',
			),
            array(
                'name' => __be( 'Show works titles' ),
                'desc' => '',
                'id' => 'show_titles',
                'default' => 'on',
                'type' => 'radio',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
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
                'name' => __be( 'Zoom on hover' ),
                'desc' => '',
                'id' => 'hover_zoom',
                'default' => 'on',
                'type' => 'radio',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
            ),
            array(
                'name' => __be( 'Cover width' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'brick_width',
                'default' => '420px',
                'unit' => 'px',
                'min' => 50,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Cover height' ),
                'desc' =>__be( 'Use slider to set proper size. If you want photo to not be cropped, set to 0.' ),
                'id' => 'brick_height',
                'default' => '320px',
                'unit' => 'px',
                'min' => 0,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Cover margin' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'brick_margin',
                'default' => '0',
                'unit' => 'px',
                'min' => 0,
                'max' => 100,
                'type' => 'slider'
            ),


            array(
                'name' => __be( 'Single work appearance(Scroller)' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_work_app_sc'
            ),
            array(
                'name' => __be( 'Scroller height' ),
                'desc' => __be( 'Use slider to set proper size.' ) . ' ' . __be( 'Global for all works.' ),
                'id' => 'scroller_height',
                'default' => '500px',
                'unit' => 'px',
                'min' => 100,
                'max' => 700,
                'type' => 'slider'
            ),


            array(
                'name' => __be( 'Single work appearance(Slider)' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_work_app_sl'
            ),
            array(
                'name' => __be( 'Slider height' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'slider_height',
                'default' => '700px',
                'unit' => 'px',
                'min' => 100,
                'max' => 700,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Autoplay' ),
                'desc' => __be( 'If autoplay is on, slider will run on page load. Global setting, but you can change this in each work.' ),
                'id' => 'autoplay',
                'default' => '1',
                'options' => array(
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Slide interval(ms)' ),
                'desc' =>__be( 'Time between slide transitions.' ) . ' ' . __be( 'Global for all works.' ),
                'id' => 'slide_interval',
                'default' => 7000,
                'unit' => '',
                'min' => 0,
                'max' => 15000,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Transition type' ),
                'desc' =>__be( 'Animation between slides.' ),
                'id' => 'transition_type',
                'default' => '2',
                'options' => array(
                    '0' => __be( 'None' ),
                    '1' => __be( 'Fade' ),
                    '2' => __be( 'Carousel' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Transition speed(ms)' ),
                'desc' =>__be( 'Speed of transition.' ) . ' ' . __be( 'Global for all works.' ),
                'id' => 'transition_time',
                'default' => 600,
                'unit' => '',
                'min' => 0,
                'max' => 10000,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Titles' ),
                'desc' =>__be( 'Show image/video titles.' ) . ' ' . __be( 'Global for all works.' ),
                'id' => 'titles',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'List of slides(buttons)' ),
                'desc' => __be( 'Global for all works.' ),
                'id' => 'list',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Random slide order' ),
                'desc' =>'',
                'id' => 'random',
                'default' => 'off',
                'options' => array(
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
		);
		
		return $opt;
	}

    function apollo13_cpt_gallery_options(){
        $opt = array(
            array(
                'name' => __be( 'Galleries list page settings' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_galleries_list',
                'help' => '#!/galleries_menu'
            ),
            array(
                'name' => __be( 'Show galleries titles' ),
                'desc' => '',
                'id' => 'show_titles',
                'default' => 'on',
                'type' => 'radio',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
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
                'name' => __be( 'Zoom on hover' ),
                'desc' => '',
                'id' => 'gl_hover_zoom',
                'default' => 'on',
                'type' => 'radio',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
            ),
            array(
                'name' => __be( 'Cover width' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'gl_brick_width',
                'default' => '420px',
                'unit' => 'px',
                'min' => 50,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Cover height' ),
                'desc' =>__be( 'Use slider to set proper size. If you want photo to not be cropped, set to 0.' ),
                'id' => 'gl_brick_height',
                'default' => '320px',
                'unit' => 'px',
                'min' => 0,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Cover margin' ),
                'desc' =>__be( 'Use slider to set proper size.' ),
                'id' => 'gl_brick_margin',
                'default' => '0',
                'unit' => 'px',
                'min' => 0,
                'max' => 100,
                'type' => 'slider'
            ),



            array(
                'name' => __be( 'Gallery appearance(Bricks theme)' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_gallery_bricks_app',
                'help' => '#!/galleries_menu'
            ),
            array(
                'name' => __be( 'Zoom on hover' ),
                'desc' => '',
                'id' => 'hover_zoom',
                'default' => 'on',
                'type' => 'radio',
                'options' => array(
                    'on'    => __be( 'On' ),
                    'off'   => __be( 'Off' ),
                ),
            ),
            array(
                'name' => __be( 'Brick width' ),
                'desc' =>__be( 'Use slider to set proper size.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'brick_width',
                'default' => '300px',
                'unit' => 'px',
                'min' => 50,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Brick height' ),
                'desc' =>__be( 'Use slider to set proper size. If you want photo to not be cropped, set to 0.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'brick_height',
                'default' => '220px',
                'unit' => 'px',
                'min' => 0,
                'max' => 600,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Brick margin' ),
                'desc' =>__be( 'Use slider to set proper size.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'brick_margin',
                'default' => '15px',
                'unit' => 'px',
                'min' => 0,
                'max' => 100,
                'type' => 'slider'
            ),


            array(
                'name' => __be( 'Gallery appearance(Slider theme)' ),
                'type' => 'fieldset',
                'default' => 0,
                'id' => 'fieldset_gallery_slider'
            ),
            array(
                'name' => __be( 'Autoplay' ),
                'desc' => __be( 'If autoplay is on, slider will run on page load. Global setting, but you can change this in each gallery.' ),
                'id' => 'autoplay',
                'default' => '1',
                'options' => array(
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Slide interval(ms)' ),
                'desc' =>__be( 'Time between slide transitions.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'slide_interval',
                'default' => 7000,
                'unit' => '',
                'min' => 0,
                'max' => 15000,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Transition type' ),
                'desc' =>__be( 'Animation between slides.' ),
                'id' => 'transition_type',
                'default' => '2',
                'options' => array(
                    '0' => __be( 'None' ),
                    '1' => __be( 'Fade' ),
                    '2' => __be( 'Carousel' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Transition speed(ms)' ),
                'desc' =>__be( 'Speed of transition.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'transition_time',
                'default' => 1000,
                'unit' => '',
                'min' => 0,
                'max' => 10000,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Titles and descriptions' ),
                'desc' =>__be( 'Show image/video titles and descriptions.' ) . ' ' . __be( 'Global for all galleries.' ),
                'id' => 'titles',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'List of slides(buttons).' ),
                'desc' => __be( 'Global for all galleries.' ),
                'id' => 'list',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Random slide order' ),
                'desc' => '',
                'id' => 'random',
                'default' => '0',
                'options' => array(
                    '1' => __be( 'Enable' ),
                    '0' => __be( 'Disable' ),
                ),
                'type' => 'radio',
            ),
		);

		return $opt;
	}

    function apollo13_contact_options(){
        $opt = array(
            array(
                'name' => __be( 'Google map drop area' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_contact_drop',
                'help' => '#!/contact_page_menu_google_map_drop_area'
            ),
            array(
                'name' => __be( 'Drop area' ),
                'desc' => __be( 'Paste here your google map link(see documentation for more info), and everything will be filled automatically.' ),
                'id' => 'contact_drop_area',
                'default' => '',
                'type' => 'textarea',
            ),


            array(
                'name' => __be( 'Map settings' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_contact',
                'help' => '#!/contact_page_menu_map_settings'
            ),
            array(
                'name' => __be( 'Background map' ),
                'desc' => '',
                'id' => 'contact_map',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Latitude, Longitude' ),
                'desc' => __be( 'Use format Latitude, Longitude (ex. 50.854817, 20.644566)' ),
                'id' => 'contact_ll',
                'default' => '',
                'placeholder' => '40.729405,-73.996139',
                'type' => 'input',
            ),
            array(
                'name' => __be( 'Map type' ),
                'desc' => '',
                'id' => 'contact_map_type',
                'default' => 'ROADMAP',
                'options' => array(
                    'ROADMAP' =>    __be( 'Road map' ),
                    'SATELLITE' =>  __be( 'Satellite' ),
                    'HYBRID' =>     __be( 'Hybrid' ),
                    'TERRAIN' =>    __be( 'Terrain' ),
                ),
                'type' => 'select',
            ),
            array(
                'name' => __be( 'Zoom level' ),
                'desc' =>__be( 'Use slider to set proper zoom level.' ),
                'id' => 'contact_zoom',
                'default' => '15',
                'unit' => '',
                'min' => 1,
                'max' => 19,
                'type' => 'slider'
            ),
            array(
                'name' => __be( 'Marker title' ),
                'desc' => __be( 'Will show while hovering mouse cursor over marker' ),
                'id' => 'contact_title',
                'default' => 'Extra contact info!',
                'type' => 'input',
            ),
            array(
                'name' => __be( 'Info window content' ),
                'desc' => __be( 'Will show up after clicking in marker' ),
                'id' => 'contact_content',
                'default' => '<strong>Beach Please Inc..</strong><br />
Rua Ernesto de Paula Santos, 1172, 6º andar,
Boa Viagem, Recife, Pernambuco, Brasil',
                'type' => 'textarea',
            ),
        );

        return $opt;
    }
	
	function apollo13_social_options(){
		$socials = array(
			'500px' => array(
                'name' => '500px',
                'value' => '',
				'pos'  => 0
            ),
			'aim' => array(
                'name' => 'Aim',
                'value' => '',
				'pos'  => 0
            ),
			'behance' => array(
                'name' => 'Behance',
                'value' => '',
				'pos'  => 0
            ),
			'blogger' => array(
                'name' => 'Blogger',
                'value' => '#',
				'pos'  => 0
            ),
			'delicious' => array(
                'name' => 'Delicious',
                'value' => '',
				'pos'  => 0
            ),
			'deviantart' => array(
                'name' => 'Deviantart',
                'value' => '',
				'pos'  => 0
            ),
			'digg' => array(
                'name' => 'Digg',
                'value' => '',
				'pos'  => 0
            ),
			'dribbble' => array(
                'name' => 'Dribbble',
                'value' => '',
				'pos'  => 0
            ),
			'evernote' => array(
                'name' => 'Evernote',
                'value' => '',
				'pos'  => 0
            ),
			'facebook' => array(
                'name' => 'Facebook',
                'value' => '#',
				'pos'  => 0
            ),
			'flickr' => array(
                'name' => 'Flickr',
                'value' => '',
				'pos'  => 0
            ),
			'forrst' => array(
                'name' => 'Forrst',
                'value' => '',
				'pos'  => 0
            ),
			'foursquare' => array(
                'name' => 'Foursquare',
                'value' => '',
				'pos'  => 0
            ),
			'github' => array(
                'name' => 'Github',
                'value' => '',
				'pos'  => 0
            ),
			'googleplus' => array(
                'name' => 'Google Plus',
                'value' => '',
				'pos'  => 0
            ),
			'instagram' => array(
                'name' => 'Instagram',
                'value' => '',
				'pos'  => 0
            ),
			'lastfm' => array(
                'name' => 'Lastfm',
                'value' => '',
				'pos'  => 0
            ),
			'linkedin' => array(
                'name' => 'Linkedin',
                'value' => '',
				'pos'  => 0
            ),
			'paypal' => array(
                'name' => 'Paypal',
                'value' => '',
				'pos'  => 0
            ),
			'pinterest' => array(
                'name' => 'Pinterest',
                'value' => '',
				'pos'  => 0
            ),
			'quora' => array(
                'name' => 'Quora',
                'value' => '',
				'pos'  => 0
            ),
			'rss' => array(
                'name' => 'RSS',
                'value' => '',
				'pos'  => 0
            ),
			'sharethis' => array(
                'name' => 'Sharethis',
                'value' => '',
				'pos'  => 0
            ),
			'skype' => array(
                'name' => 'Skype',
                'value' => '',
				'pos'  => 0
            ),
			'stumbleupon' => array(
                'name' => 'Stumbleupon',
                'value' => '#',
				'pos'  => 0
            ),
			'tumblr' => array(
                'name' => 'Tumblr',
                'value' => '',
				'pos'  => 0
            ),
			'twitter' => array(
                'name' => 'Twitter',
                'value' => '',
                'pos'  => 0
            ),
			'vimeo' => array(
                'name' => 'Vimeo',
                'value' => '',
                'pos'  => 0
            ),
			'wordpress' => array(
                'name' => 'Wordpress',
                'value' => '',
                'pos'  => 0
            ),
			'yahoo' => array(
                'name' => 'Yahoo',
                'value' => '',
                'pos'  => 0
            ),
			'youtube' => array(
                'name' => 'Youtube',
                'value' => '',
                'pos'  => 0
            ),
		);
	
		$opt = array(
			array(
				'name' => __be( 'Social settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_social',
                'help' => '#!/social_menu'
			),
//			array(
//				'name' => __be( 'Number of visible icons:' ),
//				'desc' => __be( 'Set to 0 to disable social icons in header. Setting to "4" is recommended' ),
//				'id' => 'social_number_of_visible',
//				'default' => '3',
//				'type' => 'input',
//			),
			array(
				'name' => __be( 'Icons set' ),
				'desc' => '',
				'id' => 'social-icons-set',
				'default' => 'd_white',
				'options' => array(
					'white' => __be( 'White circle icon set' ),
					'black' => __be( 'Black circle icon set' ),
					'color' => __be( 'Color circle icon set' ),
					'd_white' => __be( 'White diamond icon set' ),
					'd_black' => __be( 'Black diamond icon set' ),
					'd_color' => __be( 'Color diamond icon set' ),
				),
				'type' => 'select',
			),


			array(
				'name' => __be( 'Social services' ),
				'type' => 'fieldset',
                'default' => 1,
                'id'   => 'sortable-socials'
			),
			array(
				'name' => __be( 'Social services' ),
				'desc' => __be( 'Use <code>http://</code> in your social links' ),
				'id' => 'social_services',
				'default' => '',
				'type' => 'social',
				'options' => $socials
			),
		);
		
		return $opt;
	}

//off in BP
    function apollo13_music_options(){

        $opt = array(
            array(
                'name' => __be( 'Music settings' ),
                'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_music',
                'help' => '#!/music_menu'
            ),
            array(
                'name' => __be( 'Header background music player' ),
                'desc' => __be( 'Switch on/off music player in header area.' ),
                'id' => 'music_player',
                'default' => 'on',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
            array(
                'name' => __be( 'Music file in MP3 format' ),
                'desc' =>__be( 'Enter an URL or upload a music file. Paste the full URL (include <code>http://</code>).' ),
                'id' => 'music_mp3',
                'default' => 'http://themes.apollo13.eu/hypershot/wp-content/uploads/2012/11/adg3com_bustedchump.mp3',
                'button_text' => __be('Upload music file'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'Music file in OGG format' ),
                'desc' =>__be( 'Enter an URL or upload a music file. Paste the full URL (include <code>http://</code>).' ),
                'id' => 'music_ogg',
                'default' => 'http://themes.apollo13.eu/hypershot/wp-content/uploads/2012/11/adg3com_bustedchump.ogg',
                'button_text' => __be('Upload music file'),
                'type' => 'upload'
            ),
            array(
                'name' => __be( 'Autoplay' ),
                'desc' => __be( 'If autoplay is on, player will try to start playing music on page load. Global setting, but you can change this in each page/post settings.' ),
                'id' => 'music_autoplay',
                'default' => 'off',
                'options' => array(
                    'on' => __be( 'On' ),
                    'off' => __be( 'Off' ),
                ),
                'type' => 'radio',
            ),
        );

        return $opt;
    }

	function apollo13_advance_options(){
			
		$opt = array(
			array(
				'name' => __be( 'Miscellaneous settings' ),
				'type' => 'fieldset',
                'default' => 1,
                'id' => 'fieldset_misc',
                'help' => '#!/advance_menu'
			),
			array(
				'name' => __be( 'Comments validation' ),
				'desc' => __be( 'If you wish to use some plugin for validation in <strong>comments form</strong> then you should turn off build in theme validation' ),
				'id' => 'apollo_validation',
				'default' => 'on',
				'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
				),
				'type' => 'radio',
			),
			array(
				'name' => __be( 'Theme lightbox' ),
				'desc' => __be( 'If you wish to use some other plugin/script for images and items switch it off.' ),
				'id' => 'apollo_lightbox',
				'default' => 'on',
				'options' => array(
                    'on' => __be( 'Enable' ),
                    'off' => __be( 'Disable' ),
				),
				'type' => 'radio',
			),
		);
		
		return $opt;
	}