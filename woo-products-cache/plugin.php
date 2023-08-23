<?php
/**
 * Plugin Name: Products Cache
 * Author: Mircea Rechesan
 * Description: Utility plugin. Used for later imports on stocks
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author URI:        https://github.com/mircearek
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/mircearek
 * Text Domain:       mrc-woo-products-cache
 * 
 */


define( 'MRCREK_PRODUCTS_PLUGIN_DIR', __DIR__ );

require_once( 'includes/products_cache_ajax.php' );
require_once( 'includes/scripts.php' );
require_once( 'includes/settings.php' );