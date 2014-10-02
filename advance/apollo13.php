<?php
class Apollo13 {

	//current theme settings
	private $theme_options = array();
	private $parents_of_meta = array();
	//all possible theme settings
	public $all_theme_options = array();

	function start() {
		/**
         * Define bunch of helpful paths
         */
		define('TPL_SLUG', 'beach_apollo');
		define('TPL_NAME', 'Beach Please');
		define('TPL_ALT_NAME', 'BP Apollo13'); //alternative name for visuals
		define('TPL_URI', get_template_directory_uri());
		define('TPL_DIR', get_template_directory());
		define('TPL_GFX', TPL_URI . '/images');
		define('TPL_CSS', TPL_URI . '/css');
		define('TPL_CSS_DIR', TPL_DIR . '/css');
		define('TPL_JS', TPL_URI . '/js');
		define('TPL_ADV', TPL_URI . '/advance');
		define('TPL_ADV_DIR', TPL_DIR . '/advance');
		define('USER_GENERATED', TPL_URI . '/user');
		define('USER_GENERATED_DIR', TPL_DIR . '/user');
		define('TPL_SHORTCODES_DIR', TPL_ADV_DIR . '/shortcodes');
		define('CUSTOM_POST_TYPE_WORK', 'work');
//		define('CUSTOM_POST_TYPE_WORK_SLUG', 'work'); //defined a bit lower
		define('CPT_WORK_TAXONOMY', 'genre');
		define('CUSTOM_POST_TYPE_GALLERY', 'gallery');
		define('CUSTOM_POST_TYPE_GALLERY_SLUG', 'gallery');
		define('CPT_GALLERY_TAXONOMY', 'kind');
		define('VALIDATION_CLASS', 'apollo_validation_on');
		define('DOCS_LINK', TPL_URI . '/docs/index.html');

        //check for them version(we try to get parent theme version)
        $theme_data = wp_get_theme();
        $have_parent = $theme_data->parent();
        if($have_parent)
            $t_ver = $theme_data->parent()->Version;
        else
            $t_ver = $theme_data->Version;
		define('THEME_VER', $t_ver);

		/**
         * GET THEME OPTIONS
         */
		$this->set_options();
        //if some settings have been changed
		if ( isset( $_POST[ 'theme_updated' ] ) ) {
			$options_name = str_replace( 'apollo13_', '', $_GET['page']);
			$this->update_options( $options_name );
		}
        //on fresh install/update
        if(!file_exists($this->user_css_name())){
            $this->generate_user_css();
        }

        //used to compere with global options
        $this->collect_meta_parents();

        //defined Theme constants after getting theme options
		define('CUSTOM_POST_TYPE_WORK_SLUG', $this->theme_options[ 'cpt_work' ][ 'cpt_post_type_work' ]);


		// SET LANGUAGE
		add_action( 'init' , array( &$this , 'set_lang') );
		
		// ADMIN PART
		if ( is_admin() ) {
            require_once (TPL_ADV_DIR . '/admin/admin.php');
            require_once (TPL_ADV_DIR . '/admin/admin_ajax.php');
            require_once (TPL_ADV_DIR . '/admin/metaboxes.php');
            require_once (TPL_ADV_DIR . '/admin/multiupload.php');
            require_once (TPL_ADV_DIR . '/admin/print_options.php');
		}
		
        // AFTER SETUP(supports for thumbnails, menus, RSS etc.)
		add_action( 'after_setup_theme', array( &$this, 'setup' ) );

        // ADD WORKS SUPPORT
        require_once (TPL_ADV_DIR . '/cpt_work.php');

        // ADD GALLERIES SUPPORT
        require_once (TPL_ADV_DIR . '/cpt_gallery.php');

        // ADD SIDEBARS & WIDGETS
        require_once (TPL_ADV_DIR . '/widgets.php');

        // THEME SCRIPTS & STYLES
        require_once (TPL_ADV_DIR . '/head_scripts_styles.php');

        //ADD REVSLIDER
        require_once (TPL_ADV_DIR . '/plugins/revslider/revslider.php');

        // ADD SHORTCODES
        require_once (TPL_SHORTCODES_DIR . '/typography.php');
        require_once (TPL_SHORTCODES_DIR . '/columns.php');
        require_once (TPL_SHORTCODES_DIR . '/toggles.php');
        require_once (TPL_SHORTCODES_DIR . '/gallery.php');
//        require_once (TPL_SHORTCODES_DIR . '/embed.php');

		// UTILITIES
        require_once (TPL_ADV_DIR . '/utilities.php');


        // FOR DEBUGGING
//		print_r( $this->theme_options );
//		print_r( $this->all_theme_options );
//		print_r( $this->parents_of_meta );
	}
	
