<?php 
include_once 'Framework.php';
class Options extends Framework {
    /* Save page layout data (page layout, copyright, top menu) */
    public function save_page() {
        update_option($this->prefix.'acc_info',$_POST);
        header("Location: themes.php?page=theme_options&sub_page=options");
    }
    
    /* Get page layout data */
    public function get_page_data() {
        return get_option($this->prefix.'acc_info');
    }
 
    /* Get shop data */
    public function get_shop_setup_data() {
        return get_option($this->prefix.'shop_setup');
    }
    /* Save page setup data (error, blog, portfolio page) */
    public function save_page_setup() { 
        update_option($this->prefix.'page_setup',$_POST);
        update_option('coming_soon',$_POST['coming_soon']);
        update_option('topmenu_style',$_POST['topmenu_style']);
        update_option('portfolio_single',$_POST['portfolio_single']);        
        update_option('anps_menu_type',$_POST['anps_menu_type']);
        update_option('anps_front_text_color',$_POST['anps_front_text_color']);
        update_option('anps_front_text_hover_color',$_POST['anps_front_text_hover_color']);
        update_option('anps_front_bg_color',$_POST['anps_front_bg_color']);
        update_option('anps_full_screen',$_POST['anps_full_screen']);
       // update_option('topmenu_style',$_POST['topmenu_style']);
        update_option('menu_style',$_POST['menu_style']);
        update_option('sticky_menu',$_POST['sticky_menu']);
        update_option('logo_transition_style',$_POST['logo_transition_style']);
        update_option('menu_center',$_POST['menu_center']);
        update_option('search_icon',$_POST['search_icon']);
        update_option('search_icon_mobile',$_POST['search_icon_mobile']);
        update_option('portfolio_single_footer',$_POST['portfolio_single_footer']);
        update_option('footer_style',$_POST['footer_style']);
        update_option('prefooter_style',$_POST['prefooter_style']);
        update_option('prefooter',$_POST['prefooter']);
        update_option('footer_disable',$_POST['footer_disable']);
        update_option('copyright_footer',$_POST['copyright_footer']);
        update_option('anps_front_topbar_color',$_POST['anps_front_topbar_color']);
        update_option('anps_front_topbar_hover_color',$_POST['anps_front_topbar_hover_color']);
        update_option('side_submenu_background_color',$_POST['side_submenu_background_color']);
        update_option('side_submenu_text_color',$_POST['side_submenu_text_color']);
        update_option('side_submenu_text_hover_color',$_POST['side_submenu_text_hover_color']);
        update_option('anps_front_logo',$_POST['anps_front_logo']);
        update_option('shopping_cart_header',$_POST['shopping_cart_header']);    
        update_option('anps_above_nav_bar',$_POST['anps_above_nav_bar']);


        header("Location: themes.php?page=theme_options&sub_page=options_page_setup");
    }
    
    /* Get page setup data */
    public function get_page_setup_data() {
        return get_option($this->prefix.'page_setup');
    }
    
    /* Save social account data */
    public function save_social() {
        update_option($this->prefix.'social_info', $_POST);
        header("Location: themes.php?page=theme_options&sub_page=options_social_accounts");
    }
    
    /* Save page setup data (error, blog, portfolio page) */
    public function save_shop_setup() {
        $anps_page_data = $this->get_shop_setup_data(); 
        update_option($this->prefix.'shop_setup',$_POST);
        header("Location: themes.php?page=theme_options&sub_page=shop_settings");
    }
    
    /* Get social account data */
    public function get_social() {
        return get_option($this->prefix."social_info");
    }
    
    /* Save media*/
    public function save_media() {
        update_option($this->prefix.'media_info', $_POST);
        update_option('auto_adjust_logo',$_POST['auto_adjust_logo']);
        header("Location: themes.php?page=theme_options&sub_page=options_media");
    }
    
    /* Get media */
    public function get_media() {
        return get_option($this->prefix.'media_info');
    }
}
$options = new Options();