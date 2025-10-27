<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$social_links = get_option( 'nony_social_links', array(
    array( 'platform' => 'Bluesky', 'url' => 'https://bsky.app/profile/itsnony.bsky.social', 'username' => '@itsnony.bsky.social', 'icon' => 'ri-bluesky-fill', 'color_start' => '#0085ff', 'color_end' => '#00a3ff' ),
    array( 'platform' => 'Discord', 'url' => 'https://discord.com/users/937712557471457311', 'username' => "Let's chat!", 'icon' => 'ri-discord-fill', 'color_start' => '#7289da', 'color_end' => '#99aab5' ),
    array( 'platform' => 'GitHub', 'url' => 'https://github.com/itsnony', 'username' => '@itsnony', 'icon' => 'ri-github-fill', 'color_start' => '#333', 'color_end' => '#666' ),
) );

// Save settings
if ( isset( $_POST['nonylabs_social_nonce'] ) && wp_verify_nonce( $_POST['nonylabs_social_nonce'], 'nonylabs_save_social' ) ) {
    $new_links = array();
    if ( isset( $_POST['nony_social_links'] ) && is_array( $_POST['nony_social_links'] ) ) {
        foreach ( $_POST['nony_social_links'] as $link ) {
            if ( ! empty( $link['url'] ) ) {
                $new_links[] = array(
                    'platform' => sanitize_text_field( $link['platform'] ?? '' ),
                    'url' => esc_url_raw( $link['url'] ),
                    'username' => sanitize_text_field( $link['username'] ?? '' ),
                    'icon' => sanitize_text_field( $link['icon'] ?? 'ri-link' ),
                    'color_start' => sanitize_hex_color( $link['color_start'] ?? '#667eea' ),
                    'color_end' => sanitize_hex_color( $link['color_end'] ?? '#764ba2' ),
                );
            }
        }
    }
    update_option( 'nony_social_links', $new_links );
    $social_links = $new_links;
    
    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Social links saved successfully!', 'nonylabs-companion' ); ?></p></div>';
}
?>

