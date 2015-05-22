<?php 
if (isset($_GET['save_css'])) {
    update_option("anps_custom_css", $_POST['anps_custom_css']);
    header("Location: themes.php?page=theme_options&sub_page=theme_style_custom_css");
}
?>
<form action="themes.php?page=theme_options&sub_page=theme_style_custom_css&save_css" method="post">
    <div class="content-inner">
        <h3><?php _e("Custom css", ANPS_TEMPLATE_LANG); ?></h3>    
        <div class="input fullwidth">
        <label for="anps_custom_css"><?php _e("Custom css", ANPS_TEMPLATE_LANG); ?></label>
        <textarea name="anps_custom_css" id="anps_custom_css" class="fullwidth"><?php echo get_option('anps_custom_css', ''); ?> </textarea>    
        </div>
    </div>
    <div class="content-top" style="border-style: solid none; margin-top: 70px">        
        <input type="submit" value="<?php _e("Save all changes", ANPS_TEMPLATE_LANG); ?>">        
        <div class="clear"></div>    
    </div>
</form>