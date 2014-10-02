<?php
/* Generates user css based on settings in admin panel */

function apollo13_make_css_rule($property, $value, $format = false){
    if ( $value !== '' &&  $value !== 'default' ){
        //make fallback for rgba colors by providing rgb color
        if(strpos($property,'color') !== false && strpos($value,'rgba') !== false){
            //break rgba to numbers
            $chunks = break_rgba($value);
            $fallback_color = "rgb($chunks[1], $chunks[2], $chunks[3])";

            return
                $property . ': ' . $fallback_color . "; " .
                $property . ': ' . $value . ';';
        }

        //format for some properties
        if( $format !== false ){
            return $property . ': ' . sprintf($format, $value) . ';';
        }

        return $property . ': ' . $value . ";";
    }
    else{
        return '';
    }
}

/* only for background color
 * it gives RGBA possibility to IE 8
*/
function apollo13_ie_color($property, $value){
    if(strpos($value,'rgba') !== false){
        //break rgba to numbers
        $chunks = break_rgba($value);

        $ie_color = rgba2hex($chunks[1], $chunks[2], $chunks[3], $chunks[4]);

        $css =
            'background-color: transparent; ' .
                'filter:progid:DXImageTransform.Microsoft.gradient(startColorStr='.$ie_color.',endColorStr='.$ie_color.'); ' .
                'zoom: 1;';

        return $css;
    }
    else{
        return apollo13_make_css_rule($property, $value);
    }
}

function rgba2hex( $r, $g, $b, $a ){
    return sprintf( '#%02s%02s%02s%02s', dechex( 255 * $a ), dechex( $r ), dechex( $g ), dechex( $b ) );
}

function break_rgba( $rgba ){
    $chunks = array();
    preg_match("/\(\s*(\d+),\s*(\d+),\s*(\d+),\s*(\d+\.?\d*)\s*\)/", $rgba, $chunks);
    return $chunks;
}


/*
 * body part
 */
$headings_color             = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'headings_color' ]);
$headings_color_hover       = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'headings_color_hover' ]);
$headings_weight            = apollo13_make_css_rule( 'font-weight', $this->theme_options[ 'appearance' ][ 'headings_weight' ]);
$headings_transform         = apollo13_make_css_rule( 'text-transform', $this->theme_options[ 'appearance' ][ 'headings_transform' ]);
$links_color                = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'links_color' ]);
$links_color_hover          = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'links_color_hover' ]);
//$buttons_bg_color           = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'links_color' ]);
//$buttons_bg_color_ie        = apollo13_ie_color     ( 'background-color', $this->theme_options[ 'appearance' ][ 'links_color' ]);
//$buttons_bg_color_hover     = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'links_color_hover' ]);
//$buttons_bg_color_hover_ie  = apollo13_ie_color     ( 'background-color', $this->theme_options[ 'appearance' ][ 'links_color_hover' ]);
/*input[type=\"submit\"]{
    $buttons_bg_color
}*/

/*
 *  header part
 */
$header_scheme          = $this->theme_options[ 'appearance' ][ 'header_color_scheme' ];
$header_font_size       = apollo13_make_css_rule( 'font-size', $this->theme_options[ 'appearance' ][ 'header_font_size' ]);
$header_font_color      = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'header_font_color' ]);
$header_link_color      = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'header_link_color' ]);
$header_link_hover_color= apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'header_link_hover_color' ]);
$header_bg_color        = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'header_bg_color' ]);
//$header_bg_color_ie     = apollo13_ie_color     ( 'background-color', $this->theme_options[ 'appearance' ][ 'header_bg_color' ]);
//.lt-ie9 #header{
//    $header_bg_color_ie
//}
$logo_color             = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'logo_color' ]);
$logo_font_size         = apollo13_make_css_rule( 'font-size', $this->theme_options[ 'appearance' ][ 'logo_font_size' ]);
$logo_shrink            = apollo13_make_css_rule( 'max-width', $this->theme_options[ 'appearance' ][ 'logo_shrink' ]);
$menu_icons             = $this->theme_options[ 'appearance' ][ 'menu_icons' ];
$menu_bg_color          = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'menu_bg_color' ]);
//$menu_bg_color_ie       = apollo13_ie_color     ( 'background-color', $this->theme_options[ 'appearance' ][ 'menu_bg_color' ]);
//.lt-ie9 .top-menu li{
//    $menu_bg_color_ie
//}
$submenu_hover_bg_color = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'submenu_hover_bg_color' ]);
//$submenu_hover_bg_color_ie = apollo13_ie_color     ( 'background-color', $this->theme_options[ 'appearance' ][ 'submenu_hover_bg_color' ]);
//.lt-ie9 .top-menu li li:hover{
//    $submenu_hover_bg_color_ie
//}
$menu_sep_color         = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'appearance' ][ 'menu_sep_color' ]);
$menu_weight            = apollo13_make_css_rule( 'font-weight', $this->theme_options[ 'appearance' ][ 'menu_weight' ]);
$menu_transform         = apollo13_make_css_rule( 'text-transform', $this->theme_options[ 'appearance' ][ 'menu_transform' ]);
$menu_font_size         = apollo13_make_css_rule( 'font-size', $this->theme_options[ 'appearance' ][ 'menu_font_size' ]);
$menu_color             = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'menu_color' ]);
$menu_hover_color       = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'menu_hover_color' ]);
$menu_active_color      = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'menu_active_color' ]);
$submenu_font_size      = apollo13_make_css_rule( 'font-size', $this->theme_options[ 'appearance' ][ 'submenu_font_size' ]);
$menu_desc_color        = apollo13_make_css_rule( 'color', $this->theme_options[ 'appearance' ][ 'menu_desc_color' ]);



