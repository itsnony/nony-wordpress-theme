<?php
/**
 * Plugin Name: Nony Portfolio Companion
 * Plugin URI: https://nony.cc
 * Description: Companion plugin for Nony Portfolio theme with advanced customization options
 * Version: 1.0.0
 * Author: Nony
 * Author URI: https://nony.cc
 * License: GPL v2 or later
 * Text Domain: nony-portfolio-companion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NONY_COMPANION_VERSION', '1.0.0' );
define( 'NONY_COMPANION_PATH', plugin_dir_path( __FILE__ ) );
define( 'NONY_COMPANION_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register admin menu
 */
function nony_companion_admin_menu() {
    add_menu_page(
        __( 'Portfolio Settings', 'nony-portfolio-companion' ),
        __( 'Portfolio', 'nony-portfolio-companion' ),
        'manage_options',
        'nony-portfolio-settings',
        'nony_companion_settings_page',
        'dashicons-admin-customizer',
        61
    );
    
    add_submenu_page(
        'nony-portfolio-settings',
        __( 'General Settings', 'nony-portfolio-companion' ),
        __( 'General', 'nony-portfolio-companion' ),
        'manage_options',
        'nony-portfolio-settings',
        'nony_companion_settings_page'
    );
    
    add_submenu_page(
        'nony-portfolio-settings',
        __( 'Profile Badges', 'nony-portfolio-companion' ),
        __( 'Profile Badges', 'nony-portfolio-companion' ),
        'manage_options',
        'nony-portfolio-badges',
        'nony_companion_badges_page'
    );
    
    add_submenu_page(
        'nony-portfolio-settings',
        __( 'Social Links', 'nony-portfolio-companion' ),
        __( 'Social Links', 'nony-portfolio-companion' ),
        'manage_options',
        'nony-portfolio-social',
        'nony_companion_social_page'
    );
}
add_action( 'admin_menu', 'nony_companion_admin_menu' );

/**
 * Register settings
 */
function nony_companion_register_settings() {
    // Navigation settings
    register_setting( 'nony_companion_general', 'nony_nav_logo_text' );
    register_setting( 'nony_companion_general', 'nony_site_title' );
    
    // Footer settings
    register_setting( 'nony_companion_general', 'nony_footer_brand_text' );
    register_setting( 'nony_companion_general', 'nony_footer_tagline' );
    register_setting( 'nony_companion_general', 'nony_footer_copyright' );
    
    // Profile badges
    register_setting( 'nony_companion_badges', 'nony_profile_badges' );
    
    // Social links
    register_setting( 'nony_companion_social', 'nony_social_links' );
}
add_action( 'admin_init', 'nony_companion_register_settings' );

/**
 * Enqueue admin styles
 */
function nony_companion_admin_styles( $hook ) {
    if ( strpos( $hook, 'nony-portfolio' ) === false ) {
        return;
    }
    ?>
    <style>
        .nony-admin-wrap {
            max-width: 1200px;
            margin: 20px 0;
        }
        .nony-admin-card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        .nony-admin-card h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .nony-badge-item, .nony-social-item {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .nony-badge-item input, .nony-social-item input {
            flex: 1;
        }
        .nony-badge-item .button, .nony-social-item .button {
            flex-shrink: 0;
        }
        .nony-add-button {
            margin-top: 10px;
        }
        .nony-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 8px;
            color: white;
            margin-top: 20px;
        }
        .nony-preview-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        .nony-preview-badge {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }
    </style>
    <?php
}
add_action( 'admin_head', 'nony_companion_admin_styles' );

/**
 * General settings page
 */
