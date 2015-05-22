<?php 
include_once 'Framework.php';
class Dummy extends Framework {
        
    public function select() {
        return get_option('anps_dummy');
    }
    
    public function save() { 
        $date = explode("/",date("Y/m"));
        $dummy_xml = "dummy1";
        if(isset($_POST['dummy1'])) {
            $dummy_xml = "dummy1";
            update_option('anps_menu_type', "2");
            update_option('portfolio_single', "style-2");
            update_option('anps_front_text_color', "#000000");
            update_option('anps_front_text_hover_color', "#3178bf");
            update_option('anps_above_nav_bar', "1");
            update_option('topmenu_style', "3");
        } elseif(isset($_POST['dummy2'])) {
            $dummy_xml = "dummy2";
        }
        
        /* set dummy to 1 */
        update_option('anps_dummy', 1);
        /* Import dummy xml */
        include_once 'importer/wordpress-importer.php';
        $parse = new WP_Import();
        $parse->import(get_template_directory() . "/anps-framework/classes/importer/$dummy_xml.xml");
        global $wp_rewrite;
        $blog_id = get_page_by_title("News")->ID;
        $error_id = get_page_by_title("404 Page")->ID;
        $first_id = get_page_by_title("Home")->ID;
        $arr = array(
            'error_page'=>$error_id
            );
        
        update_option($this->prefix.'page_setup', $arr); 
        update_option('page_for_posts', $blog_id);
        update_option('page_on_front', $first_id);                                
        update_option('show_on_front', 'page'); 
        update_option('permalink_structure', '/%postname%/'); 
        $wp_rewrite->set_permalink_structure('/%postname%/');    
        $wp_rewrite->flush_rules();
        
        /* Set menu as primary */
	$menu_id = wp_get_nav_menus();
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id[0]->term_id;
        set_theme_mod('nav_menu_locations', $locations);
        update_option('menu_check', true);
        
        /* Install all widgets */
        $this->__add_widgets($dummy_xml);
        
        /* Add revolution slider demo data */
        $this->__add_revslider($dummy_xml);
    }
    
    protected function __add_revslider($dummy_xml) {
        /* Check if slider is installed */
        if(is_plugin_active("revslider/revslider.php")) {
            $slider = new RevSlider();
            $slider_name = "main-slider";
            $response = $slider->importSliderFromPost($updateAnim, $updateStatic, get_template_directory() . "/anps-framework/classes/importer/$slider_name.zip");
            //handle error
            if($response["success"] == false){
                $message = $response["error"];
                dmp("<b>Error: ".$message."</b>");
                exit;
            }
        } else {
            echo "Revolution slider is not active. Demo data for revolution slider can't be inserted.";
        }
    }  
    
