<?php
/*
 * ACF Options
 *
 * @package esc_mod
 * */

/*
 * Theme Gate Keeper
 * */

if( ! defined( 'ABSPATH' )) {
    exit;
}


/*
 * Options Page Configuration
 *
 * */

if( function_exists('acf_add_options_page') ) {

    $parent = acf_add_options_page(array(
        'page_title' 	=> 'Semi-Custom: General Theme Settings',
        'menu_title' 	=> 'Semi-Custom',
        'menu_slug' 	=> 'semi-custom-settings',
        'capability' 	=> 'edit_posts',
        'redirect' 	=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Header Settings',
        'menu_title' 	=> 'Header',
        'parent_slug' 	=> $parent['menu_slug'],
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Footer Settings',
        'menu_title' 	=> 'Footer',
        'parent_slug' 	=> $parent['menu_slug'],
    ));

}

/*
 * Default Image for the Image Field
 *
 * */

add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field');
function add_default_value_to_image_field($field) {
    acf_render_field_setting( $field, array(
        'label'			=> 'Default Image',
        'instructions'		=> 'Appears when creating a new post',
        'type'			=> 'image',
        'name'			=> 'default_value',
    ));
}