function nony_companion_settings_page() {
    ?>
    <div class="wrap nony-admin-wrap">
        <h1><?php _e( 'Portfolio General Settings', 'nony-portfolio-companion' ); ?></h1>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'nony_companion_general' ); ?>
            
            <div class="nony-admin-card">
                <h2><?php _e( 'Navigation Settings', 'nony-portfolio-companion' ); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="nony_nav_logo_text"><?php _e( 'Logo Text', 'nony-portfolio-companion' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nony_nav_logo_text" name="nony_nav_logo_text" 
                                   value="<?php echo esc_attr( get_option( 'nony_nav_logo_text', 'nony.cc' ) ); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php _e( 'The text displayed in the navigation logo', 'nony-portfolio-companion' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nony_site_title"><?php _e( 'Site Title', 'nony-portfolio-companion' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nony_site_title" name="nony_site_title" 
                                   value="<?php echo esc_attr( get_option( 'nony_site_title', 'Nony Portfolio' ) ); ?>" 
                                   class="regular-text" />
                            <p class="description"><?php _e( 'Main site title for SEO', 'nony-portfolio-companion' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="nony-admin-card">
                <h2><?php _e( 'Footer Settings', 'nony-portfolio-companion' ); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="nony_footer_brand_text"><?php _e( 'Footer Brand Text', 'nony-portfolio-companion' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nony_footer_brand_text" name="nony_footer_brand_text" 
                                   value="<?php echo esc_attr( get_option( 'nony_footer_brand_text', 'nony.cc' ) ); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nony_footer_tagline"><?php _e( 'Footer Tagline', 'nony-portfolio-companion' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nony_footer_tagline" name="nony_footer_tagline" 
                                   value="<?php echo esc_attr( get_option( 'nony_footer_tagline', 'Made with chaos & caffeine' ) ); ?>" 
                                   class="regular-text" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="nony_footer_copyright"><?php _e( 'Copyright Text', 'nony-portfolio-companion' ); ?></label>
                        </th>
                        <td>
                            <input type="text" id="nony_footer_copyright" name="nony_footer_copyright" 
                                   value="<?php echo esc_attr( get_option( 'nony_footer_copyright', '© 2025 nony.cc - no corporate vibes allowed' ) ); ?>" 
                                   class="large-text" />
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Profile badges page
 */
function nony_companion_badges_page() {
    $badges = get_option( 'nony_profile_badges', array(
        array( 'text' => '16 y/o' ),
        array( 'text' => '🇩🇪 Germany' ),
        array( 'text' => '💀 Horror Fan' ),
        array( 'text' => '@xequence' ),
    ) );
    
    if ( isset( $_POST['nony_profile_badges'] ) && check_admin_referer( 'nony_badges_save', 'nony_badges_nonce' ) ) {
        $badges = array_filter( $_POST['nony_profile_badges'], function( $badge ) {
            return ! empty( $badge['text'] );
        } );
        update_option( 'nony_profile_badges', $badges );
        echo '<div class="notice notice-success"><p>' . __( 'Badges saved successfully!', 'nony-portfolio-companion' ) . '</p></div>';
    }
    ?>
    <div class="wrap nony-admin-wrap">
        <h1><?php _e( 'Profile Badges', 'nony-portfolio-companion' ); ?></h1>
        
        <form method="post">
            <?php wp_nonce_field( 'nony_badges_save', 'nony_badges_nonce' ); ?>
            
            <div class="nony-admin-card">
                <h2><?php _e( 'Manage Your Profile Badges', 'nony-portfolio-companion' ); ?></h2>
                <p><?php _e( 'These badges appear at the top of your homepage. You can use emojis and text.', 'nony-portfolio-companion' ); ?></p>
                
                <div id="nony-badges-container">
                    <?php foreach ( $badges as $index => $badge ) : ?>
                        <div class="nony-badge-item">
                            <input type="text" name="nony_profile_badges[<?php echo $index; ?>][text]" 
                                   value="<?php echo esc_attr( $badge['text'] ); ?>" 
                                   placeholder="<?php _e( 'Badge text (e.g., 16 y/o, 🇩🇪 Germany)', 'nony-portfolio-companion' ); ?>" 
                                   class="regular-text" />
                            <button type="button" class="button nony-remove-badge"><?php _e( 'Remove', 'nony-portfolio-companion' ); ?></button>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="button nony-add-button" id="nony-add-badge">
                    <?php _e( '+ Add Badge', 'nony-portfolio-companion' ); ?>
                </button>
                
                <div class="nony-preview">
                    <h3><?php _e( 'Preview', 'nony-portfolio-companion' ); ?></h3>
                    <div class="nony-preview-badges" id="nony-badges-preview">
                        <?php foreach ( $badges as $badge ) : ?>
                            <div class="nony-preview-badge"><?php echo esc_html( $badge['text'] ); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        let badgeIndex = <?php echo count( $badges ); ?>;
        
        $('#nony-add-badge').on('click', function() {
            const html = `
                <div class="nony-badge-item">
                    <input type="text" name="nony_profile_badges[${badgeIndex}][text]" 
                           placeholder="<?php _e( 'Badge text', 'nony-portfolio-companion' ); ?>" 
                           class="regular-text" />
                    <button type="button" class="button nony-remove-badge"><?php _e( 'Remove', 'nony-portfolio-companion' ); ?></button>
                </div>
            `;
            $('#nony-badges-container').append(html);
            badgeIndex++;
            updatePreview();
        });
        
        $(document).on('click', '.nony-remove-badge', function() {
            $(this).closest('.nony-badge-item').remove();
            updatePreview();
        });
        
        $(document).on('input', 'input[name^="nony_profile_badges"]', function() {
            updatePreview();
        });
        
        function updatePreview() {
            const preview = $('#nony-badges-preview');
            preview.empty();
            $('input[name^="nony_profile_badges"]').each(function() {
                const val = $(this).val();
                if (val) {
                    preview.append(`<div class="nony-preview-badge">${val}</div>`);
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Social links page
 */
function nony_companion_social_page() {
    $social_links = get_option( 'nony_social_links', array(
        array( 'platform' => 'Bluesky', 'url' => 'https://bsky.app/profile/itsnony.bsky.social', 'username' => '@itsnony.bsky.social', 'icon' => 'ri-bluesky-fill' ),
        array( 'platform' => 'Discord', 'url' => 'https://discord.com/users/937712557471457311', 'username' => "Let's chat!", 'icon' => 'ri-discord-fill' ),
        array( 'platform' => 'GitHub', 'url' => 'https://github.com/itsnony', 'username' => '@itsnony', 'icon' => 'ri-github-fill' ),
    ) );
    
    if ( isset( $_POST['nony_social_links'] ) && check_admin_referer( 'nony_social_save', 'nony_social_nonce' ) ) {
        $social_links = array_filter( $_POST['nony_social_links'], function( $link ) {
            return ! empty( $link['url'] );
        } );
        update_option( 'nony_social_links', $social_links );
        echo '<div class="notice notice-success"><p>' . __( 'Social links saved successfully!', 'nony-portfolio-companion' ) . '</p></div>';
    }
    ?>
    <div class="wrap nony-admin-wrap">
        <h1><?php _e( 'Social Links', 'nony-portfolio-companion' ); ?></h1>
        
        <form method="post">
            <?php wp_nonce_field( 'nony_social_save', 'nony_social_nonce' ); ?>
            
            <div class="nony-admin-card">
                <h2><?php _e( 'Manage Your Social Links', 'nony-portfolio-companion' ); ?></h2>
                <p><?php _e( 'These links appear as cards on your homepage and in the footer.', 'nony-portfolio-companion' ); ?></p>
                
                <div id="nony-social-container">
                    <?php foreach ( $social_links as $index => $link ) : ?>
                        <div class="nony-social-item">
                            <input type="text" name="nony_social_links[<?php echo $index; ?>][platform]" 
                                   value="<?php echo esc_attr( $link['platform'] ); ?>" 
                                   placeholder="<?php _e( 'Platform (e.g., Bluesky)', 'nony-portfolio-companion' ); ?>" 
                                   style="width: 150px;" />
                            <input type="text" name="nony_social_links[<?php echo $index; ?>][url]" 
                                   value="<?php echo esc_url( $link['url'] ); ?>" 
                                   placeholder="<?php _e( 'URL', 'nony-portfolio-companion' ); ?>" 
                                   class="regular-text" />
                            <input type="text" name="nony_social_links[<?php echo $index; ?>][username]" 
                                   value="<?php echo esc_attr( $link['username'] ); ?>" 
                                   placeholder="<?php _e( 'Username/Text', 'nony-portfolio-companion' ); ?>" 
                                   style="width: 200px;" />
                            <input type="text" name="nony_social_links[<?php echo $index; ?>][icon]" 
                                   value="<?php echo esc_attr( $link['icon'] ); ?>" 
                                   placeholder="<?php _e( 'Icon class', 'nony-portfolio-companion' ); ?>" 
                                   style="width: 150px;" />
                            <button type="button" class="button nony-remove-social"><?php _e( 'Remove', 'nony-portfolio-companion' ); ?></button>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="button nony-add-button" id="nony-add-social">
                    <?php _e( '+ Add Social Link', 'nony-portfolio-companion' ); ?>
                </button>
                
                <p class="description" style="margin-top: 15px;">
                    <?php _e( 'Icon classes use Remix Icon. Examples: ri-bluesky-fill, ri-discord-fill, ri-github-fill, ri-twitter-x-fill, ri-instagram-fill', 'nony-portfolio-companion' ); ?>
                    <br>
                    <?php _e( 'Find more icons at:', 'nony-portfolio-companion' ); ?> 
                    <a href="https://remixicon.com/" target="_blank">https://remixicon.com/</a>
                </p>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        let socialIndex = <?php echo count( $social_links ); ?>;
        
        $('#nony-add-social').on('click', function() {
            const html = `
                <div class="nony-social-item">
                    <input type="text" name="nony_social_links[${socialIndex}][platform]" 
                           placeholder="<?php _e( 'Platform', 'nony-portfolio-companion' ); ?>" 
                           style="width: 150px;" />
                    <input type="text" name="nony_social_links[${socialIndex}][url]" 
                           placeholder="<?php _e( 'URL', 'nony-portfolio-companion' ); ?>" 
                           class="regular-text" />
                    <input type="text" name="nony_social_links[${socialIndex}][username]" 
                           placeholder="<?php _e( 'Username/Text', 'nony-portfolio-companion' ); ?>" 
                           style="width: 200px;" />
                    <input type="text" name="nony_social_links[${socialIndex}][icon]" 
                           placeholder="<?php _e( 'Icon class', 'nony-portfolio-companion' ); ?>" 
                           style="width: 150px;" />
                    <button type="button" class="button nony-remove-social"><?php _e( 'Remove', 'nony-portfolio-companion' ); ?></button>
                </div>
            `;
            $('#nony-social-container').append(html);
            socialIndex++;
        });
        
        $(document).on('click', '.nony-remove-social', function() {
            $(this).closest('.nony-social-item').remove();
        });
    });
    </script>
    <?php
}

/**
 * Register shortcodes
 */
function nony_companion_navigation_shortcode() {
    $logo_text = get_option( 'nony_nav_logo_text', 'nony.cc' );
    
    ob_start();
    ?>
    <header class="site-header glass">
        <div class="header-container">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                <?php echo esc_html( $logo_text ); ?>
            </a>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <nav class="main-navigation" id="mainNavigation">
                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => '',
                    ) );
                } else {
                    echo '<ul>';
                    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/#about' ) ) . '">About</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">Blog</a></li>';
                    echo '<li><a href="' . esc_url( home_url( '/#contact' ) ) . '">Contact</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>
        </div>
    </header>
    <?php
    return ob_get_clean();
}
add_shortcode( 'nony_navigation', 'nony_companion_navigation_shortcode' );

/**
 * Profile badges shortcode
 */
function nony_companion_badges_shortcode() {
    $badges = get_option( 'nony_profile_badges', array(
        array( 'text' => '16 y/o' ),
        array( 'text' => '🇩🇪 Germany' ),
        array( 'text' => '💀 Horror Fan' ),
        array( 'text' => '@xequence' ),
    ) );
    
    if ( empty( $badges ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="profile-badges">
        <?php foreach ( $badges as $badge ) : ?>
            <span class="badge glass"><?php echo esc_html( $badge['text'] ); ?></span>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'nony_badges', 'nony_companion_badges_shortcode' );

/**
 * Social links shortcode
 */
function nony_companion_social_shortcode() {
    $social_links = get_option( 'nony_social_links', array(
        array( 'platform' => 'Bluesky', 'url' => 'https://bsky.app/profile/itsnony.bsky.social', 'username' => '@itsnony.bsky.social', 'icon' => 'ri-bluesky-fill' ),
        array( 'platform' => 'Discord', 'url' => 'https://discord.com/users/937712557471457311', 'username' => "Let's chat!", 'icon' => 'ri-discord-fill' ),
        array( 'platform' => 'GitHub', 'url' => 'https://github.com/itsnony', 'username' => '@itsnony', 'icon' => 'ri-github-fill' ),
    ) );
    
    if ( empty( $social_links ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="social-grid">
        <?php foreach ( $social_links as $link ) : ?>
            <a href="<?php echo esc_url( $link['url'] ); ?>" class="social-card glass" target="_blank" rel="noopener noreferrer">
                <div class="social-icon" style="background: linear-gradient(135deg, <?php echo $link['platform'] === 'Bluesky' ? '#0085ff, #00a3ff' : ( $link['platform'] === 'Discord' ? '#7289da, #99aab5' : '#333, #666' ); ?>);">
                    <i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
                </div>
                <div class="social-content">
                    <h3><?php echo esc_html( $link['platform'] ); ?></h3>
                    <p><?php echo esc_html( $link['username'] ); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'nony_social', 'nony_companion_social_shortcode' );

/**
 * Footer shortcode
 */
function nony_companion_footer_shortcode() {
    $brand_text = get_option( 'nony_footer_brand_text', 'nony.cc' );
    $tagline = get_option( 'nony_footer_tagline', 'Made with chaos & caffeine' );
    $copyright = get_option( 'nony_footer_copyright', '© 2025 nony.cc - no corporate vibes allowed' );
    $social_links = get_option( 'nony_social_links', array() );
    
    ob_start();
    ?>
    <footer class="site-footer glass-strong" style="margin-top:6rem;padding:3rem 2rem;">
        <div class="footer-container" style="max-width:1152px;margin:0 auto;">
            
            <div class="footer-content">
                
                <div class="footer-brand">
                    <div class="footer-brand-text"><?php echo esc_html( $brand_text ); ?></div>
                    <p class="footer-tagline"><?php echo esc_html( $tagline ); ?></p>
                </div>
                
                <div class="footer-links">
                    <h4 class="footer-heading">Quick Links</h4>
                    <nav class="footer-navigation">
                        <?php
                        if ( has_nav_menu( 'footer' ) ) {
                            wp_nav_menu( array(
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => '',
                            ) );
                        } else {
                            echo '<ul>';
                            echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
                            echo '<li><a href="' . esc_url( home_url( '/#about' ) ) . '">About</a></li>';
                            echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">Blog</a></li>';
                            echo '<li><a href="' . esc_url( home_url( '/#contact' ) ) . '">Contact</a></li>';
                            echo '</ul>';
                        }
                        ?>
                    </nav>
                </div>
                
                <div class="footer-social">
                    <h4 class="footer-heading">Connect</h4>
                    <div class="footer-social-links">
                        <?php foreach ( $social_links as $link ) : ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $link['platform'] ); ?>">
                                <i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
            </div>
            
            <hr class="footer-divider">
            
            <div class="footer-bottom">
                <p class="footer-copyright"><?php echo esc_html( $copyright ); ?></p>
            </div>
            
        </div>
    </footer>
    <?php
    return ob_get_clean();
}
add_shortcode( 'nony_footer', 'nony_companion_footer_shortcode' );

/**
 * Add admin notice if theme is not active
 */
function nony_companion_admin_notice() {
    $theme = wp_get_theme();
    if ( $theme->get( 'TextDomain' ) !== 'nony-portfolio' ) {
        ?>
        <div class="notice notice-warning">
            <p><?php _e( 'Nony Portfolio Companion plugin works best with the Nony Portfolio theme.', 'nony-portfolio-companion' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'nony_companion_admin_notice' );