	/**
     * Languages support
     */
	function set_lang() {
        load_theme_textdomain( TPL_SLUG , TPL_DIR . '/languages' );

        $locale = get_locale();
        $locale_file = TPL_DIR ."/languages/$locale.php";
        if ( is_readable($locale_file) )
            require_once ($locale_file);

        // For admin translation
        if ( is_admin() ) {
            load_theme_textdomain( TPL_SLUG.'_admin' , TPL_DIR . '/languages/admin' );
        }
	}

	function setup() {
        global $content_width;
        //content width
        if ( ! isset( $content_width ) ) $content_width = 560;

        //Featured image support
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'sidebar-size', 100, 75, true );
        add_image_size( 'apollo-post-thumb', 600, 0, true); //(cropped)
        add_image_size( 'apollo-post-thumb-big', 960, 0, true); //(cropped)

        //work cover
        $temp_w = $this->get_option( 'cpt_work', 'brick_width' );
        $temp_h = $this->get_option( 'cpt_work', 'brick_height' );
        add_image_size( 'work-cover', intval($temp_w*1.2), intval($temp_h*1.2), true ); /* better quality for stretched photos*/

        //work scroller image
        $temp_h = $this->get_option( 'cpt_work', 'scroller_height' );
        add_image_size( 'work-image', 0, $temp_h, true );

        //work slider image
        $temp_h = $this->get_option( 'cpt_work', 'slider_height' );
        add_image_size( 'work-slider-image', 0, $temp_h, true );


        //Gallery cover
        $temp_w = $this->get_option( 'cpt_gallery', 'gl_brick_width' );
        $temp_h = $this->get_option( 'cpt_gallery', 'gl_brick_height' );
        add_image_size( 'gallery-cover', intval($temp_w*1.2), intval($temp_h*1.2), true ); /* better quality for stretched photos*/

        //Gallery bricks
        $temp_w = $this->get_option( 'cpt_gallery', 'brick_width' );
        $temp_h = $this->get_option( 'cpt_gallery', 'brick_height' );
//        add_image_size( 'gallery-bricks', $temp_w, $temp_h, true );
        add_image_size( 'gallery-bricks', intval($temp_w*1.2), intval($temp_h*1.2), true ); /* better quality for stretched photos*/


		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// Add naviagation menu ability. 
		add_theme_support('menus');

        //add POST FORMATS
        add_theme_support('post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));
		
		register_nav_menus(array(
			'header-menu' => __be('Site Navigation' ),
		));

        $this->check_for_warnings();
	}