    protected function __add_widgets($dummy_xml) {
        $secondary_sidebar = 'secondary-widget-area';
        $top_left_sidebar = 'top-bar-left';
        $top_right_sidebar = 'top-bar-right';
        $above_navigation_bar = 'above-navigation-bar';
        $footer_1_sidebar = "footer-1";
        $footer_2_sidebar = "footer-2";
        $footer_3_sidebar = "footer-3";
        $footer_4_sidebar = "footer-4";
        $copyright_1_sidebar = "copyright-1";
        $widget_anpssocial = 'anpssocial';
        $widget_anpstext = 'anpstext';
        $widget_anpsimage = 'anpsimages';
        $widget_wptext = 'text';
        $widget_navigation = 'nav_menu';
        $sidebar_options = get_option('sidebars_widgets');
        if(!isset($sidebar_options[$secondary_sidebar])){
            $sidebar_options[$secondary_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$top_left_sidebar])){
            $sidebar_options[$top_left_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$top_right_sidebar])){
            $sidebar_options[$top_right_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$above_navigation_bar])){
            $sidebar_options[$above_navigation_bar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_1_sidebar])){
            $sidebar_options[$footer_1_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_2_sidebar])){
            $sidebar_options[$footer_2_sidebar] = array('_multiwidget'=>1);
        }
        if(!isset($sidebar_options[$footer_3_sidebar])){
            $sidebar_options[$footer_3_sidebar] = array('_multiwidget'=>1);
        }
        /* Top left sidebar */
        $anpssocial = get_option('widget_'.$widget_anpssocial);
        if(!is_array($anpssocial))$anpssocial = array();
        $socialcount = count($anpssocial)+1;
        $sidebar_options[$top_left_sidebar][] = $widget_anpssocial.'-'.$socialcount;
        $anpssocial[$socialcount] = array(
            'sidebar_content' => 'on',
            'icon_0' => 'facebook',
            'url_0' => "#",
            'icon_1' => 'twitter',
            'url_1' => "#",
            'icon_2' => 'linkedin',
            'url_2' => "#",
            'icon_3' => 'google-plus',
            'url_3' => "#",
        );
        $socialcount++;
        /* END Top left sidebar */
        /* Top right sidebar */
        $anpstext = get_option('widget_'.$widget_anpstext);
        if(!is_array($anpstext))$anpstext = array();
        $textcount = count($anpstext)+1;
        /* First widget */
        $sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'clock-o',
            'text' => "Mon - Sat: 7:00 - 17:00"
        );
        $textcount++;
        /* Second widget */
        $sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'phone',
            'text' => "<span style='color:#1ab8cf;'>+ 386 40 111 5555</span>"
        );
        $textcount++;
        /* Third widget */
        $sidebar_options[$top_right_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'envelope-o',
            'text' => '<span style="color:#1ab8cf;">info@yourdomain.com</span>'
        );
        $textcount++;
        /* END Top right sidebar */
        /* Above navigation sidebar */
        /* First widget */
        $sidebar_options[$above_navigation_bar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'lock',
            'text' => "Customer <a href='#'><span style='color:#25507a;'>login</span></a>"
        );
        $textcount++;
        /* Second widget */
        $sidebar_options[$above_navigation_bar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'phone',
            'text' => "Call us free: <span style='color:#25507a;'>+057 6854 456</span>"
        );
        $textcount++;
        /* END Above navigation sidebar */
        /* Footer 1 sidebar */
        $anpsimage = get_option('widget_'.$widget_anpsimage);
        if(!is_array($anpsimage))$anpsimage = array();
        $imagecount = count($anpsimage)+1;
        /* Image widget */
        $sidebar_options[$footer_1_sidebar][] = $widget_anpsimage.'-'.$imagecount;
        $footer_image = '/2015/04/logo-footer.png';
        $upload_dir = wp_upload_dir();
        $anpsimage[$imagecount] = array(
            'image' => $upload_dir['baseurl'].$footer_image,
            'title' => 'ABOUT US'
        );
        $imagecount++;
        /* END Image widget */
        $wptext = get_option('widget_'.$widget_wptext);
        if(!is_array($wptext))$wptext = array();
        $wptextcount = count($wptext)+1;
        /* Text widget */
        $sidebar_options[$footer_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
        $wptext[$wptextcount] = array(
            'text' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam turpis quam, sodales in ante sagittis, varius efficitur mauris.",
            'filter' => 'on'
        );
        $wptextcount++;
        /* END Text widget */
        /* END Footer 1 sidebar */
        /* Footer 2 sidebar */
        $wpnavigation = get_option('widget_'.$widget_navigation);
        if(!is_array($wpnavigation))$wpnavigation = array();
        $navigationcount = count($wpnavigation)+1;
        /* Navigation */
        $locations = get_theme_mod('nav_menu_locations');
        $menu = 2;
        if($locations && $locations['primary']) {
            $menu = $locations['primary'];
        }
        $sidebar_options[$footer_2_sidebar][] = $widget_navigation.'-'.$navigationcount;
        $wpnavigation[$navigationcount] = array(
            'nav_menu' => $menu,
            'title' => 'NAVIGATION'
        );
        $navigationcount++;
        /* END Navigation */
        /* END Footer 2 sidebar */
        /* Footer 3 sidebar */
        /* Text */
        $sidebar_options[$footer_3_sidebar][] = $widget_wptext.'-'.$wptextcount;
        $wptext[$wptextcount] = array(
            'title' => 'ACCOUNTING OFFICE'
        );
        $wptextcount++;
        /* END Text */
        /* Icon 1 */
        $sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'map-marker',
            'text' => 'Accounting ltd. inc.<br /> 300 Pennsylvania Ave NW, Washington<br /><br />'
        );
        $textcount++;
        /* END Icon 1 */
        /* Icon 2 */
        $sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'phone',
            'text' => 'Telephone: +386 40 222 455'
        );
        $textcount++;
        /* END Icon 2 */
        /* Icon 3 */
        $sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'mobile',
            'text' => 'Mobile phone: +386 40 112 555'
        );
        $textcount++;
        /* END Icon 3 */
        /* Icon 4 */
        $sidebar_options[$footer_3_sidebar][] = $widget_anpstext.'-'.$textcount;
        $anpstext[$textcount] = array(
            'icon' => 'print',
            'text' => 'FAX: +386 40 4444 1155'
        );
        $textcount++;
        /* END Icon 4 */
        /* END Footer 3 sidebar */
        /* Footer 4 sidebar */
        /* Text */
        $sidebar_options[$footer_4_sidebar][] = $widget_wptext.'-'.$wptextcount;
        $wptext[$wptextcount] = array(
            'text' => 'We work 7 days a week, every day including major holidays. Contact us for any info.<br /><br />
                        Monday - Friday: <span class="right">7:00 - 17:00 </span><br />
                        Saturday:   <span class="right">7:00 - 12:00</span> <br />
                        Sunday and holidays:     <span class="right">8:00 - 10:00</span>',
            'title' => 'WORKING HOURS'
        );
        $wptextcount++;
        /* END Text */
        /* END Footer 4 sidebar */
        /* Copyright Footer 1 sidebar */
        /* Text */
        $sidebar_options[$copyright_1_sidebar][] = $widget_wptext.'-'.$wptextcount;
        $wptext[$wptextcount] = array(
            'text' => "Accounting wordpress theme | © 2015 Anpsthemes, All rights reserved"
        );
        $wptextcount++;
        /* END Text */
        /* END Copyright Footer 1 sidebar */
        /* Secondary sidebar */
        /* Navigation */
        $locations = get_theme_mod('nav_menu_locations');
        $menu = 2;
        if($locations && $locations['primary']) {
            $menu = $locations['primary'];
        }
        $sidebar_options[$secondary_sidebar][] = $widget_navigation.'-'.$navigationcount;
        $wpnavigation[$navigationcount] = array(
            'nav_menu' => $menu,
            'title' => 'Navigation'
        );
        $navigationcount++;
        /* END Navigation */
        /* END Secondary sidebar */
        update_option('sidebars_widgets',$sidebar_options);
        update_option('widget_'.$widget_anpssocial, $anpssocial);
        update_option('widget_'.$widget_anpstext, $anpstext);
        update_option('widget_'.$widget_anpsimage, $anpsimage);
        update_option('widget_'.$widget_wptext, $wptext);
        update_option('widget_'.$widget_navigation, $wpnavigation);
        update_option('widget_'.$widget_tags, $wptags);
        update_option('widget_'.$widget_anpsrecent, $anpsrecent);
    }
}
$dummy = new Dummy();