/*
 *  blog
 */
$blog_brick_width       = apollo13_make_css_rule( 'width', $this->theme_options[ 'blog' ][ 'brick_width' ]);
$margin = $this->theme_options[ 'blog' ][ 'brick_margin' ];
$margin_half = ((int)$margin)/2;
$blog_brick_margin_b = apollo13_make_css_rule( 'margin-bottom', $margin);
$blog_brick_margin_r = apollo13_make_css_rule( 'margin-right', $margin_half, '%fpx' );
$blog_brick_margin_l = apollo13_make_css_rule( 'margin-left', $margin_half, '%fpx' );
$blog_brick_padd_t   = apollo13_make_css_rule( 'padding-top', $margin);
$blog_brick_padd_r   = apollo13_make_css_rule( 'padding-right', $margin_half, '%fpx' );
$blog_brick_padd_l   = apollo13_make_css_rule( 'padding-left', $margin_half, '%fpx' );
$blog_bg_color       = apollo13_make_css_rule( 'background-color', $this->theme_options[ 'blog' ][ 'bg_color' ]);



/*
 *  Galleries list
 */
$galleries_brick_width    = apollo13_make_css_rule( 'width', $this->theme_options[ 'cpt_gallery' ][ 'gl_brick_width' ]);
$temp = $this->theme_options[ 'cpt_gallery' ][ 'gl_brick_height' ];
// if 0 then height if fluid
if($temp === '0px' || $temp === '0'){
    $galleries_brick_height = 'height: auto;';
    $galleries_brick_img_height = '';
}
else{
    $galleries_brick_height = apollo13_make_css_rule( 'height', $temp);
    $galleries_brick_img_height = $galleries_brick_height;
}

$margin = $this->theme_options[ 'cpt_gallery' ][ 'gl_brick_margin' ];
$margin_half = ((int)$margin)/2;
$galleries_brick_margin_b = apollo13_make_css_rule( 'margin-bottom', $margin);
$galleries_brick_margin_r = apollo13_make_css_rule( 'margin-right', $margin_half, '%fpx' );
$galleries_brick_margin_l = apollo13_make_css_rule( 'margin-left', $margin_half, '%fpx' );
$galleries_brick_padd_t   = apollo13_make_css_rule( 'padding-top', $margin);
$galleries_brick_padd_r   = apollo13_make_css_rule( 'padding-right', $margin_half, '%fpx' );
$galleries_brick_padd_l   = apollo13_make_css_rule( 'padding-left', $margin_half, '%fpx' );
$galleries_titles         = ($this->theme_options[ 'cpt_gallery' ][ 'show_titles' ] == 'off')? 'display: none !important;' : '';


/*
 *  Gallery
 */
$gallery_brick_width    = apollo13_make_css_rule( 'width', $this->theme_options[ 'cpt_gallery' ][ 'brick_width' ]);
$temp = $this->theme_options[ 'cpt_gallery' ][ 'brick_height' ];
// if 0 then height if fluid
if($temp === '0px' || $temp === '0'){
    $gallery_brick_height = 'height: auto;';
    $gallery_brick_img_height = '';
}
else{
    $gallery_brick_height = apollo13_make_css_rule( 'height', $temp);
    $gallery_brick_img_height = $gallery_brick_height;
}

