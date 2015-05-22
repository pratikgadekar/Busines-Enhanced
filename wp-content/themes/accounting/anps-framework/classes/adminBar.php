<?php 

class adminBar {
  
  function adminBar() {
      add_action( 'admin_bar_menu', array( $this, "themeoptions_links" ), 100 );
  }

  function add_root_menu($name, $id, $href = FALSE) {
    global $wp_admin_bar;
    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;

    $wp_admin_bar->add_menu( array(
        'id'   => $id,
        'meta' => array(),
        'title' => $name,
        'href' => $href ) );
  }

  function add_sub_menu($name, $id ,$link, $root_menu, $meta = FALSE) {
      global $wp_admin_bar;
      if ( ! is_super_admin() || ! is_admin_bar_showing() )
          return;
    
      $wp_admin_bar->add_menu( array(
          'id' => $id,
          'parent' => $root_menu,
          'title' => $name,
          'href' => $link,
          'meta' => $meta
      ) );
  }

  function themeoptions_links() {
      $this->add_root_menu( "Theme options", "anps",admin_url('themes.php?page=theme_options'));
      $this->add_sub_menu( "Theme style", 'anps_style', admin_url('themes.php?page=theme_options&sub_page=theme_style') , "anps" );
      $this->add_sub_menu( "Theme settings", 'anps_settings',admin_url('themes.php?page=theme_options&sub_page=options'), "anps" );
      $this->add_sub_menu( "Contact form", 'anps_contact',admin_url('themes.php?page=theme_options&sub_page=contact_form'), "anps" );
      $this->add_sub_menu( "Dummy content", 'anps_content',admin_url('themes.php?page=theme_options&sub_page=dummy_content'), "anps" );
  }

}
add_action( "init", "themeOptionsMenuInit" );
function themeOptionsMenuInit() {
    global $theme_adminBar;
    $theme_adminBar = new adminBar();
}