<?php
/**
 * Admin functionality
 *
 * @package NonyLabs_Companion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NonyLabs_Companion_Admin {
    
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ) );
        add_action( 'admin_head', array( __CLASS__, 'admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );
        add_action( 'admin_notices', array( __CLASS__, 'theme_compatibility_notice' ) );
    }
    
    public static function add_admin_menu() {
        add_menu_page(
            __( 'NonyLabs Settings', 'nonylabs-companion' ),
            __( 'NonyLabs', 'nonylabs-companion' ),
            'manage_options',
            'nonylabs-settings',
            array( __CLASS__, 'general_settings_page' ),
            'dashicons-admin-customizer',
            61
        );
        
        add_submenu_page(
            'nonylabs-settings',
            __( 'General Settings', 'nonylabs-companion' ),
            __( 'General', 'nonylabs-companion' ),
            'manage_options',
            'nonylabs-settings',
            array( __CLASS__, 'general_settings_page' )
        );
        
        add_submenu_page(
            'nonylabs-settings',
            __( 'Profile Badges', 'nonylabs-companion' ),
            __( 'Profile Badges', 'nonylabs-companion' ),
            'manage_options',
            'nonylabs-badges',
            array( __CLASS__, 'badges_page' )
        );
        
        add_submenu_page(
            'nonylabs-settings',
            __( 'Social Links', 'nonylabs-companion' ),
            __( 'Social Links', 'nonylabs-companion' ),
            'manage_options',
            'nonylabs-social',
            array( __CLASS__, 'social_page' )
        );
    }
    
    public static function enqueue_admin_scripts( $hook ) {
        if ( strpos( $hook, 'nonylabs' ) === false ) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );
    }
    
    public static function admin_styles() {
        $screen = get_current_screen();
        if ( ! $screen || strpos( $screen->id, 'nonylabs' ) === false ) {
            return;
        }
        ?>
        <style>
            .nonylabs-admin-wrap {
                max-width: 1200px;
                margin: 20px 0;
            }
            .nonylabs-admin-card {
                background: #fff;
                border: 1px solid #ccd0d4;
                border-radius: 8px;
                padding: 24px;
                margin-bottom: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,.04);
            }
            .nonylabs-admin-card h2 {
                margin-top: 0;
                padding-bottom: 12px;
                border-bottom: 2px solid #f0f0f1;
                font-size: 18px;
            }
            .nonylabs-badge-item, .nonylabs-social-item {
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 16px;
                margin-bottom: 12px;
                display: flex;
                gap: 12px;
                align-items: center;
                transition: all 0.2s;
            }
            .nonylabs-badge-item:hover, .nonylabs-social-item:hover {
                background: #f0f0f1;
                border-color: #c3c4c7;
            }
            .nonylabs-badge-item input, .nonylabs-social-item input {
                flex: 1;
            }
            .nonylabs-badge-item .button, .nonylabs-social-item .button {
                flex-shrink: 0;
            }
            .nonylabs-add-button {
                margin-top: 12px;
            }
            .nonylabs-preview {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 32px;
                border-radius: 12px;
                color: white;
                margin-top: 20px;
            }
            .nonylabs-preview h3 {
                margin-top: 0;
                font-size: 16px;
                opacity: 0.9;
            }
            .nonylabs-preview-badges {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                margin-top: 16px;
            }
            .nonylabs-preview-badge {
                background: rgba(255,255,255,0.15);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.25);
                padding: 10px 18px;
                border-radius: 24px;
                font-size: 14px;
                font-weight: 500;
            }
            .nonylabs-social-preview {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 16px;
                margin-top: 16px;
            }
            .nonylabs-social-preview-card {
                background: rgba(255,255,255,0.15);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.25);
                padding: 20px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .nonylabs-social-preview-icon {
                width: 56px;
                height: 56px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                flex-shrink: 0;
            }
            .nonylabs-social-preview-content h4 {
                margin: 0 0 4px 0;
                font-size: 16px;
                font-weight: 600;
            }
            .nonylabs-social-preview-content p {
                margin: 0;
                font-size: 13px;
                opacity: 0.9;
            }
            .nonylabs-color-picker-group {
                display: flex;
                gap: 12px;
                align-items: center;
            }
            .nonylabs-help-text {
                background: #f0f6fc;
                border-left: 4px solid #0073aa;
                padding: 12px 16px;
                margin: 16px 0;
                border-radius: 4px;
            }
            .nonylabs-help-text p {
                margin: 0;
                font-size: 13px;
                line-height: 1.6;
            }
        </style>
        <?php
    }
    
    public static function general_settings_page() {
        include NONYLABS_COMPANION_PATH . 'templates/admin-general.php';
    }
    
    public static function badges_page() {
        include NONYLABS_COMPANION_PATH . 'templates/admin-badges.php';
    }
    
    public static function social_page() {
        include NONYLABS_COMPANION_PATH . 'templates/admin-social.php';
    }
    
    public static function theme_compatibility_notice() {
        $theme = wp_get_theme();
        $compatible_themes = array( 'nony-portfolio', 'Nony Portfolio' );
        
        if ( ! in_array( $theme->get( 'Name' ), $compatible_themes ) && ! in_array( $theme->get( 'TextDomain' ), $compatible_themes ) ) {
            ?>
            <div class="notice notice-info">
                <p>
                    <strong><?php _e( 'NonyLabs Companion', 'nonylabs-companion' ); ?>:</strong>
                    <?php _e( 'This plugin works best with NonyLabs themes. Some features may not work with your current theme.', 'nonylabs-companion' ); ?>
                </p>
            </div>
            <?php
        }
    }
}
