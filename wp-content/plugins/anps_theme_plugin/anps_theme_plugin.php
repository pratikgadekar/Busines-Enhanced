<?php
/*
Plugin Name: Anps Theme plugin
Plugin URI: http://www.anpsthemes.com
Description: Anps theme plugin
Author: Anpsthemes
Version: 1.0.0
Author URI: http://www.anpsthemes.com
*/
if(!defined('WPINC')) {
    die;
}
/* Portfolio */
include_once 'portfolio.php';
add_action('init', 'anps_portfolio');
function anps_portfolio() {
    new Portfolio();
}
/* Team */
include_once 'team.php';
add_action('init', 'anps_team');
function anps_team() {
    new Team();
}