<?php
/*
 * ACF Setup
 *
 * @package esc_mod
 * */

/*
 * Theme Gate Keeper
 * */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists( 'Acf_Loader' ) ) {
    class Acf_Loader {
        public function __construct() {
            // Set up ACF
            add_filter('acf/settings/path', function() {
                return sprintf("%s/backend/acf/plugin/", dirname(__FILE__));
            });
            add_filter('acf/settings/dir', function() {
                return sprintf("%s/backend/acf/plugin/", plugin_dir_url(__FILE__));
            });
            require_once(sprintf("%s/backend/acf/plugin/acf.php", dirname(__FILE__)));
        }
    }
    (new Acf_Loader());
}