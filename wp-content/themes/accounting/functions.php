<?php 
/* Theme auto update */
load_template(trailingslashit(get_template_directory()).'anps-framework/classes/AnpsUpgrade.php' );
AnpsUpgrade::init();
/* CONSTANTS */
define('ANPS_TEMPLATE_LANG', 'accounting');
global $no_container;
$no_container = false;

/* Override vc tabs */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    /* Set as theme (no licence message) */
    add_action( 'vc_before_init', 'anps_vcSetAsTheme' );
    function anps_vcSetAsTheme() {
        vc_set_as_theme();
    }
    /* END Set as theme (no licence message) */
    function vc_theme_rows($atts, $content) {
        $extra_class = '';
        $extra_id = '';
        $matches = array();

        global $no_container, $row_inner, $text_only;
        
        wp_enqueue_script('wpb_composer_front_js');

        if ( $row_inner ) {
            return vc_theme_rows_inner($atts, $content);
        }

        if ( $text_only ) {
            return wpb_js_remove_wpautop($content);
        }

        /* Check for any user added styles */

        $css = '';
        if( isset($atts['css']) ) {
            $css = $atts['css'];
        }

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if(!empty($matches)) {
            $temp = $matches[1];

            if( $temp ) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        /* Check for any user added classes */

        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class .= ' '. $atts['el_class'];
        }

        /* Check for any user added IDs */

        if(isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "'. $atts['id'].'"';
        }

        $coming_soon = get_option('coming_soon', '0'); 
        if($coming_soon=="0"||is_super_admin()) { 
            if(!isset($atts['has_content']) || $atts['has_content']=="true") { 
                /* Content inside a container */
                $no_container = false;
                $no_top_margin = '';
                if( strpos($extra_class, 'no-top-margin') ) {
                    $no_top_margin = ' no-top-margin';
                }
                return '<section class="wpb_row container' . $no_top_margin .'"><div '.$extra_id.' class="row' . $extra_class . '">'.wpb_js_remove_wpautop($content).'</div></section>';
            } 
            elseif($atts['has_content']=="inside") { 
                $no_container = false;
                return '<section '.$extra_id.' class="wpb_row' . $extra_class . '"><div class="container no-margin"><div class="row">'.wpb_js_remove_wpautop($content).'</div></div></section>';
            }
            else { 
                /* Fullwidth Content */
                $no_container = true;
                return '<section '.$extra_id.' class="wpb_row row no-margin' . $extra_class . '"><div class="row">'.wpb_js_remove_wpautop($content).'</div></section>';
            }
        } else { 
            /* No wrappers, only when Cooming soon is active */
            $no_container = true;
            return wpb_js_remove_wpautop($content);
        } 
    }
    function vc_theme_rows_inner($atts, $content) { 

        /* Check for any user added styles */

        $style = "";
        $css = '';

        if( isset($atts['css']) ) {
            $css = $atts['css'];
        }
        $extra_id = '';
        $extra_class = '';
        
        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if(!empty($matches)) {
            $temp = $matches[1];

            if( $temp ) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }
        
        $temp2 = preg_match('/{(.*?)}/s', $css, $matches2);
        if(!empty($matches2)) {
            $temp2 = $matches2[1];
            if( $temp2 ) {
                $style = ' style="' . $temp2 . '"';
            }
        }
        
        if(isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "'. $atts['id'].'"';
        }
        return '<div '.$extra_id.' class="row' . $extra_class . '"' . $style . '>'.wpb_js_remove_wpautop($content).'</div>';
    }
    function vc_theme_columns($atts, $content = null) { 
        if( !isset($atts['width']) ) {
            $width = '1/1';
        } else {
            $width = explode('/', $atts['width']); 
        }

        global $no_container, $text_only;
        $extra_id = '';
        $extra_class = '';
        if($width[1] > 0) {
            $col = (12/$width[1])*$width[0];
        } else {
            $col = 12;
        }
        $css = '';
        if( isset($atts['css']) ) {
            $css = $atts['css'];
        }
        
        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if(!empty($matches)) {
            $temp = $matches[1];

            if( $temp ) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }
        $mobile_class = "";
        if(isset($atts['offset']) && $atts['offset']) {
            $mobile_class = " ".$atts['offset'];
        }
        
        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class = ' ' . $atts['el_class'];
        }
      
        if(isset($atts['id']) && $atts['id']) {
            $extra_id = 'id= "'. $atts['id'].'"';
        }

        if ( $no_container || $text_only ) { 
            return '<div class="wpb_column col-md-'.$col.$extra_class.$mobile_class.'">'.wpb_js_remove_wpautop($content)."</div>";
        } else { 
            return '<div '.$extra_id.' class="wpb_column col-md-' .$col.$extra_class.$mobile_class.'">'.wpb_js_remove_wpautop($content).'</div>';
        }
    }
    function vc_theme_vc_row($atts, $content = null) {
        return vc_theme_rows($atts, $content);
    }
    function vc_theme_vc_row_inner($atts, $content = null) {
        return vc_theme_rows_inner($atts, $content);
    }
    function vc_theme_vc_column($atts, $content = null) {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_column_inner($atts, $content = null) {
        return vc_theme_columns($atts, $content);
    }
    function vc_theme_vc_tabs($atts, $content = null) { 
        $content2 = str_replace("vc_tab", "tab", $content);
        if(!isset($atts['type'])) {
            $atts['type'] = "";
        } else {
            $atts['type'] = $atts['type'];
        }
        return do_shortcode("[tabs type='".$atts['type']."']".$content2."[/tabs]");
    }
    function vc_theme_vc_column_text($atts, $content = null) {
        $extra_class = '';

        /* Check for any user added styles */

        $css = '';
        if( isset($atts['css']) ) {
            $css = $atts['css'];
        }

        $temp = preg_match('/\.vc_custom_(.*?){/s', $css, $matches);
        if(!empty($matches)) {
            $temp = $matches[1];

            if( $temp ) {
                $extra_class .= ' vc_custom_' . $temp;
            }
        }

        /* Check for any user added classes */

        if(isset($atts['el_class']) && $atts['el_class']) {
            $extra_class .= ' '. $atts['el_class'];
        }

        return '<div class="text' . $extra_class . '">' . do_shortcode(force_balance_tags($content)) . '</div>';
    }
} 
/* Title tag theme support */
add_theme_support('title-tag');