$margin = $this->theme_options[ 'cpt_gallery' ][ 'brick_margin' ];
$margin_half = ((int)$margin)/2;
$gallery_brick_margin_b = apollo13_make_css_rule( 'margin-bottom', $margin);
$gallery_brick_margin_r = apollo13_make_css_rule( 'margin-right', $margin_half, '%fpx' );
$gallery_brick_margin_l = apollo13_make_css_rule( 'margin-left', $margin_half, '%fpx' );
$gallery_brick_padd_t   = apollo13_make_css_rule( 'padding-top', $margin);
$gallery_brick_padd_r   = apollo13_make_css_rule( 'padding-right', $margin_half, '%fpx' );
$gallery_brick_padd_l   = apollo13_make_css_rule( 'padding-left', $margin_half, '%fpx' );
$gallery_caption        = ($this->theme_options[ 'cpt_gallery' ][ 'titles' ] == 'off')? 'display: none !important;' : '';
$gallery_slide_list     = ($this->theme_options[ 'cpt_gallery' ][ 'list' ] == 'off')? 'display: none !important;' : '';



/*
 *  Works list
 */
$works_brick_width    = apollo13_make_css_rule( 'width', $this->theme_options[ 'cpt_work' ][ 'brick_width' ]);
$temp = $this->theme_options[ 'cpt_work' ][ 'brick_height' ];
// if 0 then height if fluid
if($temp === '0px' || $temp === '0'){
    $works_brick_height = 'height: auto;';
    $works_brick_img_height = '';
}
else{
    $works_brick_height = apollo13_make_css_rule( 'height', $temp);
    $works_brick_img_height = $works_brick_height;
}

$margin = $this->theme_options[ 'cpt_work' ][ 'brick_margin' ];
$margin_half = ((int)$margin)/2;
$works_brick_margin_b = apollo13_make_css_rule( 'margin-bottom', $margin);
$works_brick_margin_r = apollo13_make_css_rule( 'margin-right', $margin_half, '%fpx' );
$works_brick_margin_l = apollo13_make_css_rule( 'margin-left', $margin_half, '%fpx' );
$works_brick_padd_t   = apollo13_make_css_rule( 'padding-top', $margin);
$works_brick_padd_r   = apollo13_make_css_rule( 'padding-right', $margin_half, '%fpx' );
$works_brick_padd_l   = apollo13_make_css_rule( 'padding-left', $margin_half, '%fpx' );
$works_titles         = ($this->theme_options[ 'cpt_work' ][ 'show_titles' ] == 'off')? 'display: none !important;' : '';

//single work
$work_scroller_h      = apollo13_make_css_rule( 'height', $this->theme_options[ 'cpt_work' ][ 'scroller_height' ]);
$work_slider_h        = apollo13_make_css_rule( 'height', $this->theme_options[ 'cpt_work' ][ 'slider_height' ]);
$work_caption         = ($this->theme_options[ 'cpt_work' ][ 'titles' ] == 'off')? 'display: none !important;' : '';
$work_slide_list      = ($this->theme_options[ 'cpt_work' ][ 'list' ] == 'off')? 'display: none !important;' : '';



/*
 *  fonts
 */
$temp               = explode(':', $this->theme_options[ 'fonts' ][ 'normal_fonts' ]);
$normal_fonts       = ($temp[0] === 'default')? '' : apollo13_make_css_rule( 'font-family', $temp[0], '%s, sans-serif' );
$temp               = explode(':', $this->theme_options[ 'fonts' ][ 'titles_fonts' ]);
$titles_fonts       = ($temp[0] === 'default')? '' : apollo13_make_css_rule( 'font-family', $temp[0], '%s, sans-serif' );
$temp               = explode(':', $this->theme_options[ 'fonts' ][ 'nav_menu_fonts' ]);
$nav_menu_font      = ($temp[0] === 'default')? '' : apollo13_make_css_rule( 'font-family', $temp[0], '%s, sans-serif' );


$custom_CSS = $this->theme_options[ 'appearance' ][ 'custom_css' ];

/**********************************
 * START OF CSS
 **********************************/
$user_css = '';
if($menu_icons != 'off'){
    $user_css .= file_get_contents(TPL_CSS_DIR . '/font-awesome.min.css') . "\r\n";
}
if($header_scheme == 'dark'){
    $user_css .= file_get_contents(TPL_CSS_DIR . '/header_black.css');
}

$user_css .= "
/* ==================
   GLOBAL
   ==================*/
