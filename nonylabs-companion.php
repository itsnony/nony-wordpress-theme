<?php
/**
 * Plugin Name: NonyLabs Companion
 * Plugin URI: https://nonylabs.cc
 * Description: Essential companion plugin for NonyLabs themes with advanced customization options
 * Version: 1.0.0
 * Author: NonyLabs
 * Author URI: https://nonylabs.cc
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: nonylabs-companion
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'NONYLABS_COMPANION_VERSION', '1.0.0' );
define( 'NONYLABS_COMPANION_PATH', plugin_dir_path( __FILE__ ) );
define( 'NONYLABS_COMPANION_URL', plugin_dir_url( __FILE__ ) );
define( 'NONYLABS_COMPANION_FILE', __FILE__ );

// Include core files
require_once NONYLABS_COMPANION_PATH . 'includes/class-admin.php';
require_once NONYLABS_COMPANION_PATH . 'includes/class-shortcodes.php';
require_once NONYLABS_COMPANION_PATH . 'includes/class-settings.php';

// Initialize plugin
function nonylabs_companion_init() {
    // Load text domain
    load_plugin_textdomain( 'nonylabs-companion', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    
    // Initialize classes
    NonyLabs_Companion_Admin::init();
    NonyLabs_Companion_Shortcodes::init();
    NonyLabs_Companion_Settings::init();
}
add_action( 'plugins_loaded', 'nonylabs_companion_init' );

// Activation hook
function nonylabs_companion_activate() {
    // Set default options
    $defaults = array(
        'nony_nav_logo_text' => 'nony.cc',
        'nony_site_title' => 'Nony Portfolio',
        'nony_footer_brand_text' => 'nony.cc',
        'nony_footer_tagline' => 'Made with chaos & caffeine',
        'nony_footer_copyright' => '© 2025 nony.cc - no corporate vibes allowed',
        'nony_profile_badges' => array(
            array( 'text' => '16 y/o' ),
            array( 'text' => '🇩🇪 Germany' ),
            array( 'text' => '💀 Horror Fan' ),
            array( 'text' => '@xequence' ),
        ),
        'nony_social_links' => array(
            array( 'platform' => 'Bluesky', 'url' => 'https://bsky.app/profile/itsnony.bsky.social', 'username' => '@itsnony.bsky.social', 'icon' => 'ri-bluesky-fill', 'color_start' => '#0085ff', 'color_end' => '#00a3ff' ),
            array( 'platform' => 'Discord', 'url' => 'https://discord.com/users/937712557471457311', 'username' => "Let's chat!", 'icon' => 'ri-discord-fill', 'color_start' => '#7289da', 'color_end' => '#99aab5' ),
            array( 'platform' => 'GitHub', 'url' => 'https://github.com/itsnony', 'username' => '@itsnony', 'icon' => 'ri-github-fill', 'color_start' => '#333', 'color_end' => '#666' ),
        ),
    );
    
    foreach ( $defaults as $key => $value ) {
        if ( false === get_option( $key ) ) {
            add_option( $key, $value );
        }
    }
    
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'nonylabs_companion_activate' );

// Deactivation hook
function nonylabs_companion_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'nonylabs_companion_deactivate' );
