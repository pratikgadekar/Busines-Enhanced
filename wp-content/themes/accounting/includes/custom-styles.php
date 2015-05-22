<?php 
    header("Content-type: text/css; charset: UTF-8"); 
    require_once('../../../../wp-load.php'); 
?>
<?php 
function anps_getExtCustomFonts($font) {
    $dir = get_template_directory().'/fonts'; 
        if ($handle = opendir($dir)) { 
            $arr = array();
            // Get all files and store it to array
            while(false !== ($entry = readdir($handle))) {
                $explode_font=explode('.',$entry);
                if(strtolower($font)==strtolower($explode_font[0]))
                    $arr[] = $entry;
            }          
            closedir($handle); 
            // Remove . and ..
            unset($arr['.'], $arr['..']); 
            return $arr;
        }
}
$fonts = "PT Serif";
$type = 2;

$fonts2 = "PT Sans";
$type2 = 2;

$font_navigation = "PT Serif";
$type_navigation = 2;

switch(get_option('font_source_1')) {
    case('System fonts') :
        $fonts = urldecode(get_option('font_type_1'));
        $type = 0;
        break;
    case('Custom fonts') :
        $fonts = urldecode(get_option('font_type_1'));
        $type = 1;
        break;
    case('Google fonts') :
        $fonts = urldecode(get_option('font_type_1'));
        $type = 2;
        break;
}
switch(get_option('font_source_2')) {
    case('System fonts') :
        $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 0;
        break;
    case('Custom fonts') :
        $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 1;
        break;
    case('Google fonts') :
    $fonts2 = urldecode(get_option('font_type_2'));
        $type2 = 2;
        break;
}

switch(get_option('font_source_navigation')) {
    case('System fonts') :
        $font_navigation = urldecode(get_option('font_type_navigation'));
        $type_navigation = 0;
        break;
    case('Custom fonts') :
        $font_navigation = urldecode(get_option('font_type_navigation'));
        $type_navigation = 1;
        break;
    case('Google fonts') :
        $font_navigation = urldecode(get_option('font_type_navigation'));
        $type_navigation = 2;
        break;
}

?>
<?php if($type==1 && $fonts!="titillium") : ?>
  @font-face {
    font-family: '<?php echo esc_attr($fonts); ?>';
    src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($fonts); ?>.eot');
    src: <?php $i=0;
               $fonts_count = count(anps_getExtCustomFonts($fonts)); 
               foreach(anps_getExtCustomFonts($fonts) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);  
                    $i++;
                    if($i==$fonts_count) {
                        $separator = ";";
                    } else {
                        $separator = ",";
                    }
                    if($explode_item[1]=='eot') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.eot?#iefix') format('embedded-opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff') format('woff')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='otf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.otf') format('opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='ttf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.ttf') format('ttf')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff2') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff2') format('woff2')<?php echo esc_attr($separator); ?>
                    <?php else :
                        continue;
                    endif;                                      
                endforeach; ?>
  }
<?php endif; ?>
<?php if($type2==1 && $fonts2!="titillium") : ?>
  @font-face {
    font-family: '<?php echo esc_attr($fonts2); ?>';
    src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($fonts2); ?>.eot');
    src: <?php  $i=0;
                $fonts_count = count(anps_getExtCustomFonts($fonts2));
                foreach(anps_getExtCustomFonts($fonts2) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);  
                    $i++;
                    if($i==$fonts_count) {
                        $separator = ";";
                    } else {
                        $separator = ",";
                    }
                    if($explode_item[1]=='eot') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.eot?#iefix') format('embedded-opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff') format('woff')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='otf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.otf') format('opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='ttf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.ttf') format('ttf')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff2') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff2') format('woff2')<?php echo esc_attr($separator); ?>
                    <?php else :
                        continue;
                    endif; 
                endforeach; ?>
  }
<?php endif; ?>


