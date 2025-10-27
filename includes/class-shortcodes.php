<?php
/**
 * Shortcodes
 *
 * @package NonyLabs_Companion
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NonyLabs_Companion_Shortcodes {
    
    public static function init() {
        add_shortcode( 'nony_navigation', array( __CLASS__, 'navigation' ) );
        add_shortcode( 'nony_badges', array( __CLASS__, 'badges' ) );
        add_shortcode( 'nony_social', array( __CLASS__, 'social_links' ) );
        add_shortcode( 'nony_footer', array( __CLASS__, 'footer' ) );
    }
    
    public static function navigation( $atts ) {
        $logo_text = get_option( 'nony_nav_logo_text', 'nony.cc' );
        
        ob_start();
        ?>
        <header class="site-header glass">
            <div class="header-container">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                    <?php echo esc_html( $logo_text ); ?>
                </a>
                
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'nonylabs-companion' ); ?>">
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
                            'fallback_cb'    => false,
                        ) );
                    } else {
                        echo '<ul>';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'nonylabs-companion' ) . '</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/#about' ) ) . '">' . esc_html__( 'About', 'nonylabs-companion' ) . '</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">' . esc_html__( 'Blog', 'nonylabs-companion' ) . '</a></li>';
                        echo '<li><a href="' . esc_url( home_url( '/#contact' ) ) . '">' . esc_html__( 'Contact', 'nonylabs-companion' ) . '</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </nav>
            </div>
        </header>
        <?php
        return ob_get_clean();
    }
    
    public static function badges( $atts ) {
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
    
    public static function social_links( $atts ) {
        $social_links = get_option( 'nony_social_links', array(
            array( 'platform' => 'Bluesky', 'url' => 'https://bsky.app/profile/itsnony.bsky.social', 'username' => '@itsnony.bsky.social', 'icon' => 'ri-bluesky-fill', 'color_start' => '#0085ff', 'color_end' => '#00a3ff' ),
            array( 'platform' => 'Discord', 'url' => 'https://discord.com/users/937712557471457311', 'username' => "Let's chat!", 'icon' => 'ri-discord-fill', 'color_start' => '#7289da', 'color_end' => '#99aab5' ),
            array( 'platform' => 'GitHub', 'url' => 'https://github.com/itsnony', 'username' => '@itsnony', 'icon' => 'ri-github-fill', 'color_start' => '#333', 'color_end' => '#666' ),
        ) );
        
        if ( empty( $social_links ) ) {
            return '';
        }
        
        ob_start();
        ?>
        <div class="social-grid">
            <?php foreach ( $social_links as $link ) : ?>
                <a href="<?php echo esc_url( $link['url'] ); ?>" class="social-card glass" target="_blank" rel="noopener noreferrer">
                    <div class="social-icon" style="background: linear-gradient(135deg, <?php echo esc_attr( $link['color_start'] ?? '#667eea' ); ?>, <?php echo esc_attr( $link['color_end'] ?? '#764ba2' ); ?>);">
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
    
    public static function footer( $atts ) {
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
                        <h4 class="footer-heading"><?php esc_html_e( 'Quick Links', 'nonylabs-companion' ); ?></h4>
                        <nav class="footer-navigation">
                            <?php
                            if ( has_nav_menu( 'footer' ) ) {
                                wp_nav_menu( array(
                                    'theme_location' => 'footer',
                                    'container'      => false,
                                    'menu_class'     => '',
                                    'fallback_cb'    => false,
                                ) );
                            } else {
                                echo '<ul>';
                                echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'nonylabs-companion' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/#about' ) ) . '">' . esc_html__( 'About', 'nonylabs-companion' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">' . esc_html__( 'Blog', 'nonylabs-companion' ) . '</a></li>';
                                echo '<li><a href="' . esc_url( home_url( '/#contact' ) ) . '">' . esc_html__( 'Contact', 'nonylabs-companion' ) . '</a></li>';
                                echo '</ul>';
                            }
                            ?>
                        </nav>
                    </div>
                    
                    <div class="footer-social">
                        <h4 class="footer-heading"><?php esc_html_e( 'Connect', 'nonylabs-companion' ); ?></h4>
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
}
