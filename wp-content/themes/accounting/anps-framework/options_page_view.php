<?php
include_once 'classes/Options.php';

$anps_options_data = $options->get_page_data();  
if (isset($_GET['save_page']))
  $options->save_page();
?>
<form action="themes.php?page=theme_options&sub_page=options_page&save_page" method="post">

    <div class="content-top"><input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>" /><div class="clear"></div></div>

    <div class="content-inner">
        <!-- Page layout -->
        <h3><?php _e("Page layout:", ANPS_TEMPLATE_LANG); ?></h3>
        <p><?php _e("Here you can change all the settings about responsive layout and will your site be boxed (when checked you will have more options).", ANPS_TEMPLATE_LANG); ?></p>        
        <div class="info">
            <!-- Hide slider on mobile -->
            <div class="input onoffswitch fullwidth floatleft">
                <label class="onehalf floatleft" for="hide_slider_on_mobile"><?php _e("Hide slider on mobile", "michell"); ?></label>
                <input type="checkbox" name="hide_slider_on_mobile" class="onoffswitch-checkbox onehalf floatright" id="hide_slider_on_mobile" <?php if(!isset($anps_options_data['hide_slider_on_mobile'])) {echo '';}elseif ($anps_options_data['hide_slider_on_mobile'] == '-1') {echo '';}elseif ($anps_options_data['hide_slider_on_mobile'] == '') {echo '';}else {echo 'checked';} ?>>
               <label class="onoffswitch-label" for="hide_slider_on_mobile">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- Boxed -->
            <?php
            if(!isset($anps_options_data['boxed']))
                $checked='';
            elseif ($anps_options_data['boxed'] == '-1')
                $checked = '';
            elseif ($anps_options_data['boxed'] == '')
                $checked = '';
            else
                $checked = 'checked';
            ?>
            <div class="input onoffswitch fullwidth floatleft">
                <label class="onehalf floatleft" for="boxed"><?php _e("Boxed", ANPS_TEMPLATE_LANG); ?></label>
                <input id="is-boxed" class="onoffswitch-checkbox onehalf floatright" style="margin-left: 74px" type="checkbox" name="boxed" <?php if(!isset($anps_options_data['boxed'])){echo '';}elseif ($anps_options_data['boxed'] == '-1'){echo '';}elseif ($anps_options_data['boxed'] == ''){echo '';}else{echo 'checked';} ?> />
                <label class="onoffswitch-label" for="is-boxed">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- Pattern -->
            <div <?php if ($checked == "") echo 'style="display:none"'; ?> class="input fullwidth" id="pattern-select-wrapper">
                <label for="pattern"><?php _e("Pattern", ANPS_TEMPLATE_LANG); ?></label>
                <div class="admin-patern-radio">
                    <?php for ($i = 0; $i < 10; $i++) :                       
                        ?>
                        <input type="radio" name="pattern" value="<?php echo esc_attr($i); ?>" <?php if ($anps_options_data['pattern'] == $i){echo 'checked';}else{echo '';} ?>/>
                    <?php endfor; ?>
                </div>
                <div class="admin-patern-select fullwidth">
                    <?php for ($i = 0; $i < 10; $i++) : ?>
                        <?php if ($anps_options_data['pattern'] == $i): ?>
                            <img id="selected-pattern" src="<?php echo get_stylesheet_directory_uri(); ?>/css/boxed/pattern-<?php echo esc_attr($i); ?>.png" />
                        <?php else: ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/css/boxed/pattern-<?php echo esc_attr($i); ?>.png" />
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div style="clear: both"></div>
            </div>
            <!-- Custom background -->
            <div class="input fullwidth" <?php if (!isset($anps_options_data['boxed']) || $anps_options_data['pattern'] != 0 || $anps_options_data['boxed'] == '-1' || $anps_options_data['boxed'] == '') echo 'style="display: none"'; ?> id="patern-type-wrapper">
                <label for="pattern"><?php _e("Custom background type", ANPS_TEMPLATE_LANG); ?></label>
                <div class="patern-type">
                    <?php $types = array('stretched', 'tilled', 'custom color');
                    foreach ($types as $type) :
                        if(!isset($anps_options_data['type']))
                            $checked='';
                        elseif ($anps_options_data['type'] == $type)
                            $checked = 'checked';
                        else
                            $checked = '';
                        ?>
                    <span class="onethird">
                        <input style="display: inline-block;" type="radio" id="back-type-<?php echo esc_attr($type); ?>" name="type" value="<?php echo esc_attr($type); ?>" <?php echo $checked; ?>/>
                        <label style="font-weight: normal;display: inline; margin: 0; cursor: pointer" for="back-type-<?php echo esc_attr($type); ?>"><?php echo esc_attr($type); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Custom pattern -->
            <div class="input fullwidth"  <?php if ((!isset($anps_options_data['boxed']) || $anps_options_data['pattern'] != 0 || $anps_options_data['boxed'] == '-1' || $anps_options_data['boxed'] == '') || ($anps_options_data['type'] != "stretched") && $anps_options_data['type'] != "tilled" ) echo 'style="display: none"'; ?> id="custom-patern-wrapper">
                <label for="custom_pattern"><?php _e("Custom background image/pattern", ANPS_TEMPLATE_LANG); ?></label>
                <input class="wninety" id="custom_pattern" type="text" size="36" name="custom_pattern" value="<?php echo esc_attr($anps_options_data['custom_pattern']); ?>" />
                <input id="_btn" class="upload_image_button" type="button" value="Upload" />
            </div>
            <!-- Custom background color -->

            <div id="custom-background-color-wrapper" class="input" <?php if ((!isset($anps_options_data['boxed']) || $anps_options_data['pattern'] != 0 || $anps_options_data['boxed'] == '-1' || $anps_options_data['boxed'] == '') || (!isset($anps_options_data['type']) || $anps_options_data['type'] != "custom color") ) echo 'style="display: none"'; ?>>
                <label for="bg_color"><?php _e("Custom background color", ANPS_TEMPLATE_LANG); ?></label>
                <input data-value="<?php echo esc_attr($anps_options_data['bg_color']); ?>" readonly style="background: <?php echo esc_attr($anps_options_data['bg_color']); ?>" class="color-pick-color"><input class="color-pick" type="text" name="bg_color" value="<?php echo esc_attr($anps_options_data['bg_color']); ?>" id="bg_color" />
            </div>
    </div>
        <div class="clear"></div>
        <h3><?php _e("Heading", ANPS_TEMPLATE_LANG); ?></h3>
        <!-- Disable page title, breadcrumbs and background -->
            <div class="input onoffswitch fullwidth floatleft">
                <label class="onehalf floatleft" for="disable_heading"><?php _e("Disable page title, breadcrumbs and background", ANPS_TEMPLATE_LANG); ?></label>
                <input class="onoffswitch-checkbox onehalf floatright" style="margin-left: 117px" type="checkbox" id="disable_heading" name="disable_heading" <?php if(!isset($anps_options_data['disable_heading'])){echo '';}elseif ($anps_options_data['disable_heading'] == '-1'){echo '';}elseif ($anps_options_data['disable_heading'] == ''){echo '';}else{echo 'checked';} ?> />
                <label class="onoffswitch-label" for="disable_heading">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- END Disable page title, breadcrumbs and background --> 
            <!-- Breadcrumbs disable -->
            <div class="input onoffswitch fullwidth floatleft">
                <label class="onehalf floatleft" for="breadcrumbs"><?php _e("Disable breadcrumbs", ANPS_TEMPLATE_LANG); ?></label>
                <input class="onoffswitch-checkbox onehalf floatright" style="margin-left: 63px" type="checkbox" id="breadcrumbs" name="breadcrumbs" <?php if(!isset($anps_options_data['breadcrumbs'])) {echo '';}elseif ($anps_options_data['breadcrumbs'] == '-1'){echo '';}elseif ($anps_options_data['breadcrumbs'] == ''){echo '';}else{echo 'checked';} ?> />
                <label class="onoffswitch-label" for="breadcrumbs">
                   <span class="onoffswitch-inner">
                   <span class="onoffswitch-active"><span class="onoffswitch-switch">ON</span></span>
                   <span class="onoffswitch-inactive"><span class="onoffswitch-switch">OFF</span></span>
                   </span>
               </label>
            </div>
            <!-- END Breadcrumbs disable --> 
            <div class="clear"></div>
    <h3><?php _e("Mobile layout", ANPS_TEMPLATE_LANG); ?></h3>

             <select name="footer_columns">
                    <option value="0">*** Select ***</option>
                    <?php 
                            $pages = array("1"=>"1 column" ,"2"=>"2 columns"); 
                            foreach ($pages as $key=>$item) :                                    
                    ?>      <option value="<?php echo esc_attr($key); ?>" <?php if (isset($anps_options_data['footer_columns']) && $anps_options_data['footer_columns']==$key) {echo 'selected="selected"';}else {echo '';} ?>><?php echo esc_html($item); ?></option>                 
                    <?php endforeach; ?>            
            </select>        
            <div class="clear"></div>

</div>

<div class="content-top" style="border-style: solid none; margin-top: 70px">
    <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">
    <div class="clear"></div>
</div>
</form>


<?php
    if (isset($_GET['save_page'])) {
      //update_option("rtl", $_POST['rtl']);
    }
?>