a{
    $links_color
}
a:hover{
    $links_color_hover
}
h1,h2,h3,h4,h5,h6
h1 a,h2 a,h3 a,h4 a,h5 a, h6 a,
.page-title,
.widget .title{
    $headings_color
    $titles_fonts
    $headings_weight
    $headings_transform
}
h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,
.post .post-title a:hover, .post a.post-title:hover{
    $headings_color_hover
}


/* ==================
   FONTS
   ==================*/
/* All things font(menu, interactive elements, labels).
 * Not used for content text and titles
 */
body,
.a13-button,
input[type=\"submit\"]{
	$nav_menu_font
}

/* Text content font */
.real-content,
.site-desc-text, .foot-text, .copyright,
.post-meta,
.navigation,
.widget .post-title,
.widget .content,
div.textwidget,
div.widget_rss li,
div.about-author,
div.comments-area,
.contact-form,
input[type=\"text\"],
input[type=\"search\"],
input[type=\"password\"],
textarea,
select{
    $normal_fonts
}


/* ==================
   HEADER
   ==================*/
#header{
    $header_bg_color
}
.site-desc-text, .foot-text, .copyright{
    $header_font_size
    $header_font_color
}

#logo{
	$logo_color
    $logo_font_size
}
#access h3.assistive-text{
    $menu_color
    $menu_font_size
}
.top-menu li{
    $menu_bg_color
}
.top-menu > li:after{
    $menu_sep_color
}
.top-menu li a{
    $menu_color
    $menu_font_size
    $menu_weight
    $menu_transform
}
.top-menu li a:hover{
    $menu_hover_color
}
.top-menu li.current-menu-item > a{
    $menu_active_color
}
.top-menu li li a{
    $submenu_font_size
}
.top-menu li li:hover{
    $submenu_hover_bg_color
}
.top-menu .m_desc{
    $menu_desc_color
}


/* ==================
   GALLERIES LIST
   ==================*/
#a13-galleries{
     $galleries_brick_padd_t
     $galleries_brick_padd_l
     $galleries_brick_padd_r
}
#a13-galleries .g-item{
     $galleries_brick_margin_b
     $galleries_brick_margin_r
     $galleries_brick_margin_l
     $galleries_brick_height
     $galleries_brick_width
}
#a13-galleries .g-item i{
    $galleries_brick_img_height
}
#a13-galleries .g-item .cov span{
    $galleries_titles
}


/* ==================
   GALLERY
   ==================*/
#a13-gallery{
     $gallery_brick_padd_t
     $gallery_brick_padd_l
     $gallery_brick_padd_r
}
#a13-gallery .g-item{
     $gallery_brick_margin_b
     $gallery_brick_margin_r
     $gallery_brick_margin_l
     $gallery_brick_height
     $gallery_brick_width
}
#a13-gallery .g-item i{
    $gallery_brick_img_height
}
.single-gallery #a13-slider-caption{
    $gallery_caption
}
.single-gallery #slide-list{
    $gallery_slide_list
}


/* ==================
   WORKS LIST
   ==================*/
#a13-works{
     $works_brick_padd_t
     $works_brick_padd_l
     $works_brick_padd_r
}
#a13-works .g-item{
     $works_brick_margin_b
     $works_brick_margin_r
     $works_brick_margin_l
     $works_brick_height
     $works_brick_width
}
#a13-works .g-item i{
    $works_brick_img_height
}
#a13-works .g-item .cov span{
    $works_titles
}


/* ==================
   SINGLE WORK
   ==================*/
.single-work #a13-scroll-pan{
    $work_scroller_h
}
.single-work .in-post-slider{
    $work_slider_h
}
.single-work #a13-slider-caption{
    $work_caption
}
.single-work #slide-list{
    $work_slide_list
}

   
/* ==================
   MASONRY STYLE BLOG
   ==================*/
#masonry-parent{
    $blog_brick_padd_t
    $blog_brick_padd_l
    $blog_brick_padd_r
}
.archive-item{
    $blog_brick_width
    $blog_brick_margin_b
    $blog_brick_margin_r
    $blog_brick_margin_l
}
#post-list{
    $blog_bg_color
}


/* ==================
   RESPONSIVE
   ==================*/
@media print,
(-o-min-device-pixel-ratio: 5/4),
(-webkit-min-device-pixel-ratio: 1.25),
(min-resolution: 120dpi) {
    #logo img{
        $logo_shrink
    }
}
@media only screen and (max-width: 650px) {
    #footer{
        $header_bg_color
    }
}

/* ==================
   CUSTOM CSS
   ==================*/
$custom_CSS
";

return $user_css;
