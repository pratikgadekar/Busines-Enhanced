<?php 
    header("Content-type: text/css; charset: UTF-8"); 
    require_once('../../../../wp-load.php'); 

    /*buttons*/
    $default_button_bg = get_option('default_button_bg', '#26507a');
    $default_button_color = get_option('default_button_color', '#fff');
    $default_button_hover_bg = get_option('default_button_hover_bg', '#3178bf');
    $default_button_hover_color = get_option('default_button_hover_color', '#fff');

    $style_1_button_bg = get_option('style_1_button_bg', '#26507a');
    $style_1_button_color = get_option('style_1_button_color', '#fff');
    $style_1_button_hover_bg = get_option('style_1_button_hover_bg', '#3178bf');
    $style_1_button_hover_color = get_option('style_1_button_hover_color', '#fff');

    $style_2_button_bg = get_option('style_2_button_bg', '#000000');
    $style_2_button_color = get_option('style_2_button_color', '#fff');
    $style_2_button_hover_bg = get_option('style_2_button_hover_bg', '#ffffff');
    $style_2_button_hover_color = get_option('style_2_button_hover_color', '#fff');

    $style_3_button_color = get_option('style_3_button_color', '#26507a');
    $style_3_button_hover_bg = get_option('style_3_button_hover_bg', '#26507a');
    $style_3_button_hover_color = get_option('style_3_button_hover_color', '#fff');
    $style_3_button_border_color = get_option('style_3_button_border_color', '#26507a');

    $style_4_button_color = get_option('style_4_button_color', '#26507a');
    $style_4_button_hover_color = get_option('style_4_button_hover_color', '#3178bf');

    $style_slider_button_bg = get_option('style_slider_button_bg', '#26507a');
    $style_slider_button_color = get_option('style_slider_button_color', '#fff');
    $style_slider_button_hover_bg = get_option('style_slider_button_hover_bg', '#3178bf');
    $style_slider_button_hover_color = get_option('style_slider_button_hover_color', '#fff');

    $style_style_5_button_bg = get_option('style_style_5_button_bg', '#c3c3c3');
    $style_style_5_button_color = get_option('style_style_5_button_color', '#fff');
    $style_style_5_button_hover_bg = get_option('style_style_5_button_hover_bg', '#737373');
    $style_style_5_button_hover_color = get_option('style_style_5_button_hover_color', '#fff');
 ?>


/*buttons*/

.btn, .wpcf7-submit {
    -moz-user-select: none;
    background-image: none;
    border: 0;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    font-weight: normal;
    line-height: 1.5;
    margin-bottom: 0;
    text-align: center;
    text-transform: uppercase;
    text-decoration:none;
    transition: background-color 0.2s ease 0s;
    vertical-align: middle;
    white-space: nowrap;
}

.btn.btn-sm, .wpcf7-submit {
    padding: 11px 17px;
    font-size: 14px;
}

.btn {
  border-radius: 0;
  border-radius: 4px;
  background:  <?php echo esc_attr($default_button_bg); ?>;
  color: <?php echo esc_attr($default_button_color); ?>;
}
.btn:hover, .btn:active, .btn:focus {
  border-radius: 0;
  border-radius: 4px;
  background:  <?php echo esc_attr($default_button_hover_bg); ?>;
  color: <?php echo esc_attr($default_button_hover_color); ?>;
}

 .wpcf7-submit {
  color: <?php echo esc_attr($style_4_button_color); ?>;
  background: transparent;
}

.btn:hover, .btn:active, .btn:focus {
  background-color: <?php echo esc_attr($default_button_hover_bg); ?>;
  color: <?php echo esc_attr($default_button_hover_color); ?>;
  border:0;
}

.wpcf7-submit:hover, .wpcf7-submit:active, .wpcf7-submit:focus {
color: <?php echo esc_attr($style_4_button_hover_color); ?>;
 background: transparent;
}

.btn.style-1, .vc_btn.style-1   { 
  border-radius: 4px;
  background-color: <?php echo esc_attr($style_1_button_bg); ?>;
  color: <?php echo esc_attr($style_1_button_color); ?>!important;
}
.btn.style-1:hover, .btn.style-1:active, .btn.style-1:focus, .vc_btn.style-1:hover, .vc_btn.style-1:active, .vc_btn.style-1:focus  {
  background-color: <?php echo esc_attr($style_1_button_hover_bg); ?>;
  color: <?php echo esc_attr($style_1_button_hover_color); ?>!important;
}


.btn.slider  { 
  border-radius: 4px;
  background-color: <?php echo esc_attr($style_slider_button_bg); ?>;
  color: <?php echo esc_attr($style_slider_button_color); ?>;
}
.btn.slider:hover, .btn.slider:active, .btn.slider:focus  {
  background-color: <?php echo esc_attr($style_slider_button_hover_bg); ?>;
  color: <?php echo esc_attr($style_slider_button_hover_color); ?>;
}




.btn.style-2, .vc_btn.style-2  {
  border-radius: 4px;
  border: 2px solid <?php echo esc_attr($style_2_button_bg); ?>;
  background-color: <?php echo esc_attr($style_2_button_bg); ?>;
  color: <?php echo esc_attr($style_2_button_color); ?>!important;
}

.btn.style-2:hover, .btn.style-2:active, .btn.style-2:focus, .vc_btn.style-2:hover, .vc_btn.style-2:active, .vc_btn.style-2:focus   {
  background-color: <?php echo esc_attr($style_2_button_hover_bg); ?>;
  color: <?php echo esc_attr($style_2_button_hover_color); ?>!important;
  border-color: <?php echo esc_attr($style_2_button_bg); ?>;
  border: 2px solid <?php echo esc_attr($style_2_button_bg); ?>;
}

.btn.style-3, .vc_btn.style-3  {
  border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;;
  border-radius: 4px;
  background-color: transparent;
  color: <?php echo esc_attr($style_3_button_color); ?>!important;
}
.btn.style-3:hover, .btn.style-3:active, .btn.style-3:focus, .vc_btn.style-3:hover, .vc_btn.style-3:active, .vc_btn.style-3:focus  {
  border: 2px solid <?php echo esc_attr($style_3_button_border_color); ?>;
  background-color: <?php echo esc_attr($style_3_button_hover_bg); ?>;
  color: <?php echo esc_attr($style_3_button_hover_color); ?>!important;
}

.btn.style-4, .vc_btn.style-4   {
  padding-left: 0;
  background-color: transparent;
  color: <?php echo esc_attr($style_4_button_color); ?>!important;
  border: none;
}

.btn.style-4:hover, .btn.style-4:active, .btn.style-4:focus, .vc_btn.style-4:hover, .vc_btn.style-4:active, .vc_btn.style-4:focus   {
  padding-left: 0;
  background: none;
  color: <?php echo esc_attr($style_4_button_hover_color); ?>!important;
  border: none;
  border-color: transparent;
  outline: none;
}

.btn.style-5, .vc_btn.style-5   {
  background-color: <?php echo esc_attr($style_style_5_button_bg); ?>!important;
  color: <?php echo esc_attr($style_style_5_button_color); ?>!important;
  border: none;
}

.btn.style-5:hover, .btn.style-5:active, .btn.style-5:focus, .vc_btn.style-5:hover, .vc_btn.style-5:active, .vc_btn.style-5:focus   {
  background-color: <?php echo esc_attr($style_style_5_button_hover_bg); ?>!important;
  color: <?php echo esc_attr($style_style_5_button_hover_color); ?>!important;
}