    function check_for_warnings(){
        //Notice if dir for user settings is no writable
        if(!is_writeable(USER_GENERATED_DIR)){
            add_action( 'admin_notices', 'not_writable_user_dir_error_notice' );
        }

        //Notice if cpt slug is taken
        //WORKS
        $r = new WP_Query(array('post_type' => array( 'post', 'page'), 'name' => CUSTOM_POST_TYPE_WORK_SLUG));
        if ($r->have_posts()){
            add_action( 'admin_notices', 'taken_work_slug_error_notice' );
        }
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        //GALLERIES
        $r = new WP_Query(array('post_type' => array( 'post', 'page'), 'name' => CUSTOM_POST_TYPE_GALLERY_SLUG));
        if ($r->have_posts()){
            add_action( 'admin_notices', 'taken_gallery_slug_error_notice' );
        }
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        //UPDATE INFO
        require_once (TPL_ADV_DIR . '/inc/theme-update-checker.php');
        $update_checker = new ThemeUpdateChecker(
            TPL_SLUG,
            'http://apollo13.eu/themes_update/beach_please/info.json'
        );

        function not_writable_user_dir_error_notice(){
            echo '<div class="error"><p>';
            printf( __be('Warning - directory %s is not writable.'), USER_GENERATED_DIR);
            echo '</p></div>';
        }

        function taken_work_slug_error_notice(){
            echo '<div class="error"><p>';
            printf( __be('Warning - slug for Works is taken by page or post! It may cause problems with displaying albums. Edit slug of <a href="%s">this post</a> to make sure everything works good.'), site_url('/' . CUSTOM_POST_TYPE_WORK_SLUG) );
            echo '</p></div>';
        }

        function taken_gallery_slug_error_notice(){
            echo '<div class="error"><p>';
            printf( __be('Warning - slug for Galleries is taken by page or post! It may cause problems with displaying albums. Edit slug of <a href="%s">this post</a> to make sure everything works good.'), site_url('/' . CUSTOM_POST_TYPE_GALLERY_SLUG) );
            echo '</p></div>';
        }

        function update_a13_theme_notice(){
            $state = get_option('external_theme_updates-'.TPL_SLUG);
            $update = $state->update;

            if ( is_string($state->update) ) {
                $update = ThemeUpdate::fromJson($state->update);
            }
            echo '<div class="updated"><p>';

            printf( __be( 'There is new version <em>%1$s</em> of <strong>%2$s theme</strong> available. Please go to <a href="%3$s" target="_blank">ThemeForest</a> and get new version of it. Next follow <a href="%4$s" target="_blank">update instructions from documentation</a>. Good luck ;-) <br /><a href="%5$s" target="_blank">Check changes in Change log</a>'),
                $update->version,
                TPL_NAME,
                $update->details_url,
                DOCS_LINK.'#!/installation_update_update_theme',
                ''
            );
            echo '</p></div>';
        }
    }

	private function set_options(){
		require_once (TPL_ADV_DIR . '/options.php');
		
		$option_func = array(
			'settings',
			'appearance',
			'blog',
			'fonts',
			'cpt_work',
			'cpt_gallery',
			'contact',
			'social',
			'advance',
		);
		
		foreach($option_func as $function){
			$function_to_call = 'apollo13_' . $function . '_options';
			
			//firstly collect all default setting
			foreach( $function_to_call() as $option) {
				//get current settings
				if (isset($option['default'])) {
					$this->theme_options[ $function ][ $option['id'] ] = $option['default'];
				}
				//get possible settings
				if (isset($option['options'])) {
					$this->all_theme_options[ $function ][ $option['id'] ] = $option['options'];
				}
			}

            //get current settings saved in database
			$get_opt = get_option( TPL_SLUG . '_' . $function );
			
			//secondly overwrite with current settings
			if( ! empty( $get_opt ) && is_array( $get_opt ) ){
				$this->theme_options[ $function ] = array_merge( (array) $this->theme_options[ $function ] , $get_opt );
			}
			
			//clear data
			foreach( $this->theme_options[ $function ] as $key => $value ) {
				if( ! is_array( $value ))
					$this->theme_options[ $function ][ $key ] = stripslashes( $value );
			}
		}
	}
	
	public function get_option( $index1, $index2 ){
		return $this->theme_options[ $index1 ][ $index2 ];
	}

    private function collect_meta_parents(){
        require_once (TPL_ADV_DIR . '/meta.php');

        $option_func = array(
            'post',
            'page',
            'cpt_work',
            'cpt_gallery',
            'cpt_images'
        );

        foreach($option_func as $function){
            $function_to_call = 'apollo13_metaboxes_' . $function;

            foreach( $function_to_call() as $meta) {
                if (isset($meta['global_value'])) {
                    $this->parents_of_meta[ $function ][ $meta['id'] ]['global_value'] = $meta['global_value'];
                }
                if (isset($meta['parent_option'])) {
                    $this->parents_of_meta[ $function ][ $meta['id'] ]['parent_option'] = $meta['parent_option'];
                }
                if (isset($option['parent_meta'])) {
                    $this->all_theme_options[ $function ][ $meta['id'] ]['parent_meta'] = $meta['parent_meta'];
                }
            }
        }
    }

