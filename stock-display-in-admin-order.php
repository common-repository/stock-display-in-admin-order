<?php

/**
* Plugin Name: Stock Display in Admin Order
* Plugin URI: https://bolovocode.com/stock-display-in-admin-order
* Description: Display the item stock level, or status, inside the order page on admin side.
* Version: 1.0.0
* Requires at least: 5.6
* Requires PHP: 7.0
* Author: Bolovo Code
* Author URI: https://bolovocode.com/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: bolovo-wsdao-td
* Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists( 'Bolovo_WSDAO_Main' ) ) {

    class Bolovo_WSDAO_Main{
        public function __construct() {

            // Define constants used througout the plugin.
            $this->define_constants();
            // Set Text Domain for translations.
            $this->load_textdomain();

            require_once( BOLOVO_WSDAO_PATH . 'functions/functions.php' );

            add_filter( 'plugin_row_meta', array( $this, 'add_sponsor_link' ), 10, 2 );

        }

        /**
         * Define Constants
         */
        public function define_constants(){
            // Path/URL to root of this plugin, with trailing slash.
            define ( 'BOLOVO_WSDAO_PATH', plugin_dir_path( __FILE__ ) );
            define ( 'BOLOVO_WSDAO_URL', plugin_dir_url( __FILE__ ) );
            define ( 'BOLOVO_WSDAO_VERSION', '1.0.0' );
        }

        /**
         * Activate the plugin
         */
        public static function activate(){

        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate(){
            flush_rewrite_rules();
        }

        /**
         * Uninstall the plugin
         */
        public static function uninstall(){

        }

        public function load_textdomain(){
            load_plugin_textdomain(
                'bolovo-wsdao-td',
                false,
                dirname( plugin_basename( __FILE__ ) ) . '/languages/'
            );
        }

        /**
         * Add Sponsor link
         */
        public function add_sponsor_link( array $plugin_meta, $plugin_file ) {
            if ( 'stock-display-in-admin-order/stock-display-in-admin-order.php' !== $plugin_file ) {
                return $plugin_meta;
            }

            $plugin_meta[] = sprintf(
                '<a href="%1$s"><span class="dashicons dashicons-coffee" aria-hidden="true" style="font-size:14px;line-height:1.3"></span>%2$s</a>',
                'https://www.buymeacoffee.com/bolovocode',
                esc_html__( 'Liked it? Buy me a coffee.', 'bolovo-wsdao-td' )
            );

            return $plugin_meta;
        }

    }
}

if( class_exists( 'Bolovo_WSDAO_Main' ) ){
    // Installation and uninstallation hooks
    register_activation_hook( __FILE__, array( 'Bolovo_WSDAO_Main', 'activate'));
    register_deactivation_hook( __FILE__, array( 'Bolovo_WSDAO_Main', 'deactivate'));
    register_uninstall_hook( __FILE__, array( 'Bolovo_WSDAO_Main', 'uninstall' ) );

    $waoi = new Bolovo_WSDAO_Main();
}
