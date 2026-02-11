<?php
if (!defined('ABSPATH')) exit;

// Add meta box to product page
add_action('add_meta_boxes', 'csp_add_meta_box');
function csp_add_meta_box() {
    add_meta_box(
        'csp_size_ranges',
        'Custom Size Pricing',
        'csp_meta_box_callback',
        'product',
        'normal',
        'high'
    );
}

// Meta box HTML
function csp_meta_box_callback($post) {
    wp_nonce_field('csp_save_meta', 'csp_nonce');
    
    $ranges = get_post_meta($post->ID, '_csp_size_ranges', true);
    if (!is_array($ranges)) $ranges = [];
    ?>
    <div id="csp-ranges-container">
        <?php if (!empty($ranges)): ?>
            <?php foreach ($ranges as $index => $range): ?>
                <div class="csp-range-row">
                    <label>Height Min: <input type="number" step="0.01" name="csp_height_min[]" value="<?php echo esc_attr($range['height_min']); ?>" required /></label>
                    <label>Height Max: <input type="number" step="0.01" name="csp_height_max[]" value="<?php echo esc_attr($range['height_max']); ?>" required /></label>
                    <label>Width Min: <input type="number" step="0.01" name="csp_width_min[]" value="<?php echo esc_attr($range['width_min']); ?>" required /></label>
                    <label>Width Max: <input type="number" step="0.01" name="csp_width_max[]" value="<?php echo esc_attr($range['width_max']); ?>" required /></label>
                    <label>Price: <input type="number" step="0.01" name="csp_price[]" value="<?php echo esc_attr($range['price']); ?>" required /></label>
                    <button type="button" class="button csp-remove-range">Remove</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <button type="button" id="csp-add-range" class="button">Add Size Range</button>
    <?php
}

// Save meta box data
add_action('save_post', 'csp_save_meta_box');
function csp_save_meta_box($post_id) {
    if (!isset($_POST['csp_nonce']) || !wp_verify_nonce($_POST['csp_nonce'], 'csp_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $ranges = [];
    if (isset($_POST['csp_height_min']) && is_array($_POST['csp_height_min'])) {
        $count = count($_POST['csp_height_min']);
        for ($i = 0; $i < $count; $i++) {
            $ranges[] = [
                'height_min' => floatval($_POST['csp_height_min'][$i]),
                'height_max' => floatval($_POST['csp_height_max'][$i]),
                'width_min' => floatval($_POST['csp_width_min'][$i]),
                'width_max' => floatval($_POST['csp_width_max'][$i]),
                'price' => floatval($_POST['csp_price'][$i])
            ];
        }
    }
    
    update_post_meta($post_id, '_csp_size_ranges', $ranges);
}
