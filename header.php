<!DOCTYPE html>
<!--[if lt IE 8]> <html class="no-js lt-ie10 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie10 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<meta name="author" content="Apollo13.eu" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php a13_favicon(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.min.js" type="text/javascript"></script>

<?php wp_head(); ?>

</head>

<body id="top" <?php body_class(); ?>>

<?php
    global $apollo13;
    $header_search = ($apollo13->get_option( 'appearance', 'header_search' ) == 'on')? true : false;
?>

    <header id="header">
        <div class="head clearfix<?php echo $header_search? ' with-search' : ''; ?>">
            <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php
                if($apollo13->get_option( 'appearance', 'logo_type' ) == 'image')
                    echo '<img src="'.esc_url($apollo13->get_option( 'appearance', 'logo_image' )).'" alt="'. esc_attr( get_bloginfo( 'name', 'display' ) ).'" />';
                else
                    echo $apollo13->get_option( 'appearance', 'logo_text' );
                ?></a>

            <?php
                $lt = $apollo13->get_option( 'settings', 'under_logo_text' )   ;
                if(!empty($lt)) echo '<div class="site-desc-text">'.nl2br($lt).'</div>';
            ?>

            <nav id="access" role="navigation">
                <h3 class="assistive-text"><?php _fe( 'Main menu' ); ?></h3>
                <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
                <a class="assistive-text" href="#begin-of-content" title="<?php esc_attr_e( __fe('Skip to primary content') ); ?>"><?php _fe( 'Skip to primary content' ); ?></a>
                <a class="assistive-text" href="#secondary" title="<?php esc_attr_e( __fe('Skip to secondary content') ); ?>"><?php _fe( 'Skip to secondary content' ); ?></a>

                <div class="menu-container">
                    <?php a13_header_menu(); ?>
                </div>
            </nav><!-- #access -->

            <?php a13_social_icons(); ?>

            <?php
                //search form
                if( $header_search) echo get_search_form();
            ?>
        </div>
    </header>

    <div id="mid" class="clearfix<?php echo a13_get_mid_classes(); ?>">
        <?php
            a13_bg_image();

            if( 0 && WP_DEBUG ) $apollo13->page_type_debug();
