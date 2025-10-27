<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$badges = get_option( 'nony_profile_badges', array(
    array( 'text' => '16 y/o' ),
    array( 'text' => '🇩🇪 Germany' ),
    array( 'text' => '💀 Horror Fan' ),
    array( 'text' => '@xequence' ),
) );

// Save settings
if ( isset( $_POST['nonylabs_badges_nonce'] ) && wp_verify_nonce( $_POST['nonylabs_badges_nonce'], 'nonylabs_save_badges' ) ) {
    $new_badges = array();
    if ( isset( $_POST['nony_profile_badges'] ) && is_array( $_POST['nony_profile_badges'] ) ) {
        foreach ( $_POST['nony_profile_badges'] as $badge ) {
            if ( ! empty( $badge['text'] ) ) {
                $new_badges[] = array(
                    'text' => sanitize_text_field( $badge['text'] ),
                );
            }
        }
    }
    update_option( 'nony_profile_badges', $new_badges );
    $badges = $new_badges;
    
    echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Badges saved successfully!', 'nonylabs-companion' ) . '</p></div>';
}
?>

<div class="wrap nonylabs-admin-wrap">
    <h1><?php esc_html_e( 'Profile Badges', 'nonylabs-companion' ); ?></h1>
    
    <form method="post">
        <?php wp_nonce_field( 'nonylabs_save_badges', 'nonylabs_badges_nonce' ); ?>
        
        <div class="nonylabs-admin-card">
            <h2><?php esc_html_e( 'Manage Your Profile Badges', 'nonylabs-companion' ); ?></h2>
            
            <div class="nonylabs-help-text">
                <p><?php esc_html_e( 'These badges appear at the top of your homepage. You can use emojis, text, or a combination of both. They help visitors quickly learn about you.', 'nonylabs-companion' ); ?></p>
            </div>
            
            <div id="nonylabs-badges-container">
                <?php foreach ( $badges as $index => $badge ) : ?>
                    <div class="nonylabs-badge-item">
                        <input type="text" name="nony_profile_badges[<?php echo esc_attr( $index ); ?>][text]" 
                               value="<?php echo esc_attr( $badge['text'] ); ?>" 
                               placeholder="<?php esc_attr_e( 'Badge text (e.g., 16 y/o, 🇩🇪 Germany)', 'nonylabs-companion' ); ?>" 
                               class="regular-text" />
                        <button type="button" class="button nonylabs-remove-badge"><?php esc_html_e( 'Remove', 'nonylabs-companion' ); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="button" class="button nonylabs-add-button" id="nonylabs-add-badge">
                <?php esc_html_e( '+ Add Badge', 'nonylabs-companion' ); ?>
            </button>
            
            <div class="nonylabs-preview">
                <h3><?php esc_html_e( 'Live Preview', 'nonylabs-companion' ); ?></h3>
                <div class="nonylabs-preview-badges" id="nonylabs-badges-preview">
                    <?php foreach ( $badges as $badge ) : ?>
                        <div class="nonylabs-preview-badge"><?php echo esc_html( $badge['text'] ); ?></div>
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
    
    $('#nonylabs-add-badge').on('click', function() {
        const html = `
            <div class="nonylabs-badge-item">
                <input type="text" name="nony_profile_badges[${badgeIndex}][text]" 
                       placeholder="<?php esc_attr_e( 'Badge text', 'nonylabs-companion' ); ?>" 
                       class="regular-text" />
                <button type="button" class="button nonylabs-remove-badge"><?php esc_html_e( 'Remove', 'nonylabs-companion' ); ?></button>
            </div>
        `;
        $('#nonylabs-badges-container').append(html);
        badgeIndex++;
        updatePreview();
    });
    
    $(document).on('click', '.nonylabs-remove-badge', function() {
        $(this).closest('.nonylabs-badge-item').remove();
        updatePreview();
    });
    
    $(document).on('input', 'input[name^="nony_profile_badges"]', function() {
        updatePreview();
    });
    
    function updatePreview() {
        const preview = $('#nonylabs-badges-preview');
        preview.empty();
        $('input[name^="nony_profile_badges"]').each(function() {
            const val = $(this).val();
            if (val) {
                preview.append(`<div class="nonylabs-preview-badge">${$('<div>').text(val).html()}</div>`);
            }
        });
    }
});
</script>
