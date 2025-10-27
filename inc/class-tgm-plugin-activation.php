<?php
/**
 * TGM Plugin Activation class
 * 
 * This file is a simplified version of the TGM Plugin Activation library
 * for automatically installing and activating required plugins.
 */

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {

    class TGM_Plugin_Activation {
        
        public $plugins = array();
        public $config = array();
        
        private static $instance;
        
        public static function get_instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof TGM_Plugin_Activation ) ) {
                self::$instance = new TGM_Plugin_Activation();
            }
            return self::$instance;
        }
        
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
            add_action( 'admin_notices', array( $this, 'admin_notices' ) );
        }
        
        public function admin_menu() {
            add_theme_page(
                __( 'Install Required Plugins', 'nony-portfolio' ),
                __( 'Install Plugins', 'nony-portfolio' ),
                'install_plugins',
                'tgmpa-install-plugins',
                array( $this, 'install_plugins_page' )
            );
        }
        
        public function admin_init() {
            if ( isset( $_GET['tgmpa-install'] ) && isset( $_GET['plugin'] ) ) {
                $this->install_plugin( $_GET['plugin'] );
            }
            
            if ( isset( $_GET['tgmpa-activate'] ) && isset( $_GET['plugin'] ) ) {
                $this->activate_plugin( $_GET['plugin'] );
            }
        }
        
        public function admin_notices() {
            $plugins_to_install = $this->get_plugins_to_install();
            
            if ( ! empty( $plugins_to_install ) ) {
                ?>
                <div class="notice notice-warning is-dismissible">
                    <p>
                        <strong><?php _e( 'Nony Portfolio Theme', 'nony-portfolio' ); ?></strong> 
                        <?php _e( 'requires the following plugin to work properly:', 'nony-portfolio' ); ?>
                    </p>
                    <p>
                        <a href="<?php echo admin_url( 'themes.php?page=tgmpa-install-plugins' ); ?>" class="button button-primary">
                            <?php _e( 'Install Required Plugins', 'nony-portfolio' ); ?>
                        </a>
                    </p>
                </div>
                <?php
            }
        }
        
        public function install_plugins_page() {
            ?>
            <div class="wrap">
                <h1><?php _e( 'Install Required Plugins', 'nony-portfolio' ); ?></h1>
                
                <?php
                $plugins_to_install = $this->get_plugins_to_install();
                
                if ( empty( $plugins_to_install ) ) {
                    echo '<p>' . __( 'All required plugins are installed and activated!', 'nony-portfolio' ) . '</p>';
                    return;
                }
                ?>
                
                <table class="wp-list-table widefat plugins">
                    <thead>
                        <tr>
                            <th><?php _e( 'Plugin', 'nony-portfolio' ); ?></th>
                            <th><?php _e( 'Status', 'nony-portfolio' ); ?></th>
                            <th><?php _e( 'Action', 'nony-portfolio' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $plugins_to_install as $plugin ) : ?>
                            <tr>
                                <td><strong><?php echo esc_html( $plugin['name'] ); ?></strong></td>
                                <td>
                                    <?php
                                    if ( $this->is_plugin_installed( $plugin['slug'] ) ) {
                                        echo '<span style="color: orange;">' . __( 'Installed but not activated', 'nony-portfolio' ) . '</span>';
                                    } else {
                                        echo '<span style="color: red;">' . __( 'Not installed', 'nony-portfolio' ) . '</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ( $this->is_plugin_installed( $plugin['slug'] ) ) : ?>
                                        <a href="<?php echo wp_nonce_url( admin_url( 'themes.php?page=tgmpa-install-plugins&tgmpa-activate=' . $plugin['slug'] . '&plugin=' . $plugin['slug'] ), 'tgmpa-activate', 'tgmpa-nonce' ); ?>" class="button button-primary">
                                            <?php _e( 'Activate', 'nony-portfolio' ); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo wp_nonce_url( admin_url( 'themes.php?page=tgmpa-install-plugins&tgmpa-install=' . $plugin['slug'] . '&plugin=' . $plugin['slug'] ), 'tgmpa-install', 'tgmpa-nonce' ); ?>" class="button button-primary">
                                            <?php _e( 'Install', 'nony-portfolio' ); ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        
        private function get_plugins_to_install() {
            $plugins_to_install = array();
            
            foreach ( $this->plugins as $plugin ) {
                if ( ! $this->is_plugin_active( $plugin['slug'] ) ) {
                    $plugins_to_install[] = $plugin;
                }
            }
            
            return $plugins_to_install;
        }
        
        private function is_plugin_installed( $slug ) {
            $plugin_path = WP_PLUGIN_DIR . '/' . $slug;
            return file_exists( $plugin_path );
        }
        
        private function is_plugin_active( $slug ) {
            $plugin_file = $slug . '/' . $slug . '.php';
            return is_plugin_active( $plugin_file );
        }
        
        private function install_plugin( $slug ) {
            check_admin_referer( 'tgmpa-install', 'tgmpa-nonce' );
            
            $plugin = null;
            foreach ( $this->plugins as $p ) {
                if ( $p['slug'] === $slug ) {
                    $plugin = $p;
                    break;
                }
            }
            
            if ( ! $plugin || ! isset( $plugin['source'] ) ) {
                return;
            }
            
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
            
            WP_Filesystem();
            
            $upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
            $installed = $upgrader->install( $plugin['source'] );
            
            if ( $installed ) {
                wp_redirect( admin_url( 'themes.php?page=tgmpa-install-plugins' ) );
                exit;
            }
        }
        
        private function activate_plugin( $slug ) {
            check_admin_referer( 'tgmpa-activate', 'tgmpa-nonce' );
            
            $plugin_file = $slug . '/' . $slug . '.php';
            $result = activate_plugin( $plugin_file );
            
            if ( ! is_wp_error( $result ) ) {
                wp_redirect( admin_url( 'themes.php?page=tgmpa-install-plugins' ) );
                exit;
            }
        }
    }
}

function tgmpa( $plugins, $config = array() ) {
    $instance = TGM_Plugin_Activation::get_instance();
    $instance->plugins = $plugins;
    $instance->config = $config;
}