/* Custom header theme support */
add_theme_support('custom-header');

/* Custom background theme support */
add_theme_support('custom-background');

/* Image sizes */
add_theme_support('post-thumbnails');

/* team */
add_image_size('team-3', 370, 360, false);
// Blog views
add_image_size('blog-grid', 720, 412, true);
add_image_size('blog-full', 1200);
add_image_size('blog-masonry-3-columns', 360, 0, false);
// Recent blog, portfolio
add_image_size('post-thumb', 360, 267, true); 
// Portfolio random grid
add_image_size('portfolio-random-width-2', 554, 202, true);
add_image_size('portfolio-random-height-2', 262, 433, true);
add_image_size('portfolio-random-width-2-height-2', 554, 433, true);

if(!is_admin()) {
    include_once get_template_directory().'/anps-framework/classes/Options.php'; 
    include_once get_template_directory().'/anps-framework/classes/Contact.php'; 
    $anps_page_data = $options->get_page_setup_data();
    $anps_options_data = $options->get_page_data(); 
    $anps_media_data = $options->get_media(); 
    $anps_social_data = $options->get_social(); 
    $anps_contact_data = $contact->get_data();
    $anps_shop_data = $options->get_shop_setup_data();
}
/* Include helper.php */
include_once get_template_directory().'/anps-framework/helpers.php';
if (!isset($content_width)) {
    $content_width = 967;
}
add_filter('widget_text', 'do_shortcode');
/* Widgets */
include_once 'anps-framework/widgets/widgets.php';
/* Shortcodes */
include_once 'anps-framework/shortcodes.php';
if (is_admin()) {
    include_once 'shortcodes/shortcodes_init.php';
}
/* On setup theme */
add_action('after_setup_theme', 'anps_register_custom_fonts');
function anps_register_custom_fonts() { 
    if (!isset($_GET['stylesheet'])) {
        $_GET['stylesheet'] = '';
    }
    $theme = wp_get_theme($_GET['stylesheet']);
    if (!isset($_GET['activated'])) {
        $_GET['activated'] = '';
    }
    if ($_GET['activated'] == 'true' && $theme->get_template() == ANPS_TEMPLATE_LANG) { 
        include_once get_template_directory().'/anps-framework/classes/Options.php';
        include_once get_template_directory().'/anps-framework/classes/Style.php';
        /* Add google fonts*/
        if(get_option('anps_google_fonts', '')=='') {
            $style->update_gfonts_install();
        }
        /* Add custom fonts to options */
        $style->get_custom_fonts();
        /* Add default fonts */
        if(get_option('font_type_1', '')=='') {
            update_option("font_type_1", "PT Serif");
        }
        if(get_option('font_type_2', '')=='') {
            update_option("font_type_2", "PT Sans");
        }
    }
    $fonts_installed = get_option('fonts_intalled');
    
    if($fonts_installed==1)
        return;
    
    /* Get custom font */
    include_once get_template_directory().'/anps-framework/classes/Style.php';
    $fonts = $style->get_custom_fonts();
    /* Update custom font */
    foreach($fonts as $name=>$value) { 
        $arr_save[] = array('value'=>$value, 'name'=>$name);
    }
    update_option('anps_custom_fonts', $arr_save);
    update_option('fonts_intalled', 1);
}
/* Team metaboxes */
include_once 'anps-framework/team_meta.php';
/* Portfolio metaboxes */
include_once 'anps-framework/portfolio_meta.php';
/* Portfolio metaboxes */
include_once 'anps-framework/metaboxes.php';
/* Menu metaboxes */
include_once 'anps-framework/menu_meta.php';
/* Heading metaboxes */
include_once 'anps-framework/heading_meta.php';
/* Featured video metabox */
include_once 'anps-framework/featured_video_meta.php';
 