<div class="wrap nonylabs-admin-wrap">
    <h1><?php esc_html_e( 'Social Links', 'nonylabs-companion' ); ?></h1>
    
    <form method="post">
        <?php wp_nonce_field( 'nonylabs_save_social', 'nonylabs_social_nonce' ); ?>
        
        <div class="nonylabs-admin-card">
            <h2><?php esc_html_e( 'Manage Your Social Links', 'nonylabs-companion' ); ?></h2>
            
            <div class="nonylabs-help-text">
                <p>
                    <?php esc_html_e( 'These links appear as cards on your homepage and in the footer. Customize the colors to match each platform\'s branding.', 'nonylabs-companion' ); ?>
                    <br>
                    <strong><?php esc_html_e( 'Icon classes:', 'nonylabs-companion' ); ?></strong> 
                    <?php esc_html_e( 'Use Remix Icon classes. Examples: ri-bluesky-fill, ri-discord-fill, ri-github-fill, ri-twitter-x-fill, ri-instagram-fill', 'nonylabs-companion' ); ?>
                    <br>
                    <a href="https://remixicon.com/" target="_blank"><?php esc_html_e( 'Browse all icons at remixicon.com', 'nonylabs-companion' ); ?></a>
                </p>
            </div>
            
            <div id="nonylabs-social-container">
                <?php foreach ( $social_links as $index => $link ) : ?>
                    <div class="nonylabs-social-item">
                        <input type="text" name="nony_social_links[<?php echo esc_attr( $index ); ?>][platform]" 
                               value="<?php echo esc_attr( $link['platform'] ); ?>" 
                               placeholder="<?php esc_attr_e( 'Platform (e.g., Bluesky)', 'nonylabs-companion' ); ?>" 
                               style="width: 140px;" />
                        <input type="url" name="nony_social_links[<?php echo esc_attr( $index ); ?>][url]" 
                               value="<?php echo esc_url( $link['url'] ); ?>" 
                               placeholder="<?php esc_attr_e( 'URL', 'nonylabs-companion' ); ?>" 
                               class="regular-text" />
                        <input type="text" name="nony_social_links[<?php echo esc_attr( $index ); ?>][username]" 
                               value="<?php echo esc_attr( $link['username'] ); ?>" 
                               placeholder="<?php esc_attr_e( 'Username/Text', 'nonylabs-companion' ); ?>" 
                               style="width: 180px;" />
                        <input type="text" name="nony_social_links[<?php echo esc_attr( $index ); ?>][icon]" 
                               value="<?php echo esc_attr( $link['icon'] ); ?>" 
                               placeholder="<?php esc_attr_e( 'Icon class', 'nonylabs-companion' ); ?>" 
                               style="width: 140px;" />
                        <div class="nonylabs-color-picker-group">
                            <input type="text" name="nony_social_links[<?php echo esc_attr( $index ); ?>][color_start]" 
                                   value="<?php echo esc_attr( $link['color_start'] ?? '#667eea' ); ?>" 
                                   class="nonylabs-color-picker" 
                                   data-default-color="#667eea" />
                            <input type="text" name="nony_social_links[<?php echo esc_attr( $index ); ?>][color_end]" 
                                   value="<?php echo esc_attr( $link['color_end'] ?? '#764ba2' ); ?>" 
                                   class="nonylabs-color-picker" 
                                   data-default-color="#764ba2" />
                        </div>
                        <button type="button" class="button nonylabs-remove-social"><?php esc_html_e( 'Remove', 'nonylabs-companion' ); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="button" class="button nonylabs-add-button" id="nonylabs-add-social">
                <?php esc_html_e( '+ Add Social Link', 'nonylabs-companion' ); ?>
            </button>
            
            <div class="nonylabs-preview">
                <h3><?php esc_html_e( 'Live Preview', 'nonylabs-companion' ); ?></h3>
                <div class="nonylabs-social-preview" id="nonylabs-social-preview">
                    <?php foreach ( $social_links as $link ) : ?>
                        <div class="nonylabs-social-preview-card">
                            <div class="nonylabs-social-preview-icon" style="background: linear-gradient(135deg, <?php echo esc_attr( $link['color_start'] ?? '#667eea' ); ?>, <?php echo esc_attr( $link['color_end'] ?? '#764ba2' ); ?>);">
                                <i class="<?php echo esc_attr( $link['icon'] ); ?>"></i>
                            </div>
                            <div class="nonylabs-social-preview-content">
                                <h4><?php echo esc_html( $link['platform'] ); ?></h4>
                                <p><?php echo esc_html( $link['username'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Initialize color pickers
    $('.nonylabs-color-picker').wpColorPicker({
        change: function() {
            updatePreview();
        }
    });
    
    let socialIndex = <?php echo count( $social_links ); ?>;
    
    $('#nonylabs-add-social').on('click', function() {
        const html = `
            <div class="nonylabs-social-item">
                <input type="text" name="nony_social_links[${socialIndex}][platform]" 
                       placeholder="<?php esc_attr_e( 'Platform', 'nonylabs-companion' ); ?>" 
                       style="width: 140px;" />
                <input type="url" name="nony_social_links[${socialIndex}][url]" 
                       placeholder="<?php esc_attr_e( 'URL', 'nonylabs-companion' ); ?>" 
                       class="regular-text" />
                <input type="text" name="nony_social_links[${socialIndex}][username]" 
                       placeholder="<?php esc_attr_e( 'Username/Text', 'nonylabs-companion' ); ?>" 
                       style="width: 180px;" />
                <input type="text" name="nony_social_links[${socialIndex}][icon]" 
                       placeholder="<?php esc_attr_e( 'Icon class', 'nonylabs-companion' ); ?>" 
                       style="width: 140px;" />
                <div class="nonylabs-color-picker-group">
                    <input type="text" name="nony_social_links[${socialIndex}][color_start]" 
                           value="#667eea" 
                           class="nonylabs-color-picker" 
                           data-default-color="#667eea" />
                    <input type="text" name="nony_social_links[${socialIndex}][color_end]" 
                           value="#764ba2" 
                           class="nonylabs-color-picker" 
                           data-default-color="#764ba2" />
                </div>
                <button type="button" class="button nonylabs-remove-social"><?php esc_html_e( 'Remove', 'nonylabs-companion' ); ?></button>
            </div>
        `;
        const $newItem = $(html);
        $('#nonylabs-social-container').append($newItem);
        $newItem.find('.nonylabs-color-picker').wpColorPicker({
            change: function() {
                updatePreview();
            }
        });
        socialIndex++;
        updatePreview();
    });
    
    $(document).on('click', '.nonylabs-remove-social', function() {
        $(this).closest('.nonylabs-social-item').remove();
        updatePreview();
    });
    
    $(document).on('input', 'input[name^="nony_social_links"]', function() {
        updatePreview();
    });
    
    function updatePreview() {
        const preview = $('#nonylabs-social-preview');
        preview.empty();
        
        $('.nonylabs-social-item').each(function() {
            const platform = $(this).find('input[name$="[platform]"]').val();
            const username = $(this).find('input[name$="[username]"]').val();
            const icon = $(this).find('input[name$="[icon]"]').val();
            const colorStart = $(this).find('input[name$="[color_start]"]').val() || '#667eea';
            const colorEnd = $(this).find('input[name$="[color_end]"]').val() || '#764ba2';
            
            if (platform || username) {
                const card = `
                    <div class="nonylabs-social-preview-card">
                        <div class="nonylabs-social-preview-icon" style="background: linear-gradient(135deg, ${colorStart}, ${colorEnd});">
                            <i class="${icon || 'ri-link'}"></i>
                        </div>
                        <div class="nonylabs-social-preview-content">
                            <h4>${$('<div>').text(platform || 'Platform').html()}</h4>
                            <p>${$('<div>').text(username || 'Username').html()}</p>
                        </div>
                    </div>
                `;
                preview.append(card);
            }
        });
    }
});
</script>
