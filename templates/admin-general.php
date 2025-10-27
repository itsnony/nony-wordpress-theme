<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Save settings
if ( isset( $_POST['nonylabs_general_nonce'] ) && wp_verify_nonce( $_POST['nonylabs_general_nonce'], 'nonylabs_save_general' ) ) {
    update_option( 'nony_nav_logo_text', sanitize_text_field( $_POST['nony_nav_logo_text'] ?? '' ) );
    update_option( 'nony_site_title', sanitize_text_field( $_POST['nony_site_title'] ?? '' ) );
    update_option( 'nony_footer_brand_text', sanitize_text_field( $_POST['nony_footer_brand_text'] ?? '' ) );
    update_option( 'nony_footer_tagline', sanitize_text_field( $_POST['nony_footer_tagline'] ?? '' ) );
    update_option( 'nony_footer_copyright', sanitize_text_field( $_POST['nony_footer_copyright'] ?? '' ) );
    
    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved successfully!', 'nonylabs-companion' ) . '</p></div>';
}
?>

<div class="wrap nonylabs-admin-wrap">
    <h1><?php esc_html_e( 'General Settings', 'nonylabs-companion' ); ?></h1>
    
    <form method="post">
        <?php wp_nonce_field( 'nonylabs_save_general', 'nonylabs_general_nonce' ); ?>
        
        <div class="nonylabs-admin-card">
            <h2><?php esc_html_e( 'Navigation Settings', 'nonylabs-companion' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="nony_nav_logo_text"><?php esc_html_e( 'Logo Text', 'nonylabs-companion' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_nav_logo_text" name="nony_nav_logo_text" 
                               value="<?php echo esc_attr( get_option( 'nony_nav_logo_text', 'nony.cc' ) ); ?>" 
                               class="regular-text" />
                        <p class="description"><?php esc_html_e( 'The text displayed in the navigation logo', 'nonylabs-companion' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_site_title"><?php esc_html_e( 'Site Title', 'nonylabs-companion' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_site_title" name="nony_site_title" 
                               value="<?php echo esc_attr( get_option( 'nony_site_title', 'Nony Portfolio' ) ); ?>" 
                               class="regular-text" />
                        <p class="description"><?php esc_html_e( 'Main site title for SEO', 'nonylabs-companion' ); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="nonylabs-admin-card">
            <h2><?php esc_html_e( 'Footer Settings', 'nonylabs-companion' ); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="nony_footer_brand_text"><?php esc_html_e( 'Footer Brand Text', 'nonylabs-companion' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_footer_brand_text" name="nony_footer_brand_text" 
                               value="<?php echo esc_attr( get_option( 'nony_footer_brand_text', 'nony.cc' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_tagline"><?php esc_html_e( 'Footer Tagline', 'nonylabs-companion' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="nony_footer_tagline" name="nony_footer_tagline" 
                               value="<?php echo esc_attr( get_option( 'nony_footer_tagline', 'Made with chaos & caffeine' ) ); ?>" 
                               class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="nony_footer_copyright"><?php esc_html_e( 'Copyright Text', 'nonylabs-companion' ); ?></label>
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
