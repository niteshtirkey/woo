<?php
if (!defined('ABSPATH')) exit;

// Display custom fields on product page
add_action('woocommerce_before_add_to_cart_button', 'csp_display_custom_fields');
function csp_display_custom_fields() {
    global $product;
    
    $ranges = get_post_meta($product->get_id(), '_csp_size_ranges', true);
    if (empty($ranges)) return;
    
    ?>
    <div class="csp-custom-fields">
        <input type="hidden" id="csp-ranges" value='<?php echo esc_attr(json_encode($ranges)); ?>' />
        
        <div class="csp-field">
            <label for="csp-height">Height:</label>
            <input type="number" id="csp-height" name="csp_height" step="0.01" min="0" required />
        </div>
        
        <div class="csp-field">
            <label for="csp-width">Width:</label>
            <input type="number" id="csp-width" name="csp_width" step="0.01" min="0" required />
        </div>
        
        <div id="csp-calculated-price" style="display:none; margin: 15px 0; font-size: 18px; font-weight: bold;">
            Calculated Price: <span id="csp-price-value"></span>
        </div>
        
        <div id="csp-error" style="display:none; color: red; margin: 10px 0;"></div>
    </div>
    <?php
}

// AJAX handler to validate dimensions
add_action('wp_ajax_csp_validate_dimensions', 'csp_validate_dimensions');
add_action('wp_ajax_nopriv_csp_validate_dimensions', 'csp_validate_dimensions');
function csp_validate_dimensions() {
    $product_id = intval($_POST['product_id']);
    $height = floatval($_POST['height']);
    $width = floatval($_POST['width']);
    
    $ranges = get_post_meta($product_id, '_csp_size_ranges', true);
    
    foreach ($ranges as $range) {
        if ($height >= $range['height_min'] && $height <= $range['height_max'] &&
            $width >= $range['width_min'] && $width <= $range['width_max']) {
            wp_send_json_success(['price' => $range['price']]);
        }
    }
    
    wp_send_json_error(['message' => 'Invalid dimensions. No matching size range found.']);
}