<?php if($type_navigation==1 && $type_navigation!="titillium") : ?>
  @font-face {
    font-family: '<?php echo esc_attr($font_navigation); ?>';
    src: url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_url($font_navigation); ?>.eot');
    src: <?php  $i=0;
                $fonts_count = count(anps_getExtCustomFonts($font_navigation));
                foreach(anps_getExtCustomFonts($font_navigation) as $item) : ?> 
                    <?php $explode_item = explode(".", $item);  
                    $i++;
                    if($i==$fonts_count) {
                        $separator = ";";
                    } else {
                        $separator = ",";
                    }
                    if($explode_item[1]=='eot') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.eot?#iefix') format('embedded-opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff') format('woff')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='otf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.otf') format('opentype')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='ttf') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.ttf') format('ttf')<?php echo esc_attr($separator); ?>
                    <?php elseif($explode_item[1]=='woff2') : ?>
                        url('<?php echo get_template_directory_uri(); ?>/fonts/<?php echo esc_attr($explode_item[0]); ?>.woff2') format('woff2')<?php echo esc_attr($separator); ?>
                    <?php else :
                        continue;
                    endif;
                endforeach; ?>
  }
<?php endif; ?>

<?php
    /* Main theme colors */
    $text_color = get_option('text_color', '#727272');
    $primary_color = get_option('primary_color', '#26507a');
    $hovers_color = get_option('hovers_color', '#3178bf');
    $menu_text_color = get_option('menu_text_color', '#000000');
    $headings_color = get_option('headings_color', '#000000');
    $top_bar_color = get_option('top_bar_color', '#c1c1c1');
    $top_bar_bg_color = get_option('top_bar_bg_color', '#f9f9f9');
    $footer_bg_color = get_option('footer_bg_color', '#0f0f0f');
    $copyright_footer_bg_color  = get_option('copyright_footer_bg_color', '#242424');
    $footer_text_color = get_option('footer_text_color', '#c4c4c4');
    $nav_background_color = get_option('nav_background_color', '#fff');
    $submenu_background_color = get_option('submenu_background_color', '#fff');
    $submenu_text_color = get_option('submenu_text_color', '#000');
    $side_submenu_background_color = get_option('side_submenu_background_color', '#fff');
    $side_submenu_text_color = get_option('side_submenu_text_color', '#000');
    $side_submenu_text_hover_color = get_option('side_submenu_text_hover_color', '#1874c1');
    $icon_shortcode_text_hover_color = get_option('icon_shortcode_text_hover_color', '#3178bf' );
    
    /*home-page colors*/
    $anps_front_text_color = get_option('anps_front_text_color', '#000');
    $anps_front_text_hover_color = get_option('anps_front_text_hover_color', '#3178bf');
    $anps_front_bg_color = get_option('anps_front_bg_color');
    $anps_front_topbar_color = get_option('anps_front_topbar_color', '#fff');
    $anps_front_topbar_hover_color = get_option('anps_front_topbar_hover_color', '#1874c1');

    /*font-size*/ 
    $body_font_size = get_option('body_font_size', '14');
    $menu_font_size = get_option('menu_font_size', '14');
  $h1_font_size = get_option('h1_font_size', '31');
  $h2_font_size = get_option('h2_font_size', '15');
  $h3_font_size = get_option('h3_font_size', '21');
  $h4_font_size = get_option('h4_font_size', '18');
  $h5_font_size = get_option('h5_font_size', '16');
  $page_heading_h1_font_size = get_option('page_heading_h1_font_size', '24');
   $blog_heading_h1_font_size = get_option('blog_heading_h1_font_size', '28');
  


    
    function hex_to_rgb($hex) {
        $hex = str_replace('#','',$hex);
        if(strlen($hex)==3) {
            $hex = $hex.$hex;
        }
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        return $rgb;
    }
    /* Darken function */
    function colourBrightness($hex, $percent) {
        // Work out if hash given
  $hash = '';
  if (stristr($hex,'#')) {
            $hex = str_replace('#','',$hex);
            $hash = '#';
  }
  $brightness = -(100 - $percent*2)/100;
  /// HEX TO RGB
  $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
  //// CALCULATE 
  for ($i=0; $i<3; $i++) {
            // See if brighter or darker
            if ($brightness > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
            } else {
    // Darker
                $positivePercent = $brightness - ($brightness*2);
    $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
  }
  //// RBG to Hex
  $hex = '';
  for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
  }
  return $hash.$hex;
    }
?>
<?php if($fonts=="titillium" || $fonts2=="titillium") : ?>
@font-face {
  font-family: "titillium-bold";
  src: url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-semibold.eot');
  src: url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-semibold.eot?#iefix') format('eot'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-semibold.woff') format('woff'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-semibold.ttf') format('truetype'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-semibold.svg#titilliumbold') format('svg');
}

