<?php

class AnpsDownload extends WP_Widget {

    public function __construct() {    
        parent::__construct(
            'AnpsDownload', 'AnpsThemes - Download', array('description' => __('Choose a image to show on page', ANPS_TEMPLATE_LANG),)
        );
        add_action( 'admin_enqueue_scripts', array( $this, 'anps_enqueue_scripts' ) );
        add_action( 'admin_footer-widgets.php', array( $this, 'anps_print_scripts' ), 9999 );
    }
    
    function anps_enqueue_scripts( $hook_suffix ) {
        wp_enqueue_style('wp-color-picker');        
        wp_enqueue_script('wp-color-picker');
    }
    
    function anps_print_scripts() {
            ?>
            <script>
                    ( function( $ ){
                            function initColorPicker( widget ) {
                                    widget.find( '.anps-color-picker' ).wpColorPicker( {
                                            change: _.throttle( function() { // For Customizer
                                                    $(this).trigger( 'change' );
                                            }, 3000 )
                                    });
                            }

                            function onFormUpdate( event, widget ) {
                                    initColorPicker( widget );
                            }

                            $( document ).on( 'widget-added widget-updated', onFormUpdate );

                            $( document ).ready( function() {
                                    $( '#widgets-right .widget:has(.anps-color-picker)' ).each( function () {
                                            initColorPicker( $( this ) );
                                    } );
                            } );
                    }( jQuery ) );
            </script>
            <?php
    }

    function form($instance) {       
        $instance = wp_parse_args((array) $instance, array('title' => '', 'file' => '', 'file_title' => '', 'icon'=>'', 'icon_color'=>'', 'bg_color'=>'', 'file_external'=>''));

        $file = $instance['file'];
        $file_external = $instance['file_external'];
        $title = $instance['title'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        $icon_color = $instance['icon_color'];
        $bg_color = $instance['bg_color'];
        ?>
        <!-- Widget title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title", ANPS_TEMPLATE_LANG); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <!-- File title -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_title')); ?>"><?php _e("File title", ANPS_TEMPLATE_LANG); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_title')); ?>" name="<?php echo esc_attr($this->get_field_name('file_title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_title']); ?>" />
        </p>
        <!-- File -->
        <p>
            <?php $files = get_children('post_type=attachment'); ?>
            <label for="<?php echo esc_attr($this->get_field_id('file')); ?>"><?php _e("File", ANPS_TEMPLATE_LANG); ?></label><br />
            <select id="<?php echo esc_attr($this->get_field_id('file')); ?>" name="<?php echo esc_attr($this->get_field_name('file')); ?>">
                <option value=""><?php _e("Select a file", ANPS_TEMPLATE_LANG); ?></option>
                <?php foreach ($files as $item) : ?>
                    <option <?php if ($item->guid == $file) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item->guid); ?>"><?php echo esc_html($item->post_title); ?></option>
            <?php endforeach; ?>
            </select>        
        </p>
        <!-- Icon -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php _e("Icon", ANPS_TEMPLATE_LANG); ?></label><br />
            <select id="<?php echo esc_attr($this->get_field_id('icon')); ?>" name="<?php echo esc_attr($this->get_field_name('icon')); ?>" style="font-family: FontAwesome;">
                <option value=""><?php _e("Select an icon", ANPS_TEMPLATE_LANG); ?></option>         
                <?php foreach ($this->font_awesome() as $value=>$item) : ?>
                    <option <?php if ($item == $icon) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item); ?>"><?php echo esc_attr($value); ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <!-- Icon color -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon_color')); ?>"><?php _e("Icon color", ANPS_TEMPLATE_LANG); ?></label><br />
            <input class="anps-color-picker" id="<?php echo esc_attr($this->get_field_id('icon_color')); ?>" name="<?php echo esc_attr($this->get_field_name('icon_color')); ?>" type="text" value="<?php echo esc_attr($instance['icon_color']); ?>" />
        </p>

