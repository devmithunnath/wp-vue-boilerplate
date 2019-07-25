<?php
/*
 * Plugin Name: Vue Plugin
 * Description: A Simple Vue Plugin
 * Version: 0.0.1
 * Author: Mithun Nath
 * Author URI: http://mithunnath.com
 *
 * */

if ( !class_exists( 'Vue Plugin' ) ){
    class VuePlugin {

        private $shortcode_name = 'vue-plugin';

        public function register () {
            add_shortcode( $this->shortcode_name, [$this, 'shortcode'] );
            add_action( 'wp_enqueue_scripts', [$this, 'scripts'] );
        }

        public function shortcode ( $atts ) {
            $wp_output = ['Test', 'Testings','Test', 'Testings','Test', 'Testings',];
            $vue_input = esc_attr(
                json_encode($wp_output)
            );
            return "<div id='vue-app' vue-data-atts='{$vue_input}'>Hey There! Loading now.....</div>";
        }

        public function scripts (){
            global $post;

            // Only enqueue scripts if we're displaying a post that contains the shortcode
            if( has_shortcode( $post->post_content, $this->shortcode_name ) ) {
                wp_enqueue_script( 'vue', 'https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js', [], '2.5.16' );
                wp_enqueue_script( 'vue-plugin', plugin_dir_url( __FILE__ ) . 'frontend/js/script.js', [], '0.1', true );
                wp_enqueue_style( 'vue-plugin', plugin_dir_url( __FILE__ ) . 'frontend/css/style.css', [], '0.1' );
            }
        }

    }
    (new VuePlugin())->register();
}