@font-face {
  font-family: "titillium-regular";
  src: url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-regular.eot');
  src: url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-regular.eot?#iefix') format('eot'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-regular.woff') format('woff'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-regular.ttf') format('truetype'), url('<?php echo get_template_directory_uri(); ?>/fonts/titillium/titillium-regular.svg#titilliumbold') format('svg');
}
<?php endif; ?>
body,
ol.list > li > * {
  color: <?php echo esc_attr($text_color); ?>;
}

/*
@media (min-width: 992px) {
.responsive .site-navigation li:hover .sub-menu {
    border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>!important;
 }
}
*/

a,
.btn-link,
.error-404 h2,
.page-heading,
.statement .style-3,
.dropcaps.style-2:first-letter,
.list li:before,
ol.list,
.post.style-2 header > span,
.post.style-2 header .fa,
.page-numbers span,
.team .socialize a,
blockquote.style-2:before,
.panel-group.style-2 .panel-title a:before,
.contact-info .fa,
blockquote.style-1:before,
.comment-list .comment header h1,
.faq .panel-title a.collapsed:before,
.faq .panel-title a:after,
.faq .panel-title a,
.filter button.selected,
.filter:before,
.primary,
.search-posts i,
.counter .counter-number,
#wp-calendar th,
#wp-calendar caption,
.testimonials blockquote p:before,
.testimonials blockquote p:after,
.tab-pane .commentlist .meta strong,
.widget_recent_comments .recentcomments a
{
  color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote p:before,
.testimonials.white blockquote p:after
{
  color: #fff;
}


.site-footer, .site-footer .copyright-footer  {
  color: <?php echo esc_attr($footer_text_color); ?>;
}


.counter .wrapbox
{
border-color:<?php echo esc_attr($primary_color); ?>;
}


.nav .open > a:focus,
body .tp-bullets.simplebullets.round .bullet.selected {
  border-color: <?php echo esc_attr($primary_color); ?>;
}


@media (max-width: 993px) {
 nav.site-navigation.open{
    background-color: <?php echo esc_attr($footer_bg_color); ?>;
  }
}


@media (min-width: 993px) {
 .site-navigation > div > ul > li .sub-menu .sub-menu,
 .site-navigation > ul > li .sub-menu .sub-menu {
    border-bottom: 1px solid <?php echo esc_attr($primary_color); ?>;
  }
 
}


.icon .fa,
.posts div a,
.progress-bar,
.nav-tabs > li.active:after,
.menu li.current-menu-ancestor a,
.pricing-table header,
.table thead th,
.mark,
.post .post-meta button,
blockquote.style-2:after,
.panel-title a:before,
.carousel-indicators li,
.carousel-indicators .active,
.ls-michell .ls-bottom-slidebuttons a,
.site-search,
.twitter .carousel-indicators li,
.twitter .carousel-indicators li.active,
#wp-calendar td a,
.top-bar.style-2,
body .tp-bullets.simplebullets.round .bullet,
.form-submit #submit,
.testimonials blockquote header:before,
mark {
  background-color: <?php echo esc_attr($primary_color); ?>;
}

.testimonials.white blockquote header:before
{
   background-color: #fff;
}


@media (max-width: 992px) {
  .navbar-toggle,
  .nav-wrap .fa-search {
    background-color: <?php echo esc_attr($primary_color); ?>;
  }
}
h1, h2, h3, h4, h5, h6,
.nav-tabs > li > a,
.nav-tabs > li.active > a,
.statement,
.page-heading a,
.page-heading a:after,
p strong,
.dropcaps:first-letter,
.page-numbers a,
.searchform,
.searchform input[type="text"],
.socialize a,
.widget_rss .rss-date,
.widget_rss cite,
.panel-title,
.panel-group.style-2 .panel-title a.collapsed:before,
blockquote.style-1,
.comment-list .comment header,
.faq .panel-title a:before,
.faq .panel-title a.collapsed,
.filter button,
.carousel .carousel-control,
#wp-calendar #today,
input.qty,
.tab-pane .commentlist .meta {
  color: <?php echo esc_attr($headings_color); ?>;
}

.ls-michell .ls-nav-next,
.ls-michell .ls-nav-prev
{
color:#fff;
}

@media (min-width: 993px) {
  .site-navigation .sub-menu li,
  .site-navigation > div > ul > li > a,
  .site-navigation > div > ul a
  .site-navigation > ul > li > a,
  .site-navigation > ul a {
    color: <?php echo esc_attr($headings_color); ?>;
  }
}
.contact-form input[type="text"]:focus,
.contact-form textarea:focus {
  border-color: <?php echo esc_attr($headings_color); ?> !important;
}


.pricing-table header h2,
.mark.style-2,
.btn.dark,
.twitter .carousel-indicators li,
.price_slider_wrapper .ui-widget-content
{
  background-color: <?php echo esc_attr($headings_color); ?>;
}


@media (max-width: 992px) {
  .site-navigation, .site-navigation:after, .site-navigation:before {
    background-color: <?php echo esc_attr($footer_bg_color); ?>;
  }
}




body,
.alert .close,
.post header {
   font-family: <?php if($fonts2=="titillium"){echo "titillium-regular";} else {echo esc_attr($fonts2);}?>;
}

h1, h2, h3, h4, h5, h6,
.btn,
.page-heading,
.team em,
blockquote.style-1,
.tab-pane .commentlist .meta,
.wpcf7-submit,
.testimonial-footer span.user 
 {
  font-family: <?php if($fonts=="titillium"){echo "titillium-bold";} else {echo esc_attr($fonts);}?>;
}

.nav-tabs > li > a,
.site-navigation > ul a,
.tp-arr-titleholder,
.above-nav-bar.top-bar ul li
 {
    font-family: <?php if($font_navigation=="titillium"){echo "titillium-bold";} else {echo esc_attr($font_navigation);}?>;
}


.pricing-table header h2,
.pricing-table header .price,
.pricing-table header .currency,
.table thead,
h1.style-3,
h2.style-3,
h3.style-3,
h4.style-3,
h5.style-3,
h6.style-3,
.page-numbers a,
.page-numbers span,
.alert,
.comment-list .comment header
 {
  font-family: <?php if($fonts=="titillium"){echo "titillium-regular";} else {echo esc_attr($fonts);}?>;
}


.site-search #searchform-header input[type="text"]
{
 font-family: <?php if($fonts=="titillium"){echo "titillium-regular";} else {echo esc_attr($fonts);}?>;
}





/*Top Bar*/

.top-bar, .top-bar.style-2, header.site-header div.top-bar div.container ul li.widget-container ul li a, .top-bar .close {
  color: <?php echo esc_attr($top_bar_color); ?>;
}
header.site-header div.top-bar div.container ul li.widget-container ul li a:hover {
 color:  <?php echo esc_attr($hovers_color); ?>;
} 

.top-bar, .top-bar.style-2, .transparent.top-bar.open > .container  {
  background: <?php echo esc_attr($top_bar_bg_color); ?>;
}

/* footer */

.site-footer {
  background: <?php echo esc_attr($footer_bg_color); ?>;
}
.site-footer .copyright-footer {
  background: <?php echo esc_attr($copyright_footer_bg_color); ?>;
}



div.testimonials.white blockquote.item.active p,
div.testimonials.white blockquote.item.active cite a,
div.testimonials.white blockquote.item.active cite, .wpb_content_element .widget .tagcloud a
{
    color: #fff;
}


.a:hover,
.site-header a:hover,
.icon a:hover h2,
.nav-tabs > li > a:hover,
.top-bar a:hover,
.page-heading a:hover,
.menu a:hover,
.table tbody tr:hover td,
.page-numbers a:hover,
.widget-categories a:hover,
.widget_archive a:hover,
.widget_categories a:hover,
.widget_recent_entries a:hover,
.socialize a:hover,
.faq .panel-title a.collapsed:hover,
.carousel .carousel-control:hover,
a:hover h1, a:hover h2, a:hover h3, a:hover h4, a:hover h5,
.site-footer a:hover,
.ls-michell .ls-nav-next:hover,
.ls-michell .ls-nav-prev:hover,
.site-navigation > ul > li.megamenu .sub-menu .container > li a:hover,
body .tp-leftarrow.default:hover,
body .tp-rightarrow.default:hover,
.nav-wrap .fa-search:hover,
.home .nav-wrap .fa-search:hover,
.home .nav-wrap.sticky .fa-search:hover,
.icon.style-2 a:hover .fa,
.team .socialize a:hover,
.recentblog header a:hover h2,
.site-navigation > ul a:hover,
.site-navigation > div > ul > li.current_page_item > a,
.site-navigation > ul > li.current_page_item > a,
.home .site-navigation > ul > li.current-menu-item.current_page_item > a,
.scrollup a:hover,
.site-navigation.open .menu-item a:hover,
.hovercolor, i.hovercolor, .post.style-2 header i.hovercolor.fa,
article.post-sticky header:before,
.wpb_content_element .widget a:hover,
.star-rating,
.responsive .site-navigation .sub-menu a:hover,
.menu .current_page_item > a,
 .icon.style-2 .fa
{
color: <?php echo esc_attr($hovers_color); ?>;
}

.icon > a > span.fa {
    background: <?php echo esc_attr($hovers_color); ?>;
}

.filter button.selected {
  color: <?php echo esc_attr($hovers_color); ?>!important;
}


.scrollup a:hover
{border-color: <?php echo esc_attr($hovers_color); ?>;
}

.tagcloud a:hover,
.twitter .carousel-indicators li:hover,
.icon a:hover .fa,
.posts div a:hover,
#wp-calendar td a:hover,
.plus:hover, .minus:hover,
.widget_price_filter .price_slider_amount .button:hover,
.form-submit #submit:hover

{
background-color: <?php echo esc_attr($hovers_color); ?>;
}

@media (min-width: 992px) {
    nav.site-navigation > ul > li.current_page_item > a::after, nav.site-navigation > ul > li:hover > a::after, nav.site-navigation > ul > li.current-menu-parent > a::after {
        background-color: <?php echo esc_attr($hovers_color); ?>;
        bottom: 15px;
        content: "";
        height: 2px;
        left: 10px;
        position: absolute;
        width: calc(100% - 20px);
        opacity: 1;
    }
}
body {
  font-size: <?php echo esc_attr($body_font_size); ?>px;
}

h1, .h1 {
  font-size: <?php echo esc_attr($h1_font_size); ?>px;
}
h2, .h2 {
  font-size: <?php echo esc_attr($h2_font_size); ?>px;
}
h3, .h3 {
  font-size: <?php echo esc_attr($h3_font_size); ?>px;
}
h4, .h4 {
  font-size: <?php echo esc_attr($h4_font_size); ?>px;
}
h5, .h5 {
  font-size: <?php echo esc_attr($h5_font_size); ?>px;
}
.page-heading h1 {
  font-size: <?php echo esc_attr($page_heading_h1_font_size); ?>px;
  line-height: 34px;
}



.site-navigation ul > li.menu-item > a, .home .nav-wrap.sticky .fa-search
{
color: <?php echo esc_attr($menu_text_color); ?>;
font-size: <?php echo esc_attr($menu_font_size); ?>px;
}

@media (min-width: 993px) {
    .nav-wrap.sticky .site-navigation ul > li.menu-item > a {
      color: <?php echo esc_attr($menu_text_color); ?>;
    }
    .home .site-navigation > ul > li.menu-item > a, .home .nav-wrap .fa-search, body.home.boxed .nav-wrap .fa-search  {
      color: <?php echo esc_attr($anps_front_text_color); ?>;
    }
}
.site-navigation ul > li.menu-item > a:hover, .site-navigation ul > li.current_page_item > a, .nav-wrap.sticky .site-navigation ul > li.menu-item > a:hover, .nav-wrap.sticky .site-navigation ul > li.current-menu-item > a, .site-navigation.open li.current-menu-item.menu-item > a {
  color:  <?php echo esc_attr($hovers_color); ?>;
}

.home .site-navigation ul > li.menu-item > a:hover, .home .site-navigation ul > li.current_page_item > a, .home .nav-wrap .fa-search:hover, .home .site-navigation > ul > li.current-menu-item.current_page_item > a {
  color:  <?php echo esc_attr($anps_front_text_hover_color); ?>;
}



.nav-wrap, header.site-header.sticky.style-1.bg-transparent div.nav-wrap.sticky {
 background: <?php echo esc_attr($nav_background_color); ?>;
}

.home .nav-wrap {
  background: <?php echo esc_attr($anps_front_bg_color); ?>;
}

article.post-sticky header .stickymark i.nav_background_color {
  color: <?php echo esc_attr($nav_background_color); ?>;
}


.triangle-topleft.hovercolor {
  border-top: 60px solid <?php echo esc_attr($hovers_color); ?>;
}

h1.single-blog, article.post h1.single-blog{
  font-size: <?php echo esc_attr($blog_heading_h1_font_size); ?>px;
}

.home div.site-wrapper div.transparent.top-bar, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel {
   color: <?php echo esc_attr($anps_front_topbar_color); ?>;
}

.home div.site-wrapper div.transparent.top-bar a:hover, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel:hover {
   color: <?php echo esc_attr($anps_front_topbar_hover_color); ?>;
}

aside.sidebar ul.menu ul.sub-menu > li > a, aside.sidebar ul.menu > li.current-menu-ancestor > a {
  background: <?php echo esc_attr($side_submenu_background_color); ?>;
  color: <?php echo esc_attr($side_submenu_text_color); ?>;
}

aside.sidebar ul.menu ul.sub-menu > li > a:hover, aside.sidebar ul.menu li.current_page_item > a, aside.sidebar ul.menu ul.sub-menu > li.current_page_item > a, aside.sidebar ul.menu > li.current-menu-ancestor > a:hover {
  color: <?php echo esc_attr($side_submenu_text_hover_color); ?>;
}

.icon:hover h2, .icon:hover h3 {
    color: <?php echo esc_attr($icon_shortcode_text_hover_color); ?>!important;
}




<?php
  global $anps_options_data;
  if( isset($anps_options_data['hide_slider_on_mobile']) && $anps_options_data['hide_slider_on_mobile'] == 'on' ):
?>

@media (max-width: 786px) {
    .wpb_layerslider_element, .wpb_revslider_element {
        display: none;
    }
}

<?php endif; ?>


@media (max-width: 786px) {
    .home div.site-wrapper div.transparent.top-bar, .home div.site-wrapper div.transparent.top-bar #lang_sel a.lang_sel_sel {
      color: <?php echo esc_attr($top_bar_color); ?>;
    }
}