//install paralax slider
include_once 'anps-framework/install_plugins.php';
add_editor_style('css/editor-style.php');
/* Admin bar theme options menu */
include_once 'anps-framework/classes/adminBar.php';
/* PHP header() NO ERRORS */
if (is_admin())
    add_action('init', 'anps_do_output_buffer');
function anps_do_output_buffer() {
    ob_start();
}
/* Infinite scroll 08.07.2013 */
function anps_infinite_scroll_init() {
    add_theme_support( 'infinite-scroll', array(
        'type'       => 'click',
        'footer_widgets' => true,
        'container'  => 'section-content',
        'footer'     => 'site-footer',
    ) );
}
add_action( 'init', 'anps_infinite_scroll_init' );
/* MegaMenu */
class description_walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        //global $anps_options_data;
        //$menu_separate = get_post_meta($item->object_id, $key ='anps_menu_separate', $single = true); 
         //if($menu_separate=="1" || ($item->object!="custom" && get_home_url()!=$item->url)) { 
             $item->url = $item->url;
         /*} else { 
             $post = get_post($item->object_id ); 
             $slug = $post->post_name; 
             if(is_front_page()) {
                 $item->url = "#".$slug;
             } else {
                 $item->url = get_site_url()."/#".$slug;
             }
         }*/
        global $wp_query;
        $menu_style = get_option('menu_style', '1');
        if( isset($_GET['header']) && $_GET['header'] == 'type-2' ) {
            $menu_style = '2';
        }
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li' . $value . $class_names .'>';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url       ) .'"' : '';

        $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
        if (empty($children)) {
            $dropdownfix = "";
        }
        else
        {
            $dropdownfix = ' class="dropdown-toggle" data-hover="dropdown"';
        } 
 
        $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
        $description = do_shortcode($description);

        $append = "";
        $prepend = "";
        
        if($depth==0 && $menu_style!="2")
        {
            $description = $append = $prepend = "";
        }
        $locations = get_theme_mod('nav_menu_locations');
        
        if($locations['primary']) {
            $item_output = "";
            $item_output = $args->before;
            $item_output .= '<a'. $attributes . $dropdownfix . '>';   //Andrej dodal dropdownfix


            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth = 0, $args, $args, $current_object_id = 0 );
        }
    }
} 
/* Post/Page gallery images */
include_once 'anps-framework/gallery_images.php';