    /*
     * Save setted options
     */
	function update_options( $options_name ){
		$copy_to_compare = $this->theme_options[ $options_name ];
		
		foreach( $this->theme_options[ $options_name ] as $option => $value ){
			if ( isset( $_POST[ $option ] )) {
				
				//if option is social options
                if( $option == 'social_services'){
                    $collector = array();
                    foreach( $this->all_theme_options[ $options_name ][ $option ] as $id => $val ){
                        if ( isset( $_POST[ $id ] )) {
                            $collector[$id]['value'] = $_POST[ $id ];
                        }
                        if ( isset( $_POST[ $id .'_pos'  ] )) {
                            $collector[$id]['pos'] = $_POST[ $id .'_pos' ];
                        }
                    }
                    //save
                    $this->theme_options[ $options_name ][ $option ] = $collector;
                }
				//if option is array of options
				elseif( $_POST[ $option ] == '_array'){
					$collector = array();
					foreach( $this->all_theme_options[ $options_name ][ $option ] as $id => $val ){
						if ( isset( $_POST[ $id ] )) {
							$collector[$id] = $_POST[ $id ];  
						}
					}
					//save
					$this->theme_options[ $options_name ][ $option ] = $collector;
				}
				
				//if single option
				else
				$this->theme_options[ $options_name ][ $option ] = $_POST[ $option ];
			}
		}
        //if there were something changed save options to database
		if ( $this->theme_options[ $options_name ] != $copy_to_compare ) {
			update_option(TPL_SLUG . '_' . $options_name, $this->theme_options[ $options_name ] );
			$this->generate_user_css();
            //for refresh of slugs rules
			define('APOLLO13_SETTINGS_CHANGED', true);
		}
	}

    /*
     * Get name of user CSS file in case of multisite
     */
    function user_css_name( $public = false ){
        $name = ($public ? USER_GENERATED : USER_GENERATED_DIR) . '/user'; /* user.css - comment just for easier searching */
        if(is_multisite()){
            //add blog id to file
            global $wpdb;
            $name .= '_'.$wpdb->blogid;
        }

        return $name.'.css';
    }

    /*
     * Make user CSS file from options about theme layout
     */
    function generate_user_css(){
        if ( is_writable( USER_GENERATED_DIR ) ) {
            $file = $this->user_css_name();
            $fh = @fopen( $file, 'w+' );
            $css = include( TPL_ADV_DIR . '/user-css.php' );
            if ( $fh ) {
                fwrite( $fh, $css, strlen( $css ) );
            }
        }
    }

    /*
    * Retrieves meta with checking for parent settings, and global settings
    */
    function get_meta($field, $post_id = false){
        $meta = '';
        $id = $post_id;
        $family = '';

        if(!is_404()){
            if(!$id ){
                $id = get_the_ID();
            }

            $meta = trim(get_post_meta($id, $field, true));
        }

        //get family to check for parent option
        if(get_post_type( $id ) == CUSTOM_POST_TYPE_WORK ) $family = 'cpt_work';
        elseif(get_post_type( $id ) == CUSTOM_POST_TYPE_GALLERY ) $family = 'cpt_gallery';
        elseif(is_page($id) || is_home($id)) $family = 'page';
        elseif(is_single($id)) $family = 'post';

        $field = substr($field, 1); //remove '_'

        //if has any parent
        if(isset($this->parents_of_meta[$family][$field])){
            $parent = $this->parents_of_meta[$family][$field];

            //meta points for global setting
            if(isset($parent['global_value']) && ($meta == $parent['global_value'] || strlen($meta) == 0 )){
                if(isset($parent['parent_meta'])){
                    //not implemented
                }
                if(isset($parent['parent_option'])){
                    $po = $parent['parent_option'];
                    $meta = $this->get_option($po[0], $po[1]);
                }
            }
        }

        return $meta;
    }
    
    function page_type_debug(){
        echo 
              "<br />\n" . 'is front page ' . is_front_page()
            . "<br />\n" . 'is home '       . is_home()
            . "<br />\n" . 'is page '       . is_page()
            . "<br />\n" . 'is single '     . is_single()
            . "<br />\n" . 'is singular '   . is_singular()
            . "<br />\n" . 'is 404 '        . is_404()
            . "<br />\n" . 'is archive '    . is_archive()
            . "<br />\n" . 'is category '   . is_category()
            . "<br />\n" . 'is attachment ' . is_attachment()
            . "<br />\n" . 'is search '     . is_search()
            . "<br />\n";
    }
}
