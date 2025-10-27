<?php
/**
 * Setup Wizard
 *
 * @package NonyLabs_Companion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NonyLabs_Companion_Wizard {
    
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'add_wizard_page' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_wizard_scripts' ) );
        add_action( 'wp_ajax_nonylabs_wizard_save_step', array( __CLASS__, 'save_wizard_step' ) );
        add_action( 'wp_ajax_nonylabs_wizard_skip', array( __CLASS__, 'skip_wizard' ) );
    }
    
    public static function add_wizard_page() {
        add_submenu_page(
            null, // Hidden from menu
            __( 'NonyLabs Setup Wizard', 'nonylabs-companion' ),
            __( 'Setup Wizard', 'nonylabs-companion' ),
            'manage_options',
            'nonylabs-wizard',
            array( __CLASS__, 'render_wizard' )
        );
    }
    
    public static function enqueue_wizard_scripts( $hook ) {
        if ( $hook !== 'admin_page_nonylabs-wizard' ) {
            return;
        }
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        
        wp_enqueue_script(
            'nonylabs-wizard',
            NONYLABS_COMPANION_URL . 'assets/js/wizard.js',
            array( 'jquery', 'wp-color-picker' ),
            NONYLABS_COMPANION_VERSION,
            true
        );
        
        wp_localize_script( 'nonylabs-wizard', 'nonyLabsWizard', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'nonylabs_wizard_nonce' ),
        ) );
    }
    
    public static function render_wizard() {
        $completed = get_option( 'nonylabs_wizard_completed', false );
        ?>
        <div class="nonylabs-wizard-wrap">
            <div class="nonylabs-wizard-container">
                <div class="nonylabs-wizard-header">
                    <h1><?php _e( 'Welcome to NonyLabs!', 'nonylabs-companion' ); ?></h1>
                    <p><?php _e( 'Let\'s set up your portfolio in just a few steps', 'nonylabs-companion' ); ?></p>
                </div>
                
                <div class="nonylabs-wizard-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 0%"></div>
                    </div>
                    <div class="progress-steps">
                        <span class="step active" data-step="1">1</span>
                        <span class="step" data-step="2">2</span>
                        <span class="step" data-step="3">3</span>
                        <span class="step" data-step="4">4</span>
                    </div>
                </div>
                
                <!-- Step 1: Welcome -->
                <div class="wizard-step active" data-step="1">
                    <h2><?php _e( 'Welcome!', 'nonylabs-companion' ); ?></h2>
                    <p><?php _e( 'This wizard will help you configure your portfolio theme. You can always change these settings later from the NonyLabs settings page.', 'nonylabs-companion' ); ?></p>
                    
                    <div class="wizard-features">
                        <div class="feature-card">
                            <span class="dashicons dashicons-admin-customizer"></span>
                            <h3><?php _e( 'Easy Customization', 'nonylabs-companion' ); ?></h3>
                            <p><?php _e( 'Customize your profile, badges, and social links', 'nonylabs-companion' ); ?></p>
                        </div>
                        <div class="feature-card">
                            <span class="dashicons dashicons-admin-appearance"></span>
                            <h3><?php _e( 'Beautiful Design', 'nonylabs-companion' ); ?></h3>
                            <p><?php _e( 'Glassmorphic design with smooth animations', 'nonylabs-companion' ); ?></p>
                        </div>
                        <div class="feature-card">
                            <span class="dashicons dashicons-smartphone"></span>
                            <h3><?php _e( 'Fully Responsive', 'nonylabs-companion' ); ?></h3>
                            <p><?php _e( 'Looks great on all devices', 'nonylabs-companion' ); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: General Settings -->
                <div class="wizard-step" data-step="2">
                    <h2><?php _e( 'General Settings', 'nonylabs-companion' ); ?></h2>
                    <p><?php _e( 'Set up your basic site information', 'nonylabs-companion' ); ?></p>
                    
                    <table class="form-table">
                        <tr>
                            <th><label for="wizard_nav_logo"><?php _e( 'Navigation Logo Text', 'nonylabs-companion' ); ?></label></th>
                            <td>
                                <input type="text" id="wizard_nav_logo" class="regular-text" 
                                       value="<?php echo esc_attr( get_option( 'nony_nav_logo_text', 'nony.cc' ) ); ?>" />
                                <p class="description"><?php _e( 'The text displayed in your navigation bar', 'nonylabs-companion' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="wizard_site_title"><?php _e( 'Site Title', 'nonylabs-companion' ); ?></label></th>
                            <td>
                                <input type="text" id="wizard_site_title" class="regular-text" 
                                       value="<?php echo esc_attr( get_option( 'nony_site_title', 'Nony Portfolio' ) ); ?>" />
                                <p class="description"><?php _e( 'Your portfolio site title', 'nonylabs-companion' ); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Step 3: Profile Badges -->
                <div class="wizard-step" data-step="3">
                    <h2><?php _e( 'Profile Badges', 'nonylabs-companion' ); ?></h2>
                    <p><?php _e( 'Add badges to display on your homepage', 'nonylabs-companion' ); ?></p>
                    
                    <div id="wizard-badges-container">
                        <?php
                        $badges = get_option( 'nony_profile_badges', array() );
                        if ( empty( $badges ) ) {
                            $badges = array(
                                array( 'text' => '16 y/o' ),
                                array( 'text' => '🇩🇪 Germany' ),
                                array( 'text' => '💀 Horror Fan' ),
                                array( 'text' => '@xequence' ),
                            );
                        }
                        foreach ( $badges as $index => $badge ) :
                        ?>
                        <div class="wizard-badge-item">
                            <input type="text" class="regular-text wizard-badge-text" 
                                   value="<?php echo esc_attr( $badge['text'] ); ?>" 
                                   placeholder="<?php _e( 'Badge text', 'nonylabs-companion' ); ?>" />
                            <button type="button" class="button wizard-remove-badge"><?php _e( 'Remove', 'nonylabs-companion' ); ?></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button button-secondary" id="wizard-add-badge">
                        <?php _e( '+ Add Badge', 'nonylabs-companion' ); ?>
                    </button>
                </div>
                
                <!-- Step 4: Social Links -->
                <div class="wizard-step" data-step="4">
                    <h2><?php _e( 'Social Links', 'nonylabs-companion' ); ?></h2>
                    <p><?php _e( 'Add your social media profiles', 'nonylabs-companion' ); ?></p>
                    
                    <div id="wizard-social-container">
                        <?php
                        $social_links = get_option( 'nony_social_links', array() );
                        if ( empty( $social_links ) ) {
                            $social_links = array(
                                array( 'platform' => 'Bluesky', 'url' => '', 'username' => '', 'icon' => 'ri-bluesky-fill', 'color_start' => '#0085ff', 'color_end' => '#00a3ff' ),
                                array( 'platform' => 'Discord', 'url' => '', 'username' => '', 'icon' => 'ri-discord-fill', 'color_start' => '#7289da', 'color_end' => '#99aab5' ),
                                array( 'platform' => 'GitHub', 'url' => '', 'username' => '', 'icon' => 'ri-github-fill', 'color_start' => '#333', 'color_end' => '#666' ),
                            );
                        }
                        foreach ( $social_links as $index => $link ) :
                        ?>
                        <div class="wizard-social-item">
                            <input type="text" class="regular-text wizard-social-platform" 
                                   value="<?php echo esc_attr( $link['platform'] ); ?>" 
                                   placeholder="<?php _e( 'Platform name', 'nonylabs-companion' ); ?>" />
                            <input type="url" class="regular-text wizard-social-url" 
                                   value="<?php echo esc_url( $link['url'] ); ?>" 
                                   placeholder="<?php _e( 'Profile URL', 'nonylabs-companion' ); ?>" />
                            <input type="text" class="regular-text wizard-social-username" 
                                   value="<?php echo esc_attr( $link['username'] ); ?>" 
                                   placeholder="<?php _e( 'Username', 'nonylabs-companion' ); ?>" />
                            <button type="button" class="button wizard-remove-social"><?php _e( 'Remove', 'nonylabs-companion' ); ?></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button button-secondary" id="wizard-add-social">
                        <?php _e( '+ Add Social Link', 'nonylabs-companion' ); ?>
                    </button>
                </div>
                
                <div class="wizard-actions">
                    <button type="button" class="button button-secondary wizard-skip">
                        <?php _e( 'Skip Setup', 'nonylabs-companion' ); ?>
                    </button>
                    <div class="wizard-nav-buttons">
                        <button type="button" class="button wizard-prev" style="display: none;">
                            <?php _e( 'Previous', 'nonylabs-companion' ); ?>
                        </button>
                        <button type="button" class="button button-primary wizard-next">
                            <?php _e( 'Next', 'nonylabs-companion' ); ?>
                        </button>
                        <button type="button" class="button button-primary wizard-finish" style="display: none;">
                            <?php _e( 'Finish Setup', 'nonylabs-companion' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            .nonylabs-wizard-wrap {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                padding: 40px 20px;
                margin-left: -20px;
            }
            .nonylabs-wizard-container {
                max-width: 800px;
                margin: 0 auto;
                background: white;
                border-radius: 16px;
                padding: 40px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            }
            .nonylabs-wizard-header {
                text-align: center;
                margin-bottom: 40px;
            }
            .nonylabs-wizard-header h1 {
                font-size: 32px;
                margin: 0 0 10px 0;
                color: #1e293b;
            }
            .nonylabs-wizard-header p {
                font-size: 16px;
                color: #64748b;
                margin: 0;
            }
            .nonylabs-wizard-progress {
                margin-bottom: 40px;
            }
            .progress-bar {
                height: 8px;
                background: #e2e8f0;
                border-radius: 4px;
                overflow: hidden;
                margin-bottom: 20px;
            }
            .progress-fill {
                height: 100%;
                background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
                transition: width 0.3s ease;
            }
            .progress-steps {
                display: flex;
                justify-content: space-between;
                max-width: 400px;
                margin: 0 auto;
            }
            .progress-steps .step {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                color: #64748b;
                transition: all 0.3s ease;
            }
            .progress-steps .step.active {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                transform: scale(1.1);
            }
            .progress-steps .step.completed {
                background: #10b981;
                color: white;
            }
            .wizard-step {
                display: none;
                animation: fadeIn 0.3s ease;
            }
            .wizard-step.active {
                display: block;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .wizard-step h2 {
                font-size: 24px;
                margin: 0 0 10px 0;
                color: #1e293b;
            }
            .wizard-step > p {
                color: #64748b;
                margin-bottom: 30px;
            }
            .wizard-features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-top: 30px;
            }
            .feature-card {
                text-align: center;
                padding: 24px;
                background: #f8fafc;
                border-radius: 12px;
                border: 2px solid #e2e8f0;
            }
            .feature-card .dashicons {
                font-size: 48px;
                width: 48px;
                height: 48px;
                color: #667eea;
                margin-bottom: 12px;
            }
            .feature-card h3 {
                font-size: 16px;
                margin: 0 0 8px 0;
                color: #1e293b;
            }
            .feature-card p {
                font-size: 14px;
                color: #64748b;
                margin: 0;
            }
            .wizard-badge-item,
            .wizard-social-item {
                display: flex;
                gap: 12px;
                margin-bottom: 12px;
                align-items: center;
            }
            .wizard-badge-item input,
            .wizard-social-item input {
                flex: 1;
            }
            .wizard-actions {
                display: flex;
                justify-content: space-between;
                margin-top: 40px;
                padding-top: 30px;
                border-top: 2px solid #e2e8f0;
            }
            .wizard-nav-buttons {
                display: flex;
                gap: 12px;
            }
            .wizard-skip {
                color: #64748b !important;
            }
        </style>
        <?php
    }
    
    public static function save_wizard_step() {
        check_ajax_referer( 'nonylabs_wizard_nonce', 'nonce' );
        
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied', 'nonylabs-companion' ) ) );
        }
        
        $step = isset( $_POST['step'] ) ? intval( $_POST['step'] ) : 0;
        $data = isset( $_POST['data'] ) ? $_POST['data'] : array();
        
        switch ( $step ) {
            case 2:
                update_option( 'nony_nav_logo_text', sanitize_text_field( $data['nav_logo'] ) );
                update_option( 'nony_site_title', sanitize_text_field( $data['site_title'] ) );
                break;
                
            case 3:
                $badges = array();
                if ( isset( $data['badges'] ) && is_array( $data['badges'] ) ) {
                    foreach ( $data['badges'] as $badge_text ) {
                        if ( ! empty( $badge_text ) ) {
                            $badges[] = array( 'text' => sanitize_text_field( $badge_text ) );
                        }
                    }
                }
                update_option( 'nony_profile_badges', $badges );
                break;
                
            case 4:
                $social_links = array();
                if ( isset( $data['social'] ) && is_array( $data['social'] ) ) {
                    foreach ( $data['social'] as $social ) {
                        if ( ! empty( $social['url'] ) ) {
                            $social_links[] = array(
                                'platform' => sanitize_text_field( $social['platform'] ),
                                'url' => esc_url_raw( $social['url'] ),
                                'username' => sanitize_text_field( $social['username'] ),
                                'icon' => 'ri-' . sanitize_text_field( strtolower( $social['platform'] ) ) . '-fill',
                                'color_start' => '#667eea',
                                'color_end' => '#764ba2',
                            );
                        }
                    }
                }
                update_option( 'nony_social_links', $social_links );
                update_option( 'nonylabs_wizard_completed', true );
                break;
        }
        
        wp_send_json_success( array( 'message' => __( 'Settings saved', 'nonylabs-companion' ) ) );
    }
    
    public static function skip_wizard() {
        check_ajax_referer( 'nonylabs_wizard_nonce', 'nonce' );
        
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error();
        }
        
        update_option( 'nonylabs_wizard_completed', true );
        wp_send_json_success( array( 'redirect' => admin_url( 'admin.php?page=nonylabs-settings' ) ) );
    }
}
