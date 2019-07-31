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
        private $plugin_dir = ABSPATH . 'wp-content/plugins/vue-plugin/';


        public function __construct () {
            $this->acf_install();
            $this->acf_options();
            $this->actions_and_filters();
        }

        public function actions_and_filters(){
            add_filter('acf/settings/save_json', array($this, 'acf_json_save_point'));
            add_filter('acf/settings/load_json', array($this, 'acf_json_load_point'));
        }

        function acf_json_save_point( $path ) {
            $paths = plugin_dir_path( __FILE__ ) . '/backend/acf/acf-json';
            return $paths;
        }

        function acf_json_load_point( $paths ) {
            $paths[] = plugin_dir_path( __FILE__ ) . '/backend/acf/acf-json';
            return $paths;
        }

        public function register () {
            add_shortcode( $this->shortcode_name, [$this, 'shortcode'] );
            add_action( 'wp_enqueue_scripts', [$this, 'scripts'] );
            //add_action('acf/render_field_settings/type=image', [$this, 'acf_add_default_image']);
        }

        public function shortcode ( $atts ) {
            $wp_output = ['Test', 'Testings','Test', 'Testings','Test', 'Testings',];
            $vue_input = esc_attr(
                json_encode($wp_output)
            );
            // return "<div id='vue-app' vue-data-atts='{$vue_input}'>Hey There! Loading now.....</div>";
            readfile( plugin_dir_path( __FILE__ ) . '/frontend/hello-world/dist/index.html' );
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

        protected function acf_install(){
            // Set up ACF
            add_filter('acf/settings/path', function() {
                return sprintf("%s/backend/acf/plugin/", dirname(__FILE__));
            });
            add_filter('acf/settings/dir', function() {
                return sprintf("%s/backend/acf/plugin/", plugin_dir_url(__FILE__));
            });
            require_once(sprintf("%s/backend/acf/plugin/acf.php", dirname(__FILE__)));
        }

        protected function acf_options() {
            $parent = acf_add_options_page(array(
                'page_title' 	=> 'Vue Plugin - Workflow',
                'post_id' => 'vue-plugin',
                'menu_title' 	=> 'Workflow',
                'menu_slug' 	=> 'vue-plugin',
                'capability' 	=> 'edit_posts',
                'icon_url' => 'dashicons-camera',
                'position' => 7,
                'redirect' 	=> false,
            ));

            acf_add_options_sub_page(array(
                'page_title' 	=> 'Services',
                'menu_title' 	=> 'Services',
                'parent_slug' 	=> $parent['menu_slug'],
            ));
        }

        protected function acf_add_default_image($field) {
            acf_render_field_setting( $field, array(
                'label'			=> 'Default Image',
                'instructions'		=> 'Appears when creating a new post',
                'type'			=> 'image',
                'name'			=> 'default_value',
            ));
        }

    }
    (new VuePlugin())->register();
}