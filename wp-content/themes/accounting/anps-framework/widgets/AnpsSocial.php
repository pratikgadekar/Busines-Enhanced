<?php
class AnpsSocial extends WP_Widget {
    public function __construct() {
        parent::__construct(
                'AnpsSocial', 'AnpsThemes - Social icons', array('description' => __('Enter social icons to show on page', ANPS_TEMPLATE_LANG),)
        );
    }
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
            'title' => '',
            'sidebar_content' => '',
            'icon_0' => '', 
            'icon_1' => '', 
            'icon_2' => '', 
            'icon_3' => '', 
            'icon_4' => '', 
            'icon_5' => '', 
            'icon_6' => '', 
            'icon_7' => '', 
            'icon_8' => '', 
            'icon_9' => '', 
            'icon_10' => '', 
            'icon_11' => '', 
            'url_0'=>'',
            'url_1'=>'',
            'url_2'=>'',
            'url_3'=>'',
            'url_4'=>'',
            'url_5'=>'',
            'url_6'=>'',
            'url_7'=>'',
            'url_8'=>'',
            'url_9'=>'',
            'url_10'=>'',
            'url_11'=>'',
            'target'=>''
            ));
        $icon_array = array(
            __("Adn", ANPS_TEMPLATE_LANG)=>"adn",
            __("Android", ANPS_TEMPLATE_LANG)=>"android",
            __("Apple", ANPS_TEMPLATE_LANG)=>"apple",
            __("Behance", ANPS_TEMPLATE_LANG)=>"behance",
            __("Behance square", ANPS_TEMPLATE_LANG)=>"behance-square",
            __("Bitbucket", ANPS_TEMPLATE_LANG)=>"bitbucket",
            __("Bitbucket square", ANPS_TEMPLATE_LANG)=>"bitbucket-square",
            __("Bitcoin", ANPS_TEMPLATE_LANG)=>"bitcoin",
            __("Btc", ANPS_TEMPLATE_LANG)=>"btc",
            __("Codepen", ANPS_TEMPLATE_LANG)=>"codepen",
            __("Css3", ANPS_TEMPLATE_LANG)=>"css3",
            __("Delicious", ANPS_TEMPLATE_LANG)=>"delicious",
            __("Deviantart", ANPS_TEMPLATE_LANG)=>"deviantart",
            __("Digg", ANPS_TEMPLATE_LANG)=>"digg",
            __("Dribbble", ANPS_TEMPLATE_LANG)=>"dribbble",
            __("Dropbox", ANPS_TEMPLATE_LANG)=>"dropbox",
            __("Drupal", ANPS_TEMPLATE_LANG)=>"drupal",
            __("Empire", ANPS_TEMPLATE_LANG)=>"empire",
            __("Facebook", ANPS_TEMPLATE_LANG)=>"facebook",
            __("Facebook square", ANPS_TEMPLATE_LANG)=>"facebook-square",
            __("Flickr", ANPS_TEMPLATE_LANG)=>"flickr",
            __("Foursquare", ANPS_TEMPLATE_LANG)=>"foursquare",
            __("Ge", ANPS_TEMPLATE_LANG)=>"ge",
            __("Git", ANPS_TEMPLATE_LANG)=>"git",
            __("Git square", ANPS_TEMPLATE_LANG)=>"git-square",
            __("Github", ANPS_TEMPLATE_LANG)=>"github",
            __("Github alt", ANPS_TEMPLATE_LANG)=>"github-alt",
            __("Github square", ANPS_TEMPLATE_LANG)=>"github-square",
            __("Gittip", ANPS_TEMPLATE_LANG)=>"gittip",
            __("Google", ANPS_TEMPLATE_LANG)=>"google",
            __("Google plus", ANPS_TEMPLATE_LANG)=>"google-plus",
            __("Google plus square", ANPS_TEMPLATE_LANG)=>"google-plus-square",
            __("Hacker news", ANPS_TEMPLATE_LANG)=>"hacker-news",
            __("Html5", ANPS_TEMPLATE_LANG)=>"html5",
            __("Instagram", ANPS_TEMPLATE_LANG)=>"instagram",
            __("Joomla", ANPS_TEMPLATE_LANG)=>"joomla",
            __("Jsfiddle", ANPS_TEMPLATE_LANG)=>"jsfiddle",
            __("Linkedin", ANPS_TEMPLATE_LANG)=>"linkedin",
            __("Linkedin square", ANPS_TEMPLATE_LANG)=>"linkedin-square",
            __("Linux", ANPS_TEMPLATE_LANG)=>"linux",
            __("Maxcdn", ANPS_TEMPLATE_LANG)=>"maxcdn",
            __("Map marker", ANPS_TEMPLATE_LANG)=>"map-marker",
            __("Maxcdn", ANPS_TEMPLATE_LANG)=>"maxcdn",
            __("Openid", ANPS_TEMPLATE_LANG)=>"openid",
            __("Pagelines", ANPS_TEMPLATE_LANG)=>"pagelines",
            __("Pied piper", ANPS_TEMPLATE_LANG)=>"pied-piper",
            __("Pied piper alt", ANPS_TEMPLATE_LANG)=>"pied-piper-alt",
            __("Pied piper square", ANPS_TEMPLATE_LANG)=>"pied-piper-square",
            __("Pinterest", ANPS_TEMPLATE_LANG)=>"pinterest",
            __("Pinterest square", ANPS_TEMPLATE_LANG)=>"pinterest-square",
            __("Qq", ANPS_TEMPLATE_LANG)=>"qq",
            __("Ra", ANPS_TEMPLATE_LANG)=>"ra",
            __("Rebel", ANPS_TEMPLATE_LANG)=>"rebel",
            __("Reddit", ANPS_TEMPLATE_LANG)=>"reddit",
            __("Reddit square", ANPS_TEMPLATE_LANG)=>"reddit-square",
            __("Renren", ANPS_TEMPLATE_LANG)=>"renren",
            __("Share alt", ANPS_TEMPLATE_LANG)=>"share-alt",
            __("Share alt square", ANPS_TEMPLATE_LANG)=>"share-alt-square",
            __("Skype", ANPS_TEMPLATE_LANG)=>"skype",
            __("Slack", ANPS_TEMPLATE_LANG)=>"slack",
            __("Soundcloud", ANPS_TEMPLATE_LANG)=>"soundcloud",
            __("Spotify", ANPS_TEMPLATE_LANG)=>"spotify",
            __("Stack exchange", ANPS_TEMPLATE_LANG)=>"stack-exchange",
            __("Stack overflow", ANPS_TEMPLATE_LANG)=>"stack-overflow",
            __("Steam", ANPS_TEMPLATE_LANG)=>"steam",
            __("Steam square", ANPS_TEMPLATE_LANG)=>"steam-square",
            __("Stumbleupon", ANPS_TEMPLATE_LANG)=>"stumbleupon",
            __("Stumbleupon circle", ANPS_TEMPLATE_LANG)=>"stumbleupon-circle",
            __("Tencent weibo", ANPS_TEMPLATE_LANG)=>"tencent-weibo",
            __("Trello", ANPS_TEMPLATE_LANG)=>"trello",
            __("Tumblr", ANPS_TEMPLATE_LANG)=>"tumblr",
            __("Tumblr square", ANPS_TEMPLATE_LANG)=>"tumblr-square",
            __("Twitter", ANPS_TEMPLATE_LANG)=>"twitter",
            __("Twitter square", ANPS_TEMPLATE_LANG)=>"twitter-square",
            __("Vimeo square", ANPS_TEMPLATE_LANG)=>"vimeo-square",
            __("Vine", ANPS_TEMPLATE_LANG)=>"vine",
            __("Vk", ANPS_TEMPLATE_LANG)=>"vk",
            __("Wechat", ANPS_TEMPLATE_LANG)=>"wechat",
            __("Weibo", ANPS_TEMPLATE_LANG)=>"weibo",
            __("Weixin", ANPS_TEMPLATE_LANG)=>"weixin",
            __("Windows", ANPS_TEMPLATE_LANG)=>"windows",
            __("Wordpress", ANPS_TEMPLATE_LANG)=>"wordpress",
            __("Xing", ANPS_TEMPLATE_LANG)=>"xing",
            __("Xing square", ANPS_TEMPLATE_LANG)=>"xing-square",
            __("Yahoo", ANPS_TEMPLATE_LANG)=>"yahoo",
            __("Youtube", ANPS_TEMPLATE_LANG)=>"youtube",
            __("Youtube play", ANPS_TEMPLATE_LANG)=>"youtube-play",
            __("Youtube square", ANPS_TEMPLATE_LANG)=>"youtube-square"
        );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e("Title", ANPS_TEMPLATE_LANG); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('sidebar_content')); ?>" name="<?php echo esc_attr($this->get_field_name('sidebar_content')); ?>" type="checkbox" <?php if($instance['sidebar_content']=="on") {echo "checked";} else {echo "";} ?> />
            <label for="<?php echo esc_attr($this->get_field_id('sidebar_content')); ?>"><?php _e("Sidebar content", ANPS_TEMPLATE_LANG); ?></label>
        </p>
        <?php for($i=0; $i<12; $i++) : ?>
        <p>
            <select id="<?php echo esc_attr($this->get_field_id('icon_'.$i)); ?>" name="<?php echo esc_attr($this->get_field_name('icon_'.$i)); ?>">
                <option value="">Select an icon</option>         
                <?php foreach ($icon_array as $value=>$item) : ?>
                    <option <?php if ($item == $instance['icon_'.$i]) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($item); ?>"><?php echo esc_attr($value); ?></option>
            <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('url_'.$i)); ?>" name="<?php echo esc_attr($this->get_field_name('url_'.$i)); ?>" type="text" class="widefat" value="<?php echo esc_attr($instance['url_'.$i]); ?>" />
        </p>
        <?php endfor; ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('target')); ?>"><?php _e("Target", ANPS_TEMPLATE_LANG); ?></label>
            <?php $target_array = array("_self", "_blank", "_parent", "_top");?>
            <select id="<?php echo esc_attr($this->get_field_id('target')); ?>" name="<?php echo esc_attr($this->get_field_name('target')); ?>">
                <?php foreach($target_array as $key=>$item) : ?>
                <option <?php if ($key == $instance['target']) {
                        echo 'selected="selected"';
                    } ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($item); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        for($i=0; $i<12; $i++) {
            $instance['icon_'.$i] = $new_instance['icon_'.$i];
            $instance['url_'.$i] = $new_instance['url_'.$i];
        }
        $instance['title'] = $new_instance['title'];
        $instance['target'] = $new_instance['target'];
        $instance['sidebar_content'] = $new_instance['sidebar_content'];
        return $instance;
    }
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        $icon = "";
        if( isset($instance['icon']) ) {
            $icon = $instance['icon'];
        }
        $url = '';
        if( isset($instance['url']) ) {
            $url = $instance['url'];
        }
        $title = '';
        if( isset($instance['title']) ) {
            $title = $instance['title'];
        }
        $sidebar_content = '';
        if( isset($instance['sidebar_content']) ) {
            $sidebar_content = $instance['sidebar_content'];
        }
        if($sidebar_content=="on") {
            $class = "social";
        } else {
            $class = "socialize";
        }
        $target = "";
        if(isset($instance['target'] )) {
            $instance['target'] = $instance['target'] ;
        } else {
            $instance['target'] = "";
        }
        switch($instance['target']) {
            case 0 :
                $target = "_self";
                break;
            case 1 :
                $target = "_blank";
                break;
            case 2 :
                $target = "_parent";
                break;
            case 3 :
                $target = "_top";
                break;
            default :
                $target = "_self";
        }
        echo $before_widget;
        ?>
        <?php if($title) : ?>
        <h3 class="widget-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        <ul class="<?php echo esc_attr($class); ?>">
            <?php for($i=0; $i<12; $i++) : 
                if(isset($instance['icon_'.$i]) && $instance['icon_'.$i]!="") : ?>
            <li>
                <?php if($instance['url_'.$i]!="") : ?>
                <a class="fa fa-<?php echo esc_attr($instance['icon_'.$i]); ?>" href="<?php echo esc_url($instance['url_'.$i]); ?>" target="<?php echo esc_attr($target); ?>"></a>
                <?php else : ?>
                <span class="fa fa-<?php echo esc_attr($instance['icon_'.$i]); ?>"></span>
                <?php endif; ?>
            </li>
            <?php endif; ?>
            <?php endfor; ?>
        </ul>
        <?php
        echo $after_widget;
    }
}
add_action( 'widgets_init', create_function('', 'return register_widget("AnpsSocial");') );