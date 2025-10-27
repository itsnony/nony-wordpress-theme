<?php
/**
 * Nony Portfolio Theme Functions
 *
 * @package Nony_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue theme styles and scripts
 */
function nony_portfolio_enqueue_assets() {
    // Enqueue Google Fonts
    wp_enqueue_style(
        'nony-google-fonts',
        'https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Enqueue Remix Icon
    wp_enqueue_style(
        'remix-icon',
        'https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css',
        array(),
        '4.0.0'
    );

    // Enqueue theme stylesheet
    wp_enqueue_style(
        'nony-portfolio-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );

    // Enqueue custom JavaScript
    wp_enqueue_script(
        'nony-portfolio-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'nony_portfolio_enqueue_assets' );

/**
 * Add theme support
 */
function nony_portfolio_setup() {
    // Add support for block styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for post thumbnails
    add_theme_support( 'post-thumbnails' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 100,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Add support for HTML5 markup
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add support for title tag
    add_theme_support( 'title-tag' );

    // Add support for automatic feed links
    add_theme_support( 'automatic-feed-links' );
    
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'nony-portfolio' ),
        'footer'  => __( 'Footer Menu', 'nony-portfolio' ),
    ) );
}
add_action( 'after_setup_theme', 'nony_portfolio_setup' );

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Register required plugins
 */
function nony_portfolio_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'Nony Portfolio Companion',
            'slug'     => 'nony-portfolio-companion',
            'source'   => get_template_directory() . '/plugins/nony-portfolio-companion.zip',
            'required' => true,
            'version'  => '1.0.0',
        ),
    );

    $config = array(
        'id'           => 'nony-portfolio',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => false,
        'dismiss_msg'  => '',
        'is_automatic' => true,
        'message'      => '',
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'nony_portfolio_register_required_plugins' );

function nony_portfolio_admin_menu() {
    add_menu_page(
        __( 'Nony Portfolio Settings', 'nony-portfolio' ),
        __( 'Portfolio Settings', 'nony-portfolio' ),
        'manage_options',
        'nony-portfolio-settings',
        'nony_portfolio_settings_page',
        'dashicons-admin-customizer',
        61
    );
}
add_action( 'admin_menu', 'nony_portfolio_admin_menu' );

function nony_portfolio_register_settings() {
    // Navigation settings
    register_setting( 'nony_portfolio_settings', 'nony_nav_logo_text' );
    register_setting( 'nony_portfolio_settings', 'nony_nav_menu_items' );
    
    // Footer settings
    register_setting( 'nony_portfolio_settings', 'nony_footer_brand_text' );
    register_setting( 'nony_portfolio_settings', 'nony_footer_tagline' );
    register_setting( 'nony_portfolio_settings', 'nony_footer_copyright' );
    register_setting( 'nony_portfolio_settings', 'nony_footer_social_bluesky' );
    register_setting( 'nony_portfolio_settings', 'nony_footer_social_discord' );
    register_setting( 'nony_portfolio_settings', 'nony_footer_social_github' );
    
    // Profile settings
    register_setting( 'nony_portfolio_settings', 'nony_profile_name' );
    register_setting( 'nony_portfolio_settings', 'nony_profile_age' );
    register_setting( 'nony_portfolio_settings', 'nony_profile_country' );
    register_setting( 'nony_portfolio_settings', 'nony_profile_interest' );
    register_setting( 'nony_portfolio_settings', 'nony_profile_username' );
}
add_action( 'admin_init', 'nony_portfolio_register_settings' );

function nony_portfolio_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'nony_portfolio_settings' );
            do_settings_sections( 'nony_portfolio_settings' );
            ?>
            
            <h2><?php _e( 'Navigation Settings', 'nony-portfolio' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="nony_nav_logo_text"><?php _e( 'Logo Text', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_nav_logo_text" name="nony_nav_logo_text" 
                               value="<?php echo esc_attr( get_option( 'nony_nav_logo_text', 'nony.cc' ) ); ?>" 
                               class="regular-text" />
                        <p class="description"><?php _e( 'The text displayed in the navigation logo', 'nony-portfolio' ); ?></p>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e( 'Profile Badge Settings', 'nony-portfolio' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="nony_profile_name"><?php _e( 'Display Name', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_profile_name" name="nony_profile_name" 
                               value="<?php echo esc_attr( get_option( 'nony_profile_name', 'Nony' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_profile_age"><?php _e( 'Age', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_profile_age" name="nony_profile_age" 
                               value="<?php echo esc_attr( get_option( 'nony_profile_age', '16 y/o' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_profile_country"><?php _e( 'Country', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_profile_country" name="nony_profile_country" 
                               value="<?php echo esc_attr( get_option( 'nony_profile_country', '🇩🇪 Germany' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_profile_interest"><?php _e( 'Interest', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_profile_interest" name="nony_profile_interest" 
                               value="<?php echo esc_attr( get_option( 'nony_profile_interest', '💀 Horror Fan' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_profile_username"><?php _e( 'Username', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_profile_username" name="nony_profile_username" 
                               value="<?php echo esc_attr( get_option( 'nony_profile_username', '@xequence' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
            </table>
            
            <h2><?php _e( 'Footer Settings', 'nony-portfolio' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="nony_footer_brand_text"><?php _e( 'Footer Brand Text', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_footer_brand_text" name="nony_footer_brand_text" 
                               value="<?php echo esc_attr( get_option( 'nony_footer_brand_text', 'nony.cc' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_tagline"><?php _e( 'Footer Tagline', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_footer_tagline" name="nony_footer_tagline" 
                               value="<?php echo esc_attr( get_option( 'nony_footer_tagline', 'Made with chaos & caffeine' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_copyright"><?php _e( 'Copyright Text', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_footer_copyright" name="nony_footer_copyright" 
                               value="<?php echo esc_attr( get_option( 'nony_footer_copyright', '© 2025 nony.cc - no corporate vibes allowed' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_social_bluesky"><?php _e( 'Bluesky URL', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="nony_footer_social_bluesky" name="nony_footer_social_bluesky" 
                               value="<?php echo esc_url( get_option( 'nony_footer_social_bluesky', 'https://bsky.app/profile/itsnony.bsky.social' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_social_discord"><?php _e( 'Discord URL', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="nony_footer_social_discord" name="nony_footer_social_discord" 
                               value="<?php echo esc_url( get_option( 'nony_footer_social_discord', 'https://discord.com/users/937712557471457311' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_social_github"><?php _e( 'GitHub URL', 'nony-portfolio' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="nony_footer_social_github" name="nony_footer_social_github" 
                               value="<?php echo esc_url( get_option( 'nony_footer_social_github', 'https://github.com/itsnony' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Register custom block patterns category
 */
function nony_portfolio_register_pattern_categories() {
    register_block_pattern_category(
        'nony-portfolio',
        array( 'label' => __( 'Nony Portfolio', 'nony-portfolio' ) )
    );
}
add_action( 'init', 'nony_portfolio_register_pattern_categories' );

/**
 * Add custom body classes
 */
function nony_portfolio_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular-page';
    }
    if ( is_archive() || is_home() ) {
        $classes[] = 'archive-page';
    }
    return $classes;
}
add_filter( 'body_class', 'nony_portfolio_body_classes' );

function nony_get_option( $key, $default = '' ) {
    return get_option( $key, $default );
}
