<?php
/**
 * Settings management
 *
 * @package NonyLabs_Companion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NonyLabs_Companion_Settings {
    
    public static function init() {
        add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
    }
    
    public static function register_settings() {
        // General settings
        register_setting( 'nonylabs_general', 'nony_nav_logo_text', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'nony.cc',
        ) );
        
        register_setting( 'nonylabs_general', 'nony_site_title', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'Nony Portfolio',
        ) );
        
        register_setting( 'nonylabs_general', 'nony_footer_brand_text', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'nony.cc',
        ) );
        
        register_setting( 'nonylabs_general', 'nony_footer_tagline', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'Made with chaos & caffeine',
        ) );
        
        register_setting( 'nonylabs_general', 'nony_footer_copyright', array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => '© 2025 nony.cc - no corporate vibes allowed',
        ) );
        
        // Profile badges
        register_setting( 'nonylabs_badges', 'nony_profile_badges', array(
            'type' => 'array',
            'sanitize_callback' => array( __CLASS__, 'sanitize_badges' ),
        ) );
        
        // Social links
        register_setting( 'nonylabs_social', 'nony_social_links', array(
            'type' => 'array',
            'sanitize_callback' => array( __CLASS__, 'sanitize_social_links' ),
        ) );
    }
    
    public static function sanitize_badges( $badges ) {
        if ( ! is_array( $badges ) ) {
            return array();
        }
        
        $sanitized = array();
        foreach ( $badges as $badge ) {
            if ( ! empty( $badge['text'] ) ) {
                $sanitized[] = array(
                    'text' => sanitize_text_field( $badge['text'] ),
                );
            }
        }
        
        return $sanitized;
    }
    
    public static function sanitize_social_links( $links ) {
        if ( ! is_array( $links ) ) {
            return array();
        }
        
        $sanitized = array();
        foreach ( $links as $link ) {
            if ( ! empty( $link['url'] ) ) {
                $sanitized[] = array(
                    'platform' => sanitize_text_field( $link['platform'] ?? '' ),
                    'url' => esc_url_raw( $link['url'] ),
                    'username' => sanitize_text_field( $link['username'] ?? '' ),
                    'icon' => sanitize_text_field( $link['icon'] ?? 'ri-link' ),
                    'color_start' => sanitize_hex_color( $link['color_start'] ?? '#667eea' ),
                    'color_end' => sanitize_hex_color( $link['color_end'] ?? '#764ba2' ),
                );
            }
        }
        
        return $sanitized;
    }
}