<?php

//set header dimensions
if( isset($anps_media_data['logo-height'])):

    if ( isset($anps_media_data['auto_adjust_logo']) &&  $anps_media_data['auto_adjust_logo']=='on' ) {
        $nav_top_heading = '0';
    } else {
        $nav_top_heading = ceil((($anps_media_data['logo-height']) - '72' + '23') / '2');
    }
?>

@media (min-width: 993px) {
.site-navigation {
  padding-top:0;
  padding-top: <?php echo $nav_top_heading; ?>px;
}

.nav-wrap .fa-search {
  padding-top:0;
}

.nav-wrap.sticky .site-navigation  {
  padding-top:0;
}

.nav-wrap.style-3 .site-navigation, .nav-wrap.style-3 .fa-search  {
 padding-top: 0;
}

}
@media (max-width: 992px) {
.home .nav-wrap .fa-search, .home .nav-wrap .fa-search:hover, body.home.boxed .nav-wrap .fa-search, .site-navigation ul > li.menu-item > a, .home .nav-wrap.sticky .fa-search {
  color: #fff
}
}


<?php endif;?>

<?php
//display search icon in menu?
$search_icon = get_option('search_icon', '1');
if (!$search_icon == '1') : ?>

.site-navigation .fa-search {
display:none;
}

.responsive .site-navigation > ul > li:last-child:after {
    border-right: none!important;
}
  
<?php endif; ?>

<?php $search_icon_mobile = get_option('search_icon_mobile', '1');
if (!$search_icon_mobile == '1') : ?>
.nav-wrap > .container > button.fa-search.mobile {
  display:none!important;
}
<?php endif; ?>
@media (min-width: 993px) {
  .responsive .site-navigation .sub-menu {
    background:<?php echo esc_attr($submenu_background_color); ?>;
  }
    .responsive .site-navigation .sub-menu a {
    color: <?php echo esc_attr($submenu_text_color); ?>;
  }
}

<?php
if ( isset($anps_media_data['auto_adjust_logo']) && $anps_media_data['auto_adjust_logo'] =='on' ) :?>
@media (max-width: 400px) {
    .nav-wrap .site-logo a img {
        height: 60px!important;
        width: auto;
        max-width: 175px;
    }
}
<?php endif; ?>

<?php 
echo get_option("anps_custom_css", "");