function anps_scripts_and_styles() {
    wp_enqueue_script("jquery");  
    wp_enqueue_style("prettyphoto", get_template_directory_uri()  . "/css/prettyPhoto.css");
    wp_deregister_style( "font-awesome" );
    wp_enqueue_style("font-awesome-1", get_template_directory_uri() . "/css/font-awesome.min.css");
    wp_enqueue_style("custom_button_styles", get_template_directory_uri()  . "/includes/custom-button-styles.php");
    wp_enqueue_style("owl-css", get_template_directory_uri() . "/js/owl//assets/owl.carousel.css");
    wp_enqueue_style("accounting", get_template_directory_uri() . "/css/accounting.css");
    wp_enqueue_style("custom_styles", get_template_directory_uri()  . "/includes/custom-styles.php");

    //transitions
    $transition_style = 'transition-'. get_option( 'logo_transition_style', '5' ) . '.css';
    wp_enqueue_style("transition", get_template_directory_uri()  . "/css/transitions/". $transition_style);

    global $is_IE;

    if ( $is_IE ) {
        wp_enqueue_style("ie-fix", get_template_directory_uri() . '/css/ie-fix.css');
        wp_enqueue_script( "iefix", get_template_directory_uri()  . "/js/ie-fix.js", '', '', true );
    }
  
    wp_register_script( "fullwidth-slider", get_template_directory_uri()  . "/js/fullwidth-slider.js", '', '', true );
    if( ! isset( $_GET['vceditor'] ) ) {
        wp_deregister_script( 'isotope' );
        wp_register_script( "anps-isotope", get_template_directory_uri()  . "/js/jquery.isotope.min.js", '', '', true );
    }

    wp_register_script( "alert", get_template_directory_uri()  . "/js/bootstrap/alert.js", '', '', true );
    wp_register_script( "tab", get_template_directory_uri()  . "/js/bootstrap/tab.js", '', '', true );
    wp_register_script( "collapse", get_template_directory_uri()  . "/js/bootstrap/collapse.js", '', '', true );
    wp_enqueue_script( "carousel", get_template_directory_uri()  . "/js/bootstrap/carousel.js", '', '', true );
    wp_enqueue_script( "transition", get_template_directory_uri()  . "/js/bootstrap/transition.js", '', '', true );
    wp_enqueue_script( "dropdown", get_template_directory_uri()  . "/js/bootstrap/dropdown.js", '', '', true );
    wp_register_script( "gmap3_link", "http://maps.google.com/maps/api/js?sensor=false", '', '', true );
    wp_register_script( "gmap3", get_template_directory_uri()  . "/js/gmap3.min.js", '', '', true );
    wp_register_script( "countto", get_template_directory_uri()  . "/js/countto.js", '', '', true );
    wp_enqueue_script( "waypoints", get_template_directory_uri()  . "/js/waypoints.js", '', '', true );
    wp_enqueue_script( "prettyphoto", get_template_directory_uri()  . "/js/jquery.prettyPhoto.js", '', '', true );
    wp_enqueue_script( "parallax", get_template_directory_uri()  . "/js/parallax.js", '', '', true );
    wp_enqueue_script( "functions", get_template_directory_uri()  . "/js/functions.js", '', '', true );
    wp_enqueue_script( "imagesloaded", get_template_directory_uri()  . "/js/imagesloaded.js", array('jquery'), '', true );
    wp_enqueue_script( "doubletap", get_template_directory_uri()  . "/js/doubletaptogo.js", array('jquery'), '', true );
    wp_enqueue_script("owl", get_template_directory_uri() . "/js/owl/owl.carousel.js",array("jquery"), "", true);

}
add_action( 'wp_enqueue_scripts', 'anps_scripts_and_styles' );



function anps_theme_styles() {     
    global $anps_options_data;
    
    if (get_option('font_source_1', "Google fonts")=='Google fonts') {
        wp_enqueue_style( "font_type_1",  'http://fonts.googleapis.com/css?family=' . get_option('font_type_1', 'PT+Serif') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    } else {
        wp_enqueue_style( "font_type_1",  'http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700,300&subset=latin,latin-ext');      
    }
        
    if (get_option('font_source_2', "Google fonts")=='Google fonts' && get_option('font_type_1', 'PT+Serif')!=get_option('font_type_2', 'PT+Sans')) {
        wp_enqueue_style( "font_type_2",  'http://fonts.googleapis.com/css?family=' . get_option('font_type_2', 'PT+Sans') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    }
    
    if (get_option('font_source_navigation', "Google fonts")=='Google fonts' && get_option('font_type_1', 'PT+Serif')!=get_option('font_type_2', 'PT+Sans') && get_option('font_type_1', 'PT+Serif')!=get_option('font_type_navigation', "PT+Serif")) {
        wp_enqueue_style( "font_type_navigation",  'http://fonts.googleapis.com/css?family=' . get_option('font_type_navigation', 'PT+Serif') . ':400italic,400,600,700,300&subset=latin,latin-ext');
    }

    wp_enqueue_style( "theme_main_style", get_bloginfo( 'stylesheet_url' ) );
    wp_enqueue_style( "theme_wordpress_style", get_template_directory_uri() . "/css/wordpress.css" );
    wp_enqueue_style( "custom", get_template_directory_uri() . '/custom.css' );
    $responsive = "";
    if (isset($anps_options_data['responsive'])) {
        $responsive = $anps_options_data['responsive'];
    }
} 

load_theme_textdomain( ANPS_TEMPLATE_LANG, get_template_directory() . '/languages' );

/* Admin only scripts */

function anps_load_custom_wp_admin_scripts($hook) {
    /* Overwrite VC styling */
    wp_enqueue_style( "vc_custom", get_template_directory_uri() . '/css/vc_custom.css' ); 
    wp_deregister_style( "font-awesome" );
    wp_enqueue_style("font-awesome-1", get_template_directory_uri() . "/css/font-awesome.min.css");
    wp_enqueue_style( "wp-backend", get_template_directory_uri() . "/anps-framework/css/wp-backend.css" );
    wp_enqueue_style("custom_button_styles", get_template_directory_uri()  . "/includes/custom-button-styles.php");
    wp_register_script('wp_backend_js', get_template_directory_uri() . "/anps-framework/js/wp_backend.js", array( 'jquery' ), false, true);
    wp_register_script('wp_colorpicker', get_template_directory_uri() . "/anps-framework/js/wp_colorpicker.js", array( 'wp-color-picker' ), false, true);
    if( 'appearance_page_theme_options' != $hook ) {
        return;
    }

    /* Theme Options Style */
    wp_enqueue_style( "admin-style", get_template_directory_uri() . '/anps-framework/css/admin-style.css' ); 
    if(!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page_setup")
        wp_enqueue_style( "colorpicker", get_template_directory_uri() . '/anps-framework/css/colorpicker.css' ); 
    wp_enqueue_script( "jquery_google", "//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" );
    if (isset($_GET['sub_page']) && ($_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page"))
        wp_enqueue_script( "pattern", get_template_directory_uri() . "/anps-framework/js/pattern.js" );
    if(!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page_setup") { 
        wp_enqueue_script( "colorpicker_theme", get_template_directory_uri() . "/anps-framework/js/colorpicker.js" ); 
        wp_enqueue_script( "colorpicker_custom", get_template_directory_uri() . "/anps-framework/js/colorpicker_custom.js" ); 
    }
    if (isset($_GET['sub_page']) && $_GET['sub_page'] == "contact_form") 
        wp_enqueue_script( "contact", get_template_directory_uri() . "/anps-framework/js/contact.js" ); 
    wp_enqueue_script( "theme-options", get_template_directory_uri() . "/anps-framework/js/theme-options.js" ); 
     
}
add_action( 'admin_enqueue_scripts', 'anps_load_custom_wp_admin_scripts' );