        <!-- File external -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('file_external')); ?>"><?php _e("File external", ANPS_TEMPLATE_LANG); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('file_external')); ?>" name="<?php echo esc_attr($this->get_field_name('file_external')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['file_external']); ?>" />
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['file'] = $new_instance['file'];
        $instance['file_external'] = $new_instance['file_external'];
        $instance['title'] = $new_instance['title'];
        $instance['file_title'] = $new_instance['file_title'];
        $instance['icon'] = $new_instance['icon'];
        $instance['icon_color'] = $new_instance['icon_color'];
        $instance['bg_color'] = $new_instance['bg_color'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $title = $instance['title'];
        $file = $instance['file'];
        $file_external = $instance['file_external'];
        $file_title = $instance['file_title'];
        $icon = $instance['icon'];
        $icon_color = $instance['icon_color'];
        $bg_color = $instance['bg_color'];
        if($file) {
            $file_url = $file;
        } elseif($file_external) {
            $file_url = $file_external;
        } else {
            $file_url = "#";
        }
        echo $before_widget;
        ?>

        <?php if($title) : ?>
            <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
            <div class="anps_download">
                <a href="<?php echo esc_url($file_url); ?>" target="_blank">
                    <div class="vertical-align-wrapper">
                    <span class="anps_download_icon"><i class="fa fa-<?php echo esc_attr($icon); ?>" style="color: <?php echo esc_attr($icon_color); ?>"></i></span><span class="download-title"><?php echo esc_html($file_title); ?></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        <?php
        echo $after_widget;
    }
    
    function font_awesome() {
        $icon_array = array(
            html_entity_decode("&#xf042; ") . __("Adjust", ANPS_TEMPLATE_LANG)=>"adjust",
            html_entity_decode("&#xf170; ") . __("Adn", ANPS_TEMPLATE_LANG)=>"adn",
            html_entity_decode("&#xf037; ") . __("Align center", ANPS_TEMPLATE_LANG)=>"align-center",
            html_entity_decode("&#xf039; ") . __("Align justify", ANPS_TEMPLATE_LANG)=>"align-justify",
            html_entity_decode("&#xf036; ") . __("Align left", ANPS_TEMPLATE_LANG)=>"align-left",
            html_entity_decode("&#xf038; ") . __("Align right", ANPS_TEMPLATE_LANG)=>"align-right",
            html_entity_decode("&#xf0f9; ") . __("Ambulance", ANPS_TEMPLATE_LANG)=>"ambulance",
            html_entity_decode("&#xf13d; ") . __("Anchor", ANPS_TEMPLATE_LANG)=>"anchor",
            html_entity_decode("&#xf17b; ") . __("Android", ANPS_TEMPLATE_LANG)=>"android",
            html_entity_decode("&#xf103; ") . __("Angle double down", ANPS_TEMPLATE_LANG)=>"angle-double-down",
            html_entity_decode("&#xf100; ") . __("Angle double left", ANPS_TEMPLATE_LANG)=>"angle-double-left",
            html_entity_decode("&#xf101; ") . __("Angle double right", ANPS_TEMPLATE_LANG)=>"angle-double-right",
            html_entity_decode("&#xf102; ") . __("Angle double up", ANPS_TEMPLATE_LANG)=>"angle-double-up",
            html_entity_decode("&#xf107; ") . __("Angle down", ANPS_TEMPLATE_LANG)=>"angle-down",
            html_entity_decode("&#xf104; ") . __("Angle left", ANPS_TEMPLATE_LANG)=>"angle-left",
            html_entity_decode("&#xf105; ") . __("Angle right", ANPS_TEMPLATE_LANG)=>"angle-right",
            html_entity_decode("&#xf106; ") . __("Angle up", ANPS_TEMPLATE_LANG)=>"angle-up",
            html_entity_decode("&#xf179; ") . __("Apple", ANPS_TEMPLATE_LANG)=>"apple",
            html_entity_decode("&#xf187; ") . __("Archive", ANPS_TEMPLATE_LANG)=>"archive",
            html_entity_decode("&#xf0ab; ") . __("Arrow circle down", ANPS_TEMPLATE_LANG)=>"arrow-circle-down",
            html_entity_decode("&#xf0a8; ") . __("Arrow circle left", ANPS_TEMPLATE_LANG)=>"arrow-circle-left",
            html_entity_decode("&#xf01a; ") . __("Arrow circle outlined down", ANPS_TEMPLATE_LANG)=>"arrow-circle-o-down",
            html_entity_decode("&#xf190; ") . __("Arrow circle outlined left", ANPS_TEMPLATE_LANG)=>"arrow-circle-o-left",
            html_entity_decode("&#xf18e; ") . __("Arrow circle outlined right", ANPS_TEMPLATE_LANG)=>"arrow-circle-o-right",
            html_entity_decode("&#xf01b; ") . __("Arrow circle outlined up", ANPS_TEMPLATE_LANG)=>"arrow-circle-o-up",
            html_entity_decode("&#xf0a9; ") . __("Arrow circle right", ANPS_TEMPLATE_LANG)=>"arrow-circle-right",
            html_entity_decode("&#xf0aa; ") . __("Arrow circle up", ANPS_TEMPLATE_LANG)=>"arrow-circle-up",
            html_entity_decode("&#xf063; ") . __("Arrow down", ANPS_TEMPLATE_LANG)=>"arrow-down",
            html_entity_decode("&#xf060; ") . __("Arrow left", ANPS_TEMPLATE_LANG)=>"arrow-left",
            html_entity_decode("&#xf061; ") . __("Arrow right", ANPS_TEMPLATE_LANG)=>"arrow-right",
            html_entity_decode("&#xf062; ") . __("Arrow up", ANPS_TEMPLATE_LANG)=>"arrow-up",
            html_entity_decode("&#xf047; ") . __("Arrows", ANPS_TEMPLATE_LANG)=>"arrows",
            html_entity_decode("&#xf0b2; ") . __("Arrows alt", ANPS_TEMPLATE_LANG)=>"arrows-alt",
            html_entity_decode("&#xf07e; ") . __("Arrows h", ANPS_TEMPLATE_LANG)=>"arrows-h",
            html_entity_decode("&#xf07d; ") . __("Arrows v", ANPS_TEMPLATE_LANG)=>"arrows-v",
            html_entity_decode("&#xf069; ") . __("Asterisk", ANPS_TEMPLATE_LANG)=>"asterisk",
            html_entity_decode("&#xf1b9; ") . __("Automobile ", ANPS_TEMPLATE_LANG)=>"automobile ",
            html_entity_decode("&#xf04a; ") . __("Backward", ANPS_TEMPLATE_LANG)=>"backward",
            html_entity_decode("&#xf05e; ") . __("Ban", ANPS_TEMPLATE_LANG)=>"ban",
            html_entity_decode("&#xf19c; ") . __("Bank ", ANPS_TEMPLATE_LANG)=>"bank ",
            html_entity_decode("&#xf080; ") . __("Bar chart outlined", ANPS_TEMPLATE_LANG)=>"bar-chart-o",
            html_entity_decode("&#xf02a; ") . __("Barcode", ANPS_TEMPLATE_LANG)=>"barcode",
            html_entity_decode("&#xf0c9; ") . __("Bars", ANPS_TEMPLATE_LANG)=>"bars",
            html_entity_decode("&#xf0fc; ") . __("Beer", ANPS_TEMPLATE_LANG)=>"beer",
            html_entity_decode("&#xf1b4; ") . __("Behance", ANPS_TEMPLATE_LANG)=>"behance",
            html_entity_decode("&#xf1b5; ") . __("Behance square", ANPS_TEMPLATE_LANG)=>"behance-square",
            html_entity_decode("&#xf0f3; ") . __("Bell", ANPS_TEMPLATE_LANG)=>"bell",
            html_entity_decode("&#xf0a2; ") . __("Bell outlined", ANPS_TEMPLATE_LANG)=>"bell-o",
            html_entity_decode("&#xf171; ") . __("Bitbucket", ANPS_TEMPLATE_LANG)=>"bitbucket",
            html_entity_decode("&#xf172; ") . __("Bitbucket square", ANPS_TEMPLATE_LANG)=>"bitbucket-square",
            html_entity_decode("&#xf15a; ") . __("Bitcoin ", ANPS_TEMPLATE_LANG)=>"bitcoin ",
            html_entity_decode("&#xf032; ") . __("Bold", ANPS_TEMPLATE_LANG)=>"bold",
            html_entity_decode("&#xf0e7; ") . __("Bolt", ANPS_TEMPLATE_LANG)=>"bolt",
            html_entity_decode("&#xf1e2; ") . __("Bomb", ANPS_TEMPLATE_LANG)=>"bomb",
            html_entity_decode("&#xf02d; ") . __("Book", ANPS_TEMPLATE_LANG)=>"book",
            html_entity_decode("&#xf02e; ") . __("Bookmark", ANPS_TEMPLATE_LANG)=>"bookmark",
            html_entity_decode("&#xf097; ") . __("Bookmark outlined", ANPS_TEMPLATE_LANG)=>"bookmark-o",
            html_entity_decode("&#xf0b1; ") . __("Briefcase", ANPS_TEMPLATE_LANG)=>"briefcase",
            html_entity_decode("&#xf15a; ") . __("Btc", ANPS_TEMPLATE_LANG)=>"btc",
            html_entity_decode("&#xf188; ") . __("Bug", ANPS_TEMPLATE_LANG)=>"bug",
            html_entity_decode("&#xf1ad; ") . __("Building", ANPS_TEMPLATE_LANG)=>"building",
            html_entity_decode("&#xf0f7; ") . __("Building outlined", ANPS_TEMPLATE_LANG)=>"building-o",
            html_entity_decode("&#xf0a1; ") . __("Bullhorn", ANPS_TEMPLATE_LANG)=>"bullhorn",
            html_entity_decode("&#xf140; ") . __("Bullseye", ANPS_TEMPLATE_LANG)=>"bullseye",
            html_entity_decode("&#xf1ba; ") . __("Cab ", ANPS_TEMPLATE_LANG)=>"cab ",
            html_entity_decode("&#xf073; ") . __("Calendar", ANPS_TEMPLATE_LANG)=>"calendar",
            html_entity_decode("&#xf133; ") . __("Calendar outlined", ANPS_TEMPLATE_LANG)=>"calendar-o",
            html_entity_decode("&#xf030; ") . __("Camera", ANPS_TEMPLATE_LANG)=>"camera",
            html_entity_decode("&#xf083; ") . __("Camera retro", ANPS_TEMPLATE_LANG)=>"camera-retro",
            html_entity_decode("&#xf1b9; ") . __("Car", ANPS_TEMPLATE_LANG)=>"car",
            html_entity_decode("&#xf0d7; ") . __("Caret down", ANPS_TEMPLATE_LANG)=>"caret-down",
            html_entity_decode("&#xf0d9; ") . __("Caret left", ANPS_TEMPLATE_LANG)=>"caret-left",
            html_entity_decode("&#xf0da; ") . __("Caret right", ANPS_TEMPLATE_LANG)=>"caret-right",
            html_entity_decode("&#xf150; ") . __("Caret square outlined down", ANPS_TEMPLATE_LANG)=>"caret-square-o-down",
            html_entity_decode("&#xf191; ") . __("Caret square outlined left", ANPS_TEMPLATE_LANG)=>"caret-square-o-left",
            html_entity_decode("&#xf152; ") . __("Caret square outlined right", ANPS_TEMPLATE_LANG)=>"caret-square-o-right",
            html_entity_decode("&#xf151; ") . __("Caret square outlined up", ANPS_TEMPLATE_LANG)=>"caret-square-o-up",
            html_entity_decode("&#xf0d8; ") . __("Caret up", ANPS_TEMPLATE_LANG)=>"caret-up",
            html_entity_decode("&#xf0a3; ") . __("Certificate", ANPS_TEMPLATE_LANG)=>"certificate",
            html_entity_decode("&#xf0c1; ") . __("Chain ", ANPS_TEMPLATE_LANG)=>"chain ",
            html_entity_decode("&#xf127; ") . __("Chain broken", ANPS_TEMPLATE_LANG)=>"chain-broken",
            html_entity_decode("&#xf00c; ") . __("Check", ANPS_TEMPLATE_LANG)=>"check",
            html_entity_decode("&#xf058; ") . __("Check circle", ANPS_TEMPLATE_LANG)=>"check-circle",
            html_entity_decode("&#xf05d; ") . __("Check circle outlined", ANPS_TEMPLATE_LANG)=>"check-circle-o",
            html_entity_decode("&#xf14a; ") . __("Check square", ANPS_TEMPLATE_LANG)=>"check-square",
            html_entity_decode("&#xf046; ") . __("Check square outlined", ANPS_TEMPLATE_LANG)=>"check-square-o",
            html_entity_decode("&#xf13a; ") . __("Chevron circle down", ANPS_TEMPLATE_LANG)=>"chevron-circle-down",
            html_entity_decode("&#xf137; ") . __("Chevron circle left", ANPS_TEMPLATE_LANG)=>"chevron-circle-left",
            html_entity_decode("&#xf138; ") . __("Chevron circle right", ANPS_TEMPLATE_LANG)=>"chevron-circle-right",
            html_entity_decode("&#xf139; ") . __("Chevron circle up", ANPS_TEMPLATE_LANG)=>"chevron-circle-up",
            html_entity_decode("&#xf078; ") . __("Chevron down", ANPS_TEMPLATE_LANG)=>"chevron-down",
            html_entity_decode("&#xf053; ") . __("Chevron left", ANPS_TEMPLATE_LANG)=>"chevron-left",
            html_entity_decode("&#xf054; ") . __("Chevron right", ANPS_TEMPLATE_LANG)=>"chevron-right",
            html_entity_decode("&#xf077; ") . __("Chevron up", ANPS_TEMPLATE_LANG)=>"chevron-up",
            html_entity_decode("&#xf1ae; ") . __("Child", ANPS_TEMPLATE_LANG)=>"child",
            html_entity_decode("&#xf111; ") . __("Circle", ANPS_TEMPLATE_LANG)=>"circle",
            html_entity_decode("&#xf10c; ") . __("Circle outlined", ANPS_TEMPLATE_LANG)=>"circle-o",
            html_entity_decode("&#xf1ce; ") . __("Circle outlined notch", ANPS_TEMPLATE_LANG)=>"circle-o-notch",
            html_entity_decode("&#xf1db; ") . __("Circle thin", ANPS_TEMPLATE_LANG)=>"circle-thin",
            html_entity_decode("&#xf0ea; ") . __("Clipboard", ANPS_TEMPLATE_LANG)=>"clipboard",
            html_entity_decode("&#xf017; ") . __("Clock outlined", ANPS_TEMPLATE_LANG)=>"clock-o",
            html_entity_decode("&#xf0c2; ") . __("Cloud", ANPS_TEMPLATE_LANG)=>"cloud",
            html_entity_decode("&#xf0ed; ") . __("Cloud download", ANPS_TEMPLATE_LANG)=>"cloud-download",
            html_entity_decode("&#xf0ee; ") . __("Cloud upload", ANPS_TEMPLATE_LANG)=>"cloud-upload",
            html_entity_decode("&#xf157; ") . __("Cny ", ANPS_TEMPLATE_LANG)=>"cny ",
            html_entity_decode("&#xf121; ") . __("Code", ANPS_TEMPLATE_LANG)=>"code",
            html_entity_decode("&#xf126; ") . __("Code fork", ANPS_TEMPLATE_LANG)=>"code-fork",
            html_entity_decode("&#xf1cb; ") . __("Codepen", ANPS_TEMPLATE_LANG)=>"codepen",
            html_entity_decode("&#xf0f4; ") . __("Coffee", ANPS_TEMPLATE_LANG)=>"coffee",
            html_entity_decode("&#xf013; ") . __("Cog", ANPS_TEMPLATE_LANG)=>"cog",
            html_entity_decode("&#xf085; ") . __("Cogs", ANPS_TEMPLATE_LANG)=>"cogs",
            html_entity_decode("&#xf0db; ") . __("Columns", ANPS_TEMPLATE_LANG)=>"columns",
            html_entity_decode("&#xf075; ") . __("Comment", ANPS_TEMPLATE_LANG)=>"comment",
            html_entity_decode("&#xf0e5; ") . __("Comment outlined", ANPS_TEMPLATE_LANG)=>"comment-o",
            html_entity_decode("&#xf086; ") . __("Comments", ANPS_TEMPLATE_LANG)=>"comments",
            html_entity_decode("&#xf0e6; ") . __("Comments outlined", ANPS_TEMPLATE_LANG)=>"comments-o",
            html_entity_decode("&#xf14e; ") . __("Compass", ANPS_TEMPLATE_LANG)=>"compass",
            html_entity_decode("&#xf066; ") . __("Compress", ANPS_TEMPLATE_LANG)=>"compress",
            html_entity_decode("&#xf0c5; ") . __("Copy ", ANPS_TEMPLATE_LANG)=>"copy ",
            html_entity_decode("&#xf09d; ") . __("Credit card", ANPS_TEMPLATE_LANG)=>"credit-card",
            html_entity_decode("&#xf125; ") . __("Crop", ANPS_TEMPLATE_LANG)=>"crop",
            html_entity_decode("&#xf05b; ") . __("Crosshairs", ANPS_TEMPLATE_LANG)=>"crosshairs",
            html_entity_decode("&#xf13c; ") . __("Css3", ANPS_TEMPLATE_LANG)=>"css3",
            html_entity_decode("&#xf1b2; ") . __("Cube", ANPS_TEMPLATE_LANG)=>"cube",
            html_entity_decode("&#xf1b3; ") . __("Cubes", ANPS_TEMPLATE_LANG)=>"cubes",
            html_entity_decode("&#xf0c4; ") . __("Cut ", ANPS_TEMPLATE_LANG)=>"cut ",
            html_entity_decode("&#xf0f5; ") . __("Cutlery", ANPS_TEMPLATE_LANG)=>"cutlery",
            html_entity_decode("&#xf0e4; ") . __("Dashboard ", ANPS_TEMPLATE_LANG)=>"dashboard ",
            html_entity_decode("&#xf1c0; ") . __("Database", ANPS_TEMPLATE_LANG)=>"database",
            html_entity_decode("&#xf03b; ") . __("Dedent ", ANPS_TEMPLATE_LANG)=>"dedent ",
            html_entity_decode("&#xf1a5; ") . __("Delicious", ANPS_TEMPLATE_LANG)=>"delicious",
            html_entity_decode("&#xf108; ") . __("Desktop", ANPS_TEMPLATE_LANG)=>"desktop",
            html_entity_decode("&#xf1bd; ") . __("Deviantart", ANPS_TEMPLATE_LANG)=>"deviantart",
            html_entity_decode("&#xf1a6; ") . __("Digg", ANPS_TEMPLATE_LANG)=>"digg",
            html_entity_decode("&#xf155; ") . __("Dollar ", ANPS_TEMPLATE_LANG)=>"dollar ",
            html_entity_decode("&#xf192; ") . __("Dot circle outlined", ANPS_TEMPLATE_LANG)=>"dot-circle-o",
            html_entity_decode("&#xf019; ") . __("Download", ANPS_TEMPLATE_LANG)=>"download",
            html_entity_decode("&#xf17d; ") . __("Dribbble", ANPS_TEMPLATE_LANG)=>"dribbble",
            html_entity_decode("&#xf16b; ") . __("Dropbox", ANPS_TEMPLATE_LANG)=>"dropbox",
            html_entity_decode("&#xf1a9; ") . __("Drupal", ANPS_TEMPLATE_LANG)=>"drupal",
            html_entity_decode("&#xf044; ") . __("Edit ", ANPS_TEMPLATE_LANG)=>"edit ",
            html_entity_decode("&#xf052; ") . __("Eject", ANPS_TEMPLATE_LANG)=>"eject",
            html_entity_decode("&#xf141; ") . __("Ellipsis h", ANPS_TEMPLATE_LANG)=>"ellipsis-h",
            html_entity_decode("&#xf142; ") . __("Ellipsis v", ANPS_TEMPLATE_LANG)=>"ellipsis-v",
            html_entity_decode("&#xf1d1; ") . __("Empire", ANPS_TEMPLATE_LANG)=>"empire",
            html_entity_decode("&#xf0e0; ") . __("Envelope", ANPS_TEMPLATE_LANG)=>"envelope",
            html_entity_decode("&#xf003; ") . __("Envelope outlined", ANPS_TEMPLATE_LANG)=>"envelope-o",
            html_entity_decode("&#xf199; ") . __("Envelope square", ANPS_TEMPLATE_LANG)=>"envelope-square",
            html_entity_decode("&#xf12d; ") . __("Eraser", ANPS_TEMPLATE_LANG)=>"eraser",
            html_entity_decode("&#xf153; ") . __("Eur", ANPS_TEMPLATE_LANG)=>"eur",
            html_entity_decode("&#xf153; ") . __("Euro ", ANPS_TEMPLATE_LANG)=>"euro ",
            html_entity_decode("&#xf0ec; ") . __("Exchange", ANPS_TEMPLATE_LANG)=>"exchange",
            html_entity_decode("&#xf12a; ") . __("Exclamation", ANPS_TEMPLATE_LANG)=>"exclamation",
            html_entity_decode("&#xf06a; ") . __("Exclamation circle", ANPS_TEMPLATE_LANG)=>"exclamation-circle",
            html_entity_decode("&#xf071; ") . __("Exclamation triangle", ANPS_TEMPLATE_LANG)=>"exclamation-triangle",
            html_entity_decode("&#xf065; ") . __("Expand", ANPS_TEMPLATE_LANG)=>"expand",
            html_entity_decode("&#xf08e; ") . __("External link", ANPS_TEMPLATE_LANG)=>"external-link",
            html_entity_decode("&#xf14c; ") . __("External link square", ANPS_TEMPLATE_LANG)=>"external-link-square",
            html_entity_decode("&#xf06e; ") . __("Eye", ANPS_TEMPLATE_LANG)=>"eye",
            html_entity_decode("&#xf070; ") . __("Eye slash", ANPS_TEMPLATE_LANG)=>"eye-slash",
            html_entity_decode("&#xf09a; ") . __("Facebook", ANPS_TEMPLATE_LANG)=>"facebook",
            html_entity_decode("&#xf082; ") . __("Facebook square", ANPS_TEMPLATE_LANG)=>"facebook-square",
            html_entity_decode("&#xf049; ") . __("Fast backward", ANPS_TEMPLATE_LANG)=>"fast-backward",
            html_entity_decode("&#xf050; ") . __("Fast forward", ANPS_TEMPLATE_LANG)=>"fast-forward",
            html_entity_decode("&#xf1ac; ") . __("Fax", ANPS_TEMPLATE_LANG)=>"fax",
            html_entity_decode("&#xf182; ") . __("Female", ANPS_TEMPLATE_LANG)=>"female",
            html_entity_decode("&#xf0fb; ") . __("Fighter jet", ANPS_TEMPLATE_LANG)=>"fighter-jet",
            html_entity_decode("&#xf15b; ") . __("File", ANPS_TEMPLATE_LANG)=>"file",
            html_entity_decode("&#xf1c6; ") . __("File archive outlined", ANPS_TEMPLATE_LANG)=>"file-archive-o",
            html_entity_decode("&#xf1c7; ") . __("File audio outlined", ANPS_TEMPLATE_LANG)=>"file-audio-o",
            html_entity_decode("&#xf1c9; ") . __("File code outlined", ANPS_TEMPLATE_LANG)=>"file-code-o",
            html_entity_decode("&#xf1c3; ") . __("File excel outlined", ANPS_TEMPLATE_LANG)=>"file-excel-o",
            html_entity_decode("&#xf1c5; ") . __("File image outlined", ANPS_TEMPLATE_LANG)=>"file-image-o",
            html_entity_decode("&#xf1c8; ") . __("File movie o ", ANPS_TEMPLATE_LANG)=>"file-movie-o ",
            html_entity_decode("&#xf016; ") . __("File outlined", ANPS_TEMPLATE_LANG)=>"file-o",
            html_entity_decode("&#xf1c1; ") . __("File pdf outlined", ANPS_TEMPLATE_LANG)=>"file-pdf-o",
            html_entity_decode("&#xf1c5; ") . __("File photo o ", ANPS_TEMPLATE_LANG)=>"file-photo-o ",
            html_entity_decode("&#xf1c5; ") . __("File picture o ", ANPS_TEMPLATE_LANG)=>"file-picture-o ",
            html_entity_decode("&#xf1c4; ") . __("File powerpoint outlined", ANPS_TEMPLATE_LANG)=>"file-powerpoint-o",
            html_entity_decode("&#xf1c7; ") . __("File sound o ", ANPS_TEMPLATE_LANG)=>"file-sound-o ",
            html_entity_decode("&#xf15c; ") . __("File text", ANPS_TEMPLATE_LANG)=>"file-text",
            html_entity_decode("&#xf0f6; ") . __("File text outlined", ANPS_TEMPLATE_LANG)=>"file-text-o",
            html_entity_decode("&#xf1c8; ") . __("File video outlined", ANPS_TEMPLATE_LANG)=>"file-video-o",
            html_entity_decode("&#xf1c2; ") . __("File word outlined", ANPS_TEMPLATE_LANG)=>"file-word-o",
            html_entity_decode("&#xf1c6; ") . __("File zip o ", ANPS_TEMPLATE_LANG)=>"file-zip-o ",
            html_entity_decode("&#xf0c5; ") . __("Files outlined", ANPS_TEMPLATE_LANG)=>"files-o",
            html_entity_decode("&#xf008; ") . __("Film", ANPS_TEMPLATE_LANG)=>"film",
            html_entity_decode("&#xf0b0; ") . __("Filter", ANPS_TEMPLATE_LANG)=>"filter",
            html_entity_decode("&#xf06d; ") . __("Fire", ANPS_TEMPLATE_LANG)=>"fire",
            html_entity_decode("&#xf134; ") . __("Fire extinguisher", ANPS_TEMPLATE_LANG)=>"fire-extinguisher",
            html_entity_decode("&#xf024; ") . __("Flag", ANPS_TEMPLATE_LANG)=>"flag",
            html_entity_decode("&#xf11e; ") . __("Flag checkered", ANPS_TEMPLATE_LANG)=>"flag-checkered",
            html_entity_decode("&#xf11d; ") . __("Flag outlined", ANPS_TEMPLATE_LANG)=>"flag-o",
            html_entity_decode("&#xf0e7; ") . __("Flash ", ANPS_TEMPLATE_LANG)=>"flash ",
            html_entity_decode("&#xf0c3; ") . __("Flask", ANPS_TEMPLATE_LANG)=>"flask",
            html_entity_decode("&#xf16e; ") . __("Flickr", ANPS_TEMPLATE_LANG)=>"flickr",
            html_entity_decode("&#xf0c7; ") . __("Floppy outlined", ANPS_TEMPLATE_LANG)=>"floppy-o",
            html_entity_decode("&#xf07b; ") . __("Folder", ANPS_TEMPLATE_LANG)=>"folder",
            html_entity_decode("&#xf114; ") . __("Folder outlined", ANPS_TEMPLATE_LANG)=>"folder-o",
            html_entity_decode("&#xf07c; ") . __("Folder open", ANPS_TEMPLATE_LANG)=>"folder-open",
            html_entity_decode("&#xf115; ") . __("Folder open outlined", ANPS_TEMPLATE_LANG)=>"folder-open-o",
            html_entity_decode("&#xf031; ") . __("Font", ANPS_TEMPLATE_LANG)=>"font",
            html_entity_decode("&#xf04e; ") . __("Forward", ANPS_TEMPLATE_LANG)=>"forward",
            html_entity_decode("&#xf180; ") . __("Foursquare", ANPS_TEMPLATE_LANG)=>"foursquare",
            html_entity_decode("&#xf119; ") . __("Frown outlined", ANPS_TEMPLATE_LANG)=>"frown-o",
            html_entity_decode("&#xf11b; ") . __("Gamepad", ANPS_TEMPLATE_LANG)=>"gamepad",
            html_entity_decode("&#xf0e3; ") . __("Gavel", ANPS_TEMPLATE_LANG)=>"gavel",
            html_entity_decode("&#xf154; ") . __("Gbp", ANPS_TEMPLATE_LANG)=>"gbp",
            html_entity_decode("&#xf1d1; ") . __("Ge ", ANPS_TEMPLATE_LANG)=>"ge ",
            html_entity_decode("&#xf013; ") . __("Gear ", ANPS_TEMPLATE_LANG)=>"gear ",
            html_entity_decode("&#xf085; ") . __("Gears ", ANPS_TEMPLATE_LANG)=>"gears ",
            html_entity_decode("&#xf06b; ") . __("Gift", ANPS_TEMPLATE_LANG)=>"gift",
            html_entity_decode("&#xf1d3; ") . __("Git", ANPS_TEMPLATE_LANG)=>"git",
            html_entity_decode("&#xf1d2; ") . __("Git square", ANPS_TEMPLATE_LANG)=>"git-square",
            html_entity_decode("&#xf09b; ") . __("Github", ANPS_TEMPLATE_LANG)=>"github",
            html_entity_decode("&#xf113; ") . __("Github alt", ANPS_TEMPLATE_LANG)=>"github-alt",
            html_entity_decode("&#xf092; ") . __("Github square", ANPS_TEMPLATE_LANG)=>"github-square",
            html_entity_decode("&#xf184; ") . __("Gittip", ANPS_TEMPLATE_LANG)=>"gittip",
            html_entity_decode("&#xf000; ") . __("Glass", ANPS_TEMPLATE_LANG)=>"glass",
            html_entity_decode("&#xf0ac; ") . __("Globe", ANPS_TEMPLATE_LANG)=>"globe",
            html_entity_decode("&#xf1a0; ") . __("Google", ANPS_TEMPLATE_LANG)=>"google",
            html_entity_decode("&#xf0d5; ") . __("Google plus", ANPS_TEMPLATE_LANG)=>"google-plus",
            html_entity_decode("&#xf0d4; ") . __("Google plus square", ANPS_TEMPLATE_LANG)=>"google-plus-square",
            html_entity_decode("&#xf19d; ") . __("Graduation cap", ANPS_TEMPLATE_LANG)=>"graduation-cap",
            html_entity_decode("&#xf0c0; ") . __("Group ", ANPS_TEMPLATE_LANG)=>"group ",
            html_entity_decode("&#xf0fd; ") . __("H square", ANPS_TEMPLATE_LANG)=>"h-square",
            html_entity_decode("&#xf1d4; ") . __("Hacker news", ANPS_TEMPLATE_LANG)=>"hacker-news",
            html_entity_decode("&#xf0a7; ") . __("Hand outlined down", ANPS_TEMPLATE_LANG)=>"hand-o-down",
            html_entity_decode("&#xf0a5; ") . __("Hand outlined left", ANPS_TEMPLATE_LANG)=>"hand-o-left",
            html_entity_decode("&#xf0a4; ") . __("Hand outlined right", ANPS_TEMPLATE_LANG)=>"hand-o-right",
            html_entity_decode("&#xf0a6; ") . __("Hand outlined up", ANPS_TEMPLATE_LANG)=>"hand-o-up",
            html_entity_decode("&#xf0a0; ") . __("Hdd outlined", ANPS_TEMPLATE_LANG)=>"hdd-o",
            html_entity_decode("&#xf1dc; ") . __("Header", ANPS_TEMPLATE_LANG)=>"header",
            html_entity_decode("&#xf025; ") . __("Headphones", ANPS_TEMPLATE_LANG)=>"headphones",
            html_entity_decode("&#xf004; ") . __("Heart", ANPS_TEMPLATE_LANG)=>"heart",
            html_entity_decode("&#xf08a; ") . __("Heart outlined", ANPS_TEMPLATE_LANG)=>"heart-o",
            html_entity_decode("&#xf1da; ") . __("History", ANPS_TEMPLATE_LANG)=>"history",
            html_entity_decode("&#xf015; ") . __("Home", ANPS_TEMPLATE_LANG)=>"home",
            html_entity_decode("&#xf0f8; ") . __("Hospital outlined", ANPS_TEMPLATE_LANG)=>"hospital-o",
            html_entity_decode("&#xf13b; ") . __("Html5", ANPS_TEMPLATE_LANG)=>"html5",
            html_entity_decode("&#xf03e; ") . __("Image ", ANPS_TEMPLATE_LANG)=>"image ",
            html_entity_decode("&#xf01c; ") . __("Inbox", ANPS_TEMPLATE_LANG)=>"inbox",
            html_entity_decode("&#xf03c; ") . __("Indent", ANPS_TEMPLATE_LANG)=>"indent",
            html_entity_decode("&#xf129; ") . __("Info", ANPS_TEMPLATE_LANG)=>"info",
            html_entity_decode("&#xf05a; ") . __("Info circle", ANPS_TEMPLATE_LANG)=>"info-circle",
            html_entity_decode("&#xf156; ") . __("Inr", ANPS_TEMPLATE_LANG)=>"inr",
            html_entity_decode("&#xf16d; ") . __("Instagram", ANPS_TEMPLATE_LANG)=>"instagram",
            html_entity_decode("&#xf19c; ") . __("Institution ", ANPS_TEMPLATE_LANG)=>"institution ",
            html_entity_decode("&#xf033; ") . __("Italic", ANPS_TEMPLATE_LANG)=>"italic",
            html_entity_decode("&#xf1aa; ") . __("Joomla", ANPS_TEMPLATE_LANG)=>"joomla",
            html_entity_decode("&#xf157; ") . __("Jpy", ANPS_TEMPLATE_LANG)=>"jpy",
            html_entity_decode("&#xf1cc; ") . __("Jsfiddle", ANPS_TEMPLATE_LANG)=>"jsfiddle",
            html_entity_decode("&#xf084; ") . __("Key", ANPS_TEMPLATE_LANG)=>"key",
            html_entity_decode("&#xf11c; ") . __("Keyboard outlined", ANPS_TEMPLATE_LANG)=>"keyboard-o",
            html_entity_decode("&#xf159; ") . __("Krw", ANPS_TEMPLATE_LANG)=>"krw",
            html_entity_decode("&#xf1ab; ") . __("Language", ANPS_TEMPLATE_LANG)=>"language",
            html_entity_decode("&#xf109; ") . __("Laptop", ANPS_TEMPLATE_LANG)=>"laptop",
            html_entity_decode("&#xf06c; ") . __("Leaf", ANPS_TEMPLATE_LANG)=>"leaf",
            html_entity_decode("&#xf0e3; ") . __("Legal ", ANPS_TEMPLATE_LANG)=>"legal ",
            html_entity_decode("&#xf094; ") . __("Lemon outlined", ANPS_TEMPLATE_LANG)=>"lemon-o",
            html_entity_decode("&#xf149; ") . __("Level down", ANPS_TEMPLATE_LANG)=>"level-down",
            html_entity_decode("&#xf148; ") . __("Level up", ANPS_TEMPLATE_LANG)=>"level-up",
            html_entity_decode("&#xf1cd; ") . __("Life bouy ", ANPS_TEMPLATE_LANG)=>"life-bouy ",
            html_entity_decode("&#xf1cd; ") . __("Life ring", ANPS_TEMPLATE_LANG)=>"life-ring",
            html_entity_decode("&#xf1cd; ") . __("Life saver ", ANPS_TEMPLATE_LANG)=>"life-saver ",
            html_entity_decode("&#xf0eb; ") . __("Lightbulb outlined", ANPS_TEMPLATE_LANG)=>"lightbulb-o",
            html_entity_decode("&#xf0c1; ") . __("Link", ANPS_TEMPLATE_LANG)=>"link",
            html_entity_decode("&#xf0e1; ") . __("Linkedin", ANPS_TEMPLATE_LANG)=>"linkedin",
            html_entity_decode("&#xf08c; ") . __("Linkedin square", ANPS_TEMPLATE_LANG)=>"linkedin-square",
            html_entity_decode("&#xf17c; ") . __("Linux", ANPS_TEMPLATE_LANG)=>"linux",
            html_entity_decode("&#xf03a; ") . __("List", ANPS_TEMPLATE_LANG)=>"list",
            html_entity_decode("&#xf022; ") . __("List alt", ANPS_TEMPLATE_LANG)=>"list-alt",
            html_entity_decode("&#xf0cb; ") . __("List ol", ANPS_TEMPLATE_LANG)=>"list-ol",
            html_entity_decode("&#xf0ca; ") . __("List ul", ANPS_TEMPLATE_LANG)=>"list-ul",
            html_entity_decode("&#xf124; ") . __("Location arrow", ANPS_TEMPLATE_LANG)=>"location-arrow",
            html_entity_decode("&#xf023; ") . __("Lock", ANPS_TEMPLATE_LANG)=>"lock",
            html_entity_decode("&#xf175; ") . __("Long arrow down", ANPS_TEMPLATE_LANG)=>"long-arrow-down",
            html_entity_decode("&#xf177; ") . __("Long arrow left", ANPS_TEMPLATE_LANG)=>"long-arrow-left",
            html_entity_decode("&#xf178; ") . __("Long arrow right", ANPS_TEMPLATE_LANG)=>"long-arrow-right",
            html_entity_decode("&#xf176; ") . __("Long arrow up", ANPS_TEMPLATE_LANG)=>"long-arrow-up",
            html_entity_decode("&#xf0d0; ") . __("Magic", ANPS_TEMPLATE_LANG)=>"magic",
            html_entity_decode("&#xf076; ") . __("Magnet", ANPS_TEMPLATE_LANG)=>"magnet",
            html_entity_decode("&#xf064; ") . __("Mail forward ", ANPS_TEMPLATE_LANG)=>"mail-forward ",
            html_entity_decode("&#xf112; ") . __("Mail reply ", ANPS_TEMPLATE_LANG)=>"mail-reply ",
            html_entity_decode("&#xf122; ") . __("Mail reply all ", ANPS_TEMPLATE_LANG)=>"mail-reply-all ",
            html_entity_decode("&#xf183; ") . __("Male", ANPS_TEMPLATE_LANG)=>"male",
            html_entity_decode("&#xf041; ") . __("Map marker", ANPS_TEMPLATE_LANG)=>"map-marker",
            html_entity_decode("&#xf136; ") . __("Maxcdn", ANPS_TEMPLATE_LANG)=>"maxcdn",
            html_entity_decode("&#xf0fa; ") . __("Medkit", ANPS_TEMPLATE_LANG)=>"medkit",
            html_entity_decode("&#xf11a; ") . __("Meh outlined", ANPS_TEMPLATE_LANG)=>"meh-o",
            html_entity_decode("&#xf130; ") . __("Microphone", ANPS_TEMPLATE_LANG)=>"microphone",
            html_entity_decode("&#xf131; ") . __("Microphone slash", ANPS_TEMPLATE_LANG)=>"microphone-slash",
            html_entity_decode("&#xf068; ") . __("Minus", ANPS_TEMPLATE_LANG)=>"minus",
            html_entity_decode("&#xf056; ") . __("Minus circle", ANPS_TEMPLATE_LANG)=>"minus-circle",
            html_entity_decode("&#xf146; ") . __("Minus square", ANPS_TEMPLATE_LANG)=>"minus-square",
            html_entity_decode("&#xf147; ") . __("Minus square outlined", ANPS_TEMPLATE_LANG)=>"minus-square-o",
            html_entity_decode("&#xf10b; ") . __("Mobile", ANPS_TEMPLATE_LANG)=>"mobile",
            html_entity_decode("&#xf10b; ") . __("Mobile phone ", ANPS_TEMPLATE_LANG)=>"mobile-phone ",
            html_entity_decode("&#xf0d6; ") . __("Money", ANPS_TEMPLATE_LANG)=>"money",
            html_entity_decode("&#xf186; ") . __("Moon outlined", ANPS_TEMPLATE_LANG)=>"moon-o",
            html_entity_decode("&#xf19d; ") . __("Mortar board ", ANPS_TEMPLATE_LANG)=>"mortar-board ",
            html_entity_decode("&#xf001; ") . __("Music", ANPS_TEMPLATE_LANG)=>"music",
            html_entity_decode("&#xf0c9; ") . __("Navicon ", ANPS_TEMPLATE_LANG)=>"navicon ",
            html_entity_decode("&#xf19b; ") . __("Openid", ANPS_TEMPLATE_LANG)=>"openid",
            html_entity_decode("&#xf03b; ") . __("Outdent", ANPS_TEMPLATE_LANG)=>"outdent",
            html_entity_decode("&#xf18c; ") . __("Pagelines", ANPS_TEMPLATE_LANG)=>"pagelines",
            html_entity_decode("&#xf1d8; ") . __("Paper plane", ANPS_TEMPLATE_LANG)=>"paper-plane",
            html_entity_decode("&#xf1d9; ") . __("Paper plane outlined", ANPS_TEMPLATE_LANG)=>"paper-plane-o",
            html_entity_decode("&#xf0c6; ") . __("Paperclip", ANPS_TEMPLATE_LANG)=>"paperclip",
            html_entity_decode("&#xf1dd; ") . __("Paragraph", ANPS_TEMPLATE_LANG)=>"paragraph",
            html_entity_decode("&#xf0ea; ") . __("Paste ", ANPS_TEMPLATE_LANG)=>"paste ",
            html_entity_decode("&#xf04c; ") . __("Pause", ANPS_TEMPLATE_LANG)=>"pause",
            html_entity_decode("&#xf1b0; ") . __("Paw", ANPS_TEMPLATE_LANG)=>"paw",
            html_entity_decode("&#xf040; ") . __("Pencil", ANPS_TEMPLATE_LANG)=>"pencil",
            html_entity_decode("&#xf14b; ") . __("Pencil square", ANPS_TEMPLATE_LANG)=>"pencil-square",
            html_entity_decode("&#xf044; ") . __("Pencil square outlined", ANPS_TEMPLATE_LANG)=>"pencil-square-o",
            html_entity_decode("&#xf095; ") . __("Phone", ANPS_TEMPLATE_LANG)=>"phone",
            html_entity_decode("&#xf098; ") . __("Phone square", ANPS_TEMPLATE_LANG)=>"phone-square",
            html_entity_decode("&#xf03e; ") . __("Photo ", ANPS_TEMPLATE_LANG)=>"photo ",
            html_entity_decode("&#xf03e; ") . __("Picture outlined", ANPS_TEMPLATE_LANG)=>"picture-o",
            html_entity_decode("&#xf1a7; ") . __("Pied piper", ANPS_TEMPLATE_LANG)=>"pied-piper",
            html_entity_decode("&#xf1a8; ") . __("Pied piper alt", ANPS_TEMPLATE_LANG)=>"pied-piper-alt",
            html_entity_decode("&#xf1a7; ") . __("Pied piper square ", ANPS_TEMPLATE_LANG)=>"pied-piper-square ",
            html_entity_decode("&#xf0d2; ") . __("Pinterest", ANPS_TEMPLATE_LANG)=>"pinterest",
            html_entity_decode("&#xf0d3; ") . __("Pinterest square", ANPS_TEMPLATE_LANG)=>"pinterest-square",
            html_entity_decode("&#xf072; ") . __("Plane", ANPS_TEMPLATE_LANG)=>"plane",
            html_entity_decode("&#xf04b; ") . __("Play", ANPS_TEMPLATE_LANG)=>"play",
            html_entity_decode("&#xf144; ") . __("Play circle", ANPS_TEMPLATE_LANG)=>"play-circle",
            html_entity_decode("&#xf01d; ") . __("Play circle outlined", ANPS_TEMPLATE_LANG)=>"play-circle-o",
            html_entity_decode("&#xf067; ") . __("Plus", ANPS_TEMPLATE_LANG)=>"plus",
            html_entity_decode("&#xf055; ") . __("Plus circle", ANPS_TEMPLATE_LANG)=>"plus-circle",
            html_entity_decode("&#xf0fe; ") . __("Plus square", ANPS_TEMPLATE_LANG)=>"plus-square",
            html_entity_decode("&#xf196; ") . __("Plus square outlined", ANPS_TEMPLATE_LANG)=>"plus-square-o",
            html_entity_decode("&#xf011; ") . __("Power off", ANPS_TEMPLATE_LANG)=>"power-off",
            html_entity_decode("&#xf02f; ") . __("Print", ANPS_TEMPLATE_LANG)=>"print",
            html_entity_decode("&#xf12e; ") . __("Puzzle piece", ANPS_TEMPLATE_LANG)=>"puzzle-piece",
            html_entity_decode("&#xf1d6; ") . __("Qq", ANPS_TEMPLATE_LANG)=>"qq",
            html_entity_decode("&#xf029; ") . __("Qrcode", ANPS_TEMPLATE_LANG)=>"qrcode",
            html_entity_decode("&#xf128; ") . __("Question", ANPS_TEMPLATE_LANG)=>"question",
            html_entity_decode("&#xf059; ") . __("Question circle", ANPS_TEMPLATE_LANG)=>"question-circle",
            html_entity_decode("&#xf10d; ") . __("Quote left", ANPS_TEMPLATE_LANG)=>"quote-left",
            html_entity_decode("&#xf10e; ") . __("Quote right", ANPS_TEMPLATE_LANG)=>"quote-right",
            html_entity_decode("&#xf1d0; ") . __("Ra ", ANPS_TEMPLATE_LANG)=>"ra ",
            html_entity_decode("&#xf074; ") . __("Random", ANPS_TEMPLATE_LANG)=>"random",
            html_entity_decode("&#xf1d0; ") . __("Rebel", ANPS_TEMPLATE_LANG)=>"rebel",
            html_entity_decode("&#xf1b8; ") . __("Recycle", ANPS_TEMPLATE_LANG)=>"recycle",
            html_entity_decode("&#xf1a1; ") . __("Reddit", ANPS_TEMPLATE_LANG)=>"reddit",
            html_entity_decode("&#xf1a2; ") . __("Reddit square", ANPS_TEMPLATE_LANG)=>"reddit-square",
            html_entity_decode("&#xf021; ") . __("Refresh", ANPS_TEMPLATE_LANG)=>"refresh",
            html_entity_decode("&#xf18b; ") . __("Renren", ANPS_TEMPLATE_LANG)=>"renren",
            html_entity_decode("&#xf0c9; ") . __("Reorder ", ANPS_TEMPLATE_LANG)=>"reorder ",
            html_entity_decode("&#xf01e; ") . __("Repeat", ANPS_TEMPLATE_LANG)=>"repeat",
            html_entity_decode("&#xf112; ") . __("Reply", ANPS_TEMPLATE_LANG)=>"reply",
            html_entity_decode("&#xf122; ") . __("Reply all", ANPS_TEMPLATE_LANG)=>"reply-all",
            html_entity_decode("&#xf079; ") . __("Retweet", ANPS_TEMPLATE_LANG)=>"retweet",
            html_entity_decode("&#xf157; ") . __("Rmb ", ANPS_TEMPLATE_LANG)=>"rmb ",
            html_entity_decode("&#xf018; ") . __("Road", ANPS_TEMPLATE_LANG)=>"road",
            html_entity_decode("&#xf135; ") . __("Rocket", ANPS_TEMPLATE_LANG)=>"rocket",
            html_entity_decode("&#xf0e2; ") . __("Rotate left ", ANPS_TEMPLATE_LANG)=>"rotate-left ",
            html_entity_decode("&#xf01e; ") . __("Rotate right ", ANPS_TEMPLATE_LANG)=>"rotate-right ",
            html_entity_decode("&#xf158; ") . __("Rouble ", ANPS_TEMPLATE_LANG)=>"rouble ",
            html_entity_decode("&#xf09e; ") . __("Rss", ANPS_TEMPLATE_LANG)=>"rss",
            html_entity_decode("&#xf143; ") . __("Rss square", ANPS_TEMPLATE_LANG)=>"rss-square",
            html_entity_decode("&#xf158; ") . __("Rub", ANPS_TEMPLATE_LANG)=>"rub",
            html_entity_decode("&#xf158; ") . __("Ruble ", ANPS_TEMPLATE_LANG)=>"ruble ",
            html_entity_decode("&#xf156; ") . __("Rupee ", ANPS_TEMPLATE_LANG)=>"rupee ",
            html_entity_decode("&#xf0c7; ") . __("Save ", ANPS_TEMPLATE_LANG)=>"save ",
            html_entity_decode("&#xf0c4; ") . __("Scissors", ANPS_TEMPLATE_LANG)=>"scissors",
            html_entity_decode("&#xf002; ") . __("Search", ANPS_TEMPLATE_LANG)=>"search",
            html_entity_decode("&#xf010; ") . __("Search minus", ANPS_TEMPLATE_LANG)=>"search-minus",
            html_entity_decode("&#xf00e; ") . __("Search plus", ANPS_TEMPLATE_LANG)=>"search-plus",
            html_entity_decode("&#xf1d8; ") . __("Send ", ANPS_TEMPLATE_LANG)=>"send ",
            html_entity_decode("&#xf1d9; ") . __("Send o ", ANPS_TEMPLATE_LANG)=>"send-o ",
            html_entity_decode("&#xf064; ") . __("Share", ANPS_TEMPLATE_LANG)=>"share",
            html_entity_decode("&#xf1e0; ") . __("Share alt", ANPS_TEMPLATE_LANG)=>"share-alt",
            html_entity_decode("&#xf1e1; ") . __("Share alt square", ANPS_TEMPLATE_LANG)=>"share-alt-square",
            html_entity_decode("&#xf14d; ") . __("Share square", ANPS_TEMPLATE_LANG)=>"share-square",
            html_entity_decode("&#xf045; ") . __("Share square outlined", ANPS_TEMPLATE_LANG)=>"share-square-o",
            html_entity_decode("&#xf132; ") . __("Shield", ANPS_TEMPLATE_LANG)=>"shield",
            html_entity_decode("&#xf07a; ") . __("Shopping cart", ANPS_TEMPLATE_LANG)=>"shopping-cart",
            html_entity_decode("&#xf090; ") . __("Sign in", ANPS_TEMPLATE_LANG)=>"sign-in",
            html_entity_decode("&#xf08b; ") . __("Sign out", ANPS_TEMPLATE_LANG)=>"sign-out",
            html_entity_decode("&#xf012; ") . __("Signal", ANPS_TEMPLATE_LANG)=>"signal",
            html_entity_decode("&#xf0e8; ") . __("Sitemap", ANPS_TEMPLATE_LANG)=>"sitemap",
            html_entity_decode("&#xf17e; ") . __("Skype", ANPS_TEMPLATE_LANG)=>"skype",
            html_entity_decode("&#xf198; ") . __("Slack", ANPS_TEMPLATE_LANG)=>"slack",
            html_entity_decode("&#xf1de; ") . __("Sliders", ANPS_TEMPLATE_LANG)=>"sliders",
            html_entity_decode("&#xf118; ") . __("Smile outlined", ANPS_TEMPLATE_LANG)=>"smile-o",
            html_entity_decode("&#xf0dc; ") . __("Sort", ANPS_TEMPLATE_LANG)=>"sort",
            html_entity_decode("&#xf15d; ") . __("Sort alpha asc", ANPS_TEMPLATE_LANG)=>"sort-alpha-asc",
            html_entity_decode("&#xf15e; ") . __("Sort alpha desc", ANPS_TEMPLATE_LANG)=>"sort-alpha-desc",
            html_entity_decode("&#xf160; ") . __("Sort amount asc", ANPS_TEMPLATE_LANG)=>"sort-amount-asc",
            html_entity_decode("&#xf161; ") . __("Sort amount desc", ANPS_TEMPLATE_LANG)=>"sort-amount-desc",
            html_entity_decode("&#xf0de; ") . __("Sort asc", ANPS_TEMPLATE_LANG)=>"sort-asc",
            html_entity_decode("&#xf0dd; ") . __("Sort desc", ANPS_TEMPLATE_LANG)=>"sort-desc",
            html_entity_decode("&#xf0dd; ") . __("Sort down ", ANPS_TEMPLATE_LANG)=>"sort-down ",
            html_entity_decode("&#xf162; ") . __("Sort numeric asc", ANPS_TEMPLATE_LANG)=>"sort-numeric-asc",
            html_entity_decode("&#xf163; ") . __("Sort numeric desc", ANPS_TEMPLATE_LANG)=>"sort-numeric-desc",
            html_entity_decode("&#xf0de; ") . __("Sort up ", ANPS_TEMPLATE_LANG)=>"sort-up ",
            html_entity_decode("&#xf1be; ") . __("Soundcloud", ANPS_TEMPLATE_LANG)=>"soundcloud",
            html_entity_decode("&#xf197; ") . __("Space shuttle", ANPS_TEMPLATE_LANG)=>"space-shuttle",
            html_entity_decode("&#xf110; ") . __("Spinner", ANPS_TEMPLATE_LANG)=>"spinner",
            html_entity_decode("&#xf1b1; ") . __("Spoon", ANPS_TEMPLATE_LANG)=>"spoon",
            html_entity_decode("&#xf1bc; ") . __("Spotify", ANPS_TEMPLATE_LANG)=>"spotify",
            html_entity_decode("&#xf0c8; ") . __("Square", ANPS_TEMPLATE_LANG)=>"square",
            html_entity_decode("&#xf096; ") . __("Square outlined", ANPS_TEMPLATE_LANG)=>"square-o",
            html_entity_decode("&#xf18d; ") . __("Stack exchange", ANPS_TEMPLATE_LANG)=>"stack-exchange",
            html_entity_decode("&#xf16c; ") . __("Stack overflow", ANPS_TEMPLATE_LANG)=>"stack-overflow",
            html_entity_decode("&#xf005; ") . __("Star", ANPS_TEMPLATE_LANG)=>"star",
            html_entity_decode("&#xf089; ") . __("Star half", ANPS_TEMPLATE_LANG)=>"star-half",
            html_entity_decode("&#xf123; ") . __("Star half empty ", ANPS_TEMPLATE_LANG)=>"star-half-empty ",
            html_entity_decode("&#xf123; ") . __("Star half full ", ANPS_TEMPLATE_LANG)=>"star-half-full ",
            html_entity_decode("&#xf123; ") . __("Star half outlined", ANPS_TEMPLATE_LANG)=>"star-half-o",
            html_entity_decode("&#xf006; ") . __("Star outlined", ANPS_TEMPLATE_LANG)=>"star-o",
            html_entity_decode("&#xf1b6; ") . __("Steam", ANPS_TEMPLATE_LANG)=>"steam",
            html_entity_decode("&#xf1b7; ") . __("Steam square", ANPS_TEMPLATE_LANG)=>"steam-square",
            html_entity_decode("&#xf048; ") . __("Step backward", ANPS_TEMPLATE_LANG)=>"step-backward",
            html_entity_decode("&#xf051; ") . __("Step forward", ANPS_TEMPLATE_LANG)=>"step-forward",
            html_entity_decode("&#xf0f1; ") . __("Stethoscope", ANPS_TEMPLATE_LANG)=>"stethoscope",
            html_entity_decode("&#xf04d; ") . __("Stop", ANPS_TEMPLATE_LANG)=>"stop",
            html_entity_decode("&#xf0cc; ") . __("Strikethrough", ANPS_TEMPLATE_LANG)=>"strikethrough",
            html_entity_decode("&#xf1a4; ") . __("Stumbleupon", ANPS_TEMPLATE_LANG)=>"stumbleupon",
            html_entity_decode("&#xf1a3; ") . __("Stumbleupon circle", ANPS_TEMPLATE_LANG)=>"stumbleupon-circle",
            html_entity_decode("&#xf12c; ") . __("Subscript", ANPS_TEMPLATE_LANG)=>"subscript",
            html_entity_decode("&#xf0f2; ") . __("Suitcase", ANPS_TEMPLATE_LANG)=>"suitcase",
            html_entity_decode("&#xf185; ") . __("Sun outlined", ANPS_TEMPLATE_LANG)=>"sun-o",
            html_entity_decode("&#xf12b; ") . __("Superscript", ANPS_TEMPLATE_LANG)=>"superscript",
            html_entity_decode("&#xf1cd; ") . __("Support ", ANPS_TEMPLATE_LANG)=>"support ",
            html_entity_decode("&#xf0ce; ") . __("Table", ANPS_TEMPLATE_LANG)=>"table",
            html_entity_decode("&#xf10a; ") . __("Tablet", ANPS_TEMPLATE_LANG)=>"tablet",
            html_entity_decode("&#xf0e4; ") . __("Tachometer", ANPS_TEMPLATE_LANG)=>"tachometer",
            html_entity_decode("&#xf02b; ") . __("Tag", ANPS_TEMPLATE_LANG)=>"tag",
            html_entity_decode("&#xf02c; ") . __("Tags", ANPS_TEMPLATE_LANG)=>"tags",
            html_entity_decode("&#xf0ae; ") . __("Tasks", ANPS_TEMPLATE_LANG)=>"tasks",
            html_entity_decode("&#xf1ba; ") . __("Taxi", ANPS_TEMPLATE_LANG)=>"taxi",
            html_entity_decode("&#xf1d5; ") . __("Tencent weibo", ANPS_TEMPLATE_LANG)=>"tencent-weibo",
            html_entity_decode("&#xf120; ") . __("Terminal", ANPS_TEMPLATE_LANG)=>"terminal",
            html_entity_decode("&#xf034; ") . __("Text height", ANPS_TEMPLATE_LANG)=>"text-height",
            html_entity_decode("&#xf035; ") . __("Text width", ANPS_TEMPLATE_LANG)=>"text-width",
            html_entity_decode("&#xf00a; ") . __("Th", ANPS_TEMPLATE_LANG)=>"th",
            html_entity_decode("&#xf009; ") . __("Th large", ANPS_TEMPLATE_LANG)=>"th-large",
            html_entity_decode("&#xf00b; ") . __("Th list", ANPS_TEMPLATE_LANG)=>"th-list",
            html_entity_decode("&#xf08d; ") . __("Thumb tack", ANPS_TEMPLATE_LANG)=>"thumb-tack",
            html_entity_decode("&#xf165; ") . __("Thumbs down", ANPS_TEMPLATE_LANG)=>"thumbs-down",
            html_entity_decode("&#xf088; ") . __("Thumbs outlined down", ANPS_TEMPLATE_LANG)=>"thumbs-o-down",
            html_entity_decode("&#xf087; ") . __("Thumbs outlined up", ANPS_TEMPLATE_LANG)=>"thumbs-o-up",
            html_entity_decode("&#xf164; ") . __("Thumbs up", ANPS_TEMPLATE_LANG)=>"thumbs-up",
            html_entity_decode("&#xf145; ") . __("Ticket", ANPS_TEMPLATE_LANG)=>"ticket",
            html_entity_decode("&#xf00d; ") . __("Times", ANPS_TEMPLATE_LANG)=>"times",
            html_entity_decode("&#xf057; ") . __("Times circle", ANPS_TEMPLATE_LANG)=>"times-circle",
            html_entity_decode("&#xf05c; ") . __("Times circle outlined", ANPS_TEMPLATE_LANG)=>"times-circle-o",
            html_entity_decode("&#xf043; ") . __("Tint", ANPS_TEMPLATE_LANG)=>"tint",
            html_entity_decode("&#xf150; ") . __("Toggle down ", ANPS_TEMPLATE_LANG)=>"toggle-down ",
            html_entity_decode("&#xf191; ") . __("Toggle left ", ANPS_TEMPLATE_LANG)=>"toggle-left ",
            html_entity_decode("&#xf152; ") . __("Toggle right ", ANPS_TEMPLATE_LANG)=>"toggle-right ",
            html_entity_decode("&#xf151; ") . __("Toggle up ", ANPS_TEMPLATE_LANG)=>"toggle-up ",
            html_entity_decode("&#xf014; ") . __("Trash outlined", ANPS_TEMPLATE_LANG)=>"trash-o",
            html_entity_decode("&#xf1bb; ") . __("Tree", ANPS_TEMPLATE_LANG)=>"tree",
            html_entity_decode("&#xf181; ") . __("Trello", ANPS_TEMPLATE_LANG)=>"trello",
            html_entity_decode("&#xf091; ") . __("Trophy", ANPS_TEMPLATE_LANG)=>"trophy",
            html_entity_decode("&#xf0d1; ") . __("Truck", ANPS_TEMPLATE_LANG)=>"truck",
            html_entity_decode("&#xf195; ") . __("Try", ANPS_TEMPLATE_LANG)=>"try",
            html_entity_decode("&#xf173; ") . __("Tumblr", ANPS_TEMPLATE_LANG)=>"tumblr",
            html_entity_decode("&#xf174; ") . __("Tumblr square", ANPS_TEMPLATE_LANG)=>"tumblr-square",
            html_entity_decode("&#xf195; ") . __("Turkish lira ", ANPS_TEMPLATE_LANG)=>"turkish-lira ",
            html_entity_decode("&#xf099; ") . __("Twitter", ANPS_TEMPLATE_LANG)=>"twitter",
            html_entity_decode("&#xf081; ") . __("Twitter square", ANPS_TEMPLATE_LANG)=>"twitter-square",
            html_entity_decode("&#xf0e9; ") . __("Umbrella", ANPS_TEMPLATE_LANG)=>"umbrella",
            html_entity_decode("&#xf0cd; ") . __("Underline", ANPS_TEMPLATE_LANG)=>"underline",
            html_entity_decode("&#xf0e2; ") . __("Undo", ANPS_TEMPLATE_LANG)=>"undo",
            html_entity_decode("&#xf19c; ") . __("University", ANPS_TEMPLATE_LANG)=>"university",
            html_entity_decode("&#xf127; ") . __("Unlink ", ANPS_TEMPLATE_LANG)=>"unlink ",
            html_entity_decode("&#xf09c; ") . __("Unlock", ANPS_TEMPLATE_LANG)=>"unlock",
            html_entity_decode("&#xf13e; ") . __("Unlock alt", ANPS_TEMPLATE_LANG)=>"unlock-alt",
            html_entity_decode("&#xf0dc; ") . __("Unsorted ", ANPS_TEMPLATE_LANG)=>"unsorted ",
            html_entity_decode("&#xf093; ") . __("Upload", ANPS_TEMPLATE_LANG)=>"upload",
            html_entity_decode("&#xf155; ") . __("Usd", ANPS_TEMPLATE_LANG)=>"usd",
            html_entity_decode("&#xf007; ") . __("User", ANPS_TEMPLATE_LANG)=>"user",
            html_entity_decode("&#xf0f0; ") . __("User md", ANPS_TEMPLATE_LANG)=>"user-md",
            html_entity_decode("&#xf0c0; ") . __("Users", ANPS_TEMPLATE_LANG)=>"users",
            html_entity_decode("&#xf03d; ") . __("Video camera", ANPS_TEMPLATE_LANG)=>"video-camera",
            html_entity_decode("&#xf194; ") . __("Vimeo square", ANPS_TEMPLATE_LANG)=>"vimeo-square",
            html_entity_decode("&#xf1ca; ") . __("Vine", ANPS_TEMPLATE_LANG)=>"vine",
            html_entity_decode("&#xf189; ") . __("Vk", ANPS_TEMPLATE_LANG)=>"vk",
            html_entity_decode("&#xf027; ") . __("Volume down", ANPS_TEMPLATE_LANG)=>"volume-down",
            html_entity_decode("&#xf026; ") . __("Volume off", ANPS_TEMPLATE_LANG)=>"volume-off",
            html_entity_decode("&#xf028; ") . __("Volume up", ANPS_TEMPLATE_LANG)=>"volume-up",
            html_entity_decode("&#xf071; ") . __("Warning ", ANPS_TEMPLATE_LANG)=>"warning ",
            html_entity_decode("&#xf1d7; ") . __("Wechat ", ANPS_TEMPLATE_LANG)=>"wechat ",
            html_entity_decode("&#xf18a; ") . __("Weibo", ANPS_TEMPLATE_LANG)=>"weibo",
            html_entity_decode("&#xf1d7; ") . __("Weixin", ANPS_TEMPLATE_LANG)=>"weixin",
            html_entity_decode("&#xf193; ") . __("Wheelchair", ANPS_TEMPLATE_LANG)=>"wheelchair",
            html_entity_decode("&#xf17a; ") . __("Windows", ANPS_TEMPLATE_LANG)=>"windows",
            html_entity_decode("&#xf159; ") . __("Won ", ANPS_TEMPLATE_LANG)=>"won ",
            html_entity_decode("&#xf19a; ") . __("Wordpress", ANPS_TEMPLATE_LANG)=>"wordpress",
            html_entity_decode("&#xf0ad; ") . __("Wrench", ANPS_TEMPLATE_LANG)=>"wrench",
            html_entity_decode("&#xf168; ") . __("Xing", ANPS_TEMPLATE_LANG)=>"xing",
            html_entity_decode("&#xf169; ") . __("Xing square", ANPS_TEMPLATE_LANG)=>"xing-square",
            html_entity_decode("&#xf19e; ") . __("Yahoo", ANPS_TEMPLATE_LANG)=>"yahoo",
            html_entity_decode("&#xf157; ") . __("Yen ", ANPS_TEMPLATE_LANG)=>"yen ",
            html_entity_decode("&#xf167; ") . __("Youtube", ANPS_TEMPLATE_LANG)=>"youtube",
            html_entity_decode("&#xf16a; ") . __("Youtube play", ANPS_TEMPLATE_LANG)=>"youtube-play",
            html_entity_decode("&#xf166; ") . __("Youtube square", ANPS_TEMPLATE_LANG)=>"youtube-square");
        
        return $icon_array;
    }
}

add_action( 'widgets_init', create_function('', 'return register_widget("AnpsDownload");') );