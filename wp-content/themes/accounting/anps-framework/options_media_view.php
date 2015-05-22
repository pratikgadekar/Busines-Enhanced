<?php
include_once 'classes/Options.php';
$anps_media_data = $options->get_media();
if (isset($_GET['save_media'])) {
    $options->save_media(); 
}
?>
<form action="themes.php?page=theme_options&sub_page=options_media&save_media" method="post">
    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>
    <div class="content-inner">
        <h3><?php _e("Heading background:", ANPS_TEMPLATE_LANG); ?></h3>
        <!-- Heading background -->
        <div class="input floatleft onehalf">
            <label for="heading_bg"><?php _e("Page heading background", ANPS_TEMPLATE_LANG); ?></label>
            <input id="heading_bg" type="text" size="36" name="heading_bg" value="<?php echo esc_attr($anps_media_data['heading_bg']); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php _e("Enter an URL or upload an image for the page heading background.", ANPS_TEMPLATE_LANG); ?></p>
            <div class="clear"></div>
        </div>
        <!-- Search heading background -->
        <div class="input onehalf">
            <label for="search_heading_bg"><?php _e("Search page heading background", ANPS_TEMPLATE_LANG); ?></label>
            <input id="search_heading_bg" type="text" size="36" name="search_heading_bg" value="<?php echo esc_attr($anps_media_data['search_heading_bg']); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php _e("Enter an URL or upload an image for the search page heading background.", ANPS_TEMPLATE_LANG); ?></p>
            <div class="clear"></div>
        </div>
        <hr>
        <h3><?php _e("Favicon and logo:", ANPS_TEMPLATE_LANG); ?></h3>
        <p><?php _e("If you would like to use your logo and favicon, upload them to your theme here.", ANPS_TEMPLATE_LANG); ?></p>

        <!-- Logo -->
        <div class="input onehalf floatleft">
            <label for="logo"><?php _e("Logo", ANPS_TEMPLATE_LANG); ?></label>
            <?php
                $logo_width = 158;
                $logo_height = 33;

                if( $anps_media_data['logo-width'] ) {
                    $logo_width = $anps_media_data['logo-width'];
                }
                
                if( $anps_media_data['logo-height'] ) {
                    $logo_height = $anps_media_data['logo-height'];
                }

                if(isset($anps_media_data['logo'])):
            ?>
            <div class="preview"><img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo esc_attr($anps_media_data['logo']); ?>"></div>
        <?php endif; ?>
            <input id="logo" type="text" size="36" name="logo" value="<?php echo esc_attr($anps_media_data['logo']); ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php _e("Enter an URL or upload an image for the logo.", ANPS_TEMPLATE_LANG); ?></p>
        
            <div class="input fullwidth" style="min-height:0;">
                <?php
                if(get_option('auto_adjust_logo', 'on')=="on") {
                    $checked='checked';
                } else {
                    $checked = '';
                }
                ?>
                <label class="onehalf floatleft" for="auto_adjust_logo"><?php _e("Auto adjust logo size?", ANPS_TEMPLATE_LANG); ?></label>
                <div class="onehalf floatleft last" style="text-align:left; margin-top: 3px;">
                    <input id="auto_adjust_logo" class="small_input" style="margin-left: 0px; margin-top: 10px;" type="checkbox" name="auto_adjust_logo" <?php echo $checked; ?> />
                </div>
            </div>

            <div class="input onehalf floatleft first addspace onoff">
                <label for="logo-width"><?php _e("Logo width", ANPS_TEMPLATE_LANG); ?></label>
                <input style="width: 100px;" id="logo-width" type="text" name="logo-width" value="<?php echo esc_attr($logo_width); ?>" /> px
            </div>

            <div class="input onehalf floatleft last addspace onoff">
                <label for="logo-height"><?php _e("Logo height", ANPS_TEMPLATE_LANG); ?></label>
                <input style="width: 100px;" id="logo-height" type="text" name="logo-height" value="<?php echo esc_attr($logo_height); ?>" /> px
            </div>
        </div>
        <!-- Sticky logo -->
        <div class="input onehalf stickylogo">
            <label for="sticky_logo"><?php _e("Sticky logo", ANPS_TEMPLATE_LANG); ?></label>
            <?php if(isset($anps_media_data['sticky_logo'])): ?>
            <div class="preview onehalf"><img width="<?php echo esc_attr($logo_width); ?>" height="<?php echo esc_attr($logo_height); ?>" src="<?php echo esc_url($anps_media_data['sticky_logo']); ?>"></div>
            <?php endif; ?>
            <input class="wninety" id="sticky_logo" type="text" size="36" name="sticky_logo" value="<?php if(isset($anps_media_data['sticky_logo'])) { echo esc_attr($anps_media_data['sticky_logo']); } ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p clasS="fullwidth"><?php _e("Enter an URL or upload an image for the logo.", ANPS_TEMPLATE_LANG); ?></p>   
        </div>
        <div class="clear"></div>
        <hr>
                <!-- Favicon -->
        <div class="input onehalf">
            <label for="favicon"><?php _e("Favicon", ANPS_TEMPLATE_LANG); ?></label>
            <?php if(isset($anps_media_data['favicon'])&&$anps_media_data['favicon']!=""): ?>
            <div class="preview"><img src="<?php echo esc_url($anps_media_data['favicon']); ?>"></div>
            <?php endif; ?>
            <input id="favicon" type="text" size="36" name="favicon" value="<?php if(isset($anps_media_data['favicon'])) { echo esc_attr($anps_media_data['favicon']); } ?>" />
            <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            <p class="fullwidth"><?php _e("Enter an URL or upload an image for the favicon.", ANPS_TEMPLATE_LANG); ?></p>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
        <div class="clear"></div>
    </div>
</form>
<?php wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', get_template_directory_uri() . 'anps-framework/upload_image.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
    wp_enqueue_style('thickbox');