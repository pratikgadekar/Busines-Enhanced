<div class="envoo-admin">
<?php $themever = wp_get_theme(); $version = $themever["Version"]; ?>
    <ul class="envoo-admin-menu">
        <li><a id="anpslogo" href="http://anpsthemes.com" target="_blank"></a><h2 class="small_lh"><?php _e("Theme Options", ANPS_TEMPLATE_LANG); ?><br/><span id="version"><?php echo esc_attr('version: '). esc_attr($version);?></span></h2></li>
        
        
        <li>
            <a class="has-submenu" <?php if (!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style" || $_GET['sub_page'] == "theme_style_google_font" || $_GET['sub_page'] == "theme_style_custom_font") echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=theme_style"><?php _e("Style Settings", ANPS_TEMPLATE_LANG); ?></a>
            <ul class="envoo-admin-submenu">
                <li><a <?php if (!isset($_GET['sub_page']) || $_GET['sub_page'] == "theme_style") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style"><i class="fa fa-tint"></i><?php _e("Theme Style", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_google_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_google_font"><i class="fa fa-google"></i><?php _e("Update google fonts", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_custom_font") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_custom_font"><i class="fa fa-text-height"></i><?php _e("Custom fonts", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_style_custom_css") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=theme_style_custom_css"><i class="fa fa-code"></i><?php _e("Custom css", ANPS_TEMPLATE_LANG); ?></a></li>
            </ul>
        </li>
        <li>
            <a class="has-submenu" <?php if (isset($_GET['sub_page']) && ( $_GET['sub_page'] == "options" || $_GET['sub_page'] == "options_page_setup" || $_GET['sub_page'] == "options_social_accounts" || $_GET['sub_page'] == "options_media" )) echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=options"><?php _e("General Settings", ANPS_TEMPLATE_LANG); ?></a>
            <ul class="envoo-admin-submenu">
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options"><i class="fa fa-columns"></i><?php _e("Page layout", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_page_setup") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_page_setup"><i class="fa fa-cog"></i><?php _e("Page setup", ANPS_TEMPLATE_LANG); ?></a></li>
                <li><a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "options_media") echo 'id="selected-menu-subitem"'; ?> href="themes.php?page=theme_options&sub_page=options_media"><i class="fa fa-picture-o"></i><?php _e("Logos & Media", ANPS_TEMPLATE_LANG); ?></a></li>
            </ul>
        </li>
        <li>
            <a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "dummy_content") 
                        echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=dummy_content"><i class="fa fa-dropbox"></i><?php _e("Dummy Content", ANPS_TEMPLATE_LANG); ?></a>
        </li>
        <li>
            <a <?php if (isset($_GET['sub_page']) && $_GET['sub_page'] == "theme_upgrade") 
                        echo 'id="selected-menu-item"'; ?> href="themes.php?page=theme_options&sub_page=theme_upgrade"><i class="fa fa-cloud-download"></i><?php _e("Theme upgrade", ANPS_TEMPLATE_LANG); ?></a>
        </li>
    </ul>  
        <?php
        if(!isset($_GET['sub_page'])) {
            $_GET['sub_page']='';
        }
        ?>
        <div class="envoo-admin-content <?php echo esc_attr($_GET['sub_page']);?>">
        <?php
        switch($_GET['sub_page']) {
            case 'options': include_once 'options_page_view.php'; break;
            case 'options_page': include_once 'options_page_view.php'; break;
            case 'options_page_setup': include_once 'options_page_setup_view.php'; break;
            case 'options_media': include_once 'options_media_view.php'; break;
            case 'dummy_content': include_once 'dummy_view.php'; break;
            case 'theme_upgrade': include_once 'theme_upgrade_view.php'; break;
            case 'theme_style_google_font': include_once 'update_google_font_view.php'; break;
            case 'theme_style_custom_font': include_once 'update_custom_font_view.php'; break;
            case 'theme_style_custom_css': include_once 'custom_css_view.php'; break;
            default: include_once 'style_view.php';
        }
        ?>
    </div>
</div> 