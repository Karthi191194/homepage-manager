<?php
/*
Plugin Name:  HomePage Manager.
Description:  WordPress Plugin for managing individual homepage for different themes.
Version:      1
*/
function zt_admin_menu()
{
    add_menu_page('HomePage Manager', 'HomePage Manager', 'manage_options', 'ztheme', 'zthememap');
}
add_action('admin_menu', 'zt_admin_menu');

function zthememap()
{
    require "thememap.php";
}

function z_theme_activation()
{
    $current_theme = get_option('stylesheet');
    $theme1        = get_option('zt_theme1_slug');
    $theme2        = get_option('zt_theme2_slug');
    if ($current_theme == $theme1) {
        update_option('page_on_front', get_option('zt_theme1_home_page'));
        update_option('show_on_front', 'page');
    } elseif ($current_theme == $theme2) {
        update_option('page_on_front', get_option('zt_theme2_home_page'));
        update_option('show_on_front', 'page');
    } else {
    }
}
add_action('after_setup_theme', 'z_theme_activation');

function z_custom_new_menu()
{
    register_nav_menu('v1-primary-menu', __('V1 Primary Menu'));
    register_nav_menu('v2-primary-menu', __('V2 Primary Menu'));
}
add_action('init', 'z_custom_new_menu');
