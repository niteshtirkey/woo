<?php
if (!defined('ABSPATH')) exit;

// Add custom data to cart item
add_filter('woocommerce_add_cart_item_data', 'csp_add_cart_item_data', 10, 2);
function csp_add_cart_item_data($cart_item_data, $product_id) {
    if (isset($_POST['csp_height']) && isset($_POST['csp_width'])) {
        $height = floatval($_POST['csp_height']);
        $width = floatval($_POST['csp_width']);
        
        $ranges = get_post_meta($product_id, '_csp_size_ranges', true);
        
        foreach ($ranges as $range) {
            if ($height >= $range['height_min'] && $height <= $range['height_max'] &&
                $width >= $range['width_min'] && $width <= $range['width_max']) {
                
                $cart_item_data['csp_height'] = $height;
                $cart_item_data['csp_width'] = $width;
                $cart_item_data['csp_price'] = $range['price'];
                break;
            }
        }
    }
    
    return $cart_item_data;
}

// Display custom data in cart
add_filter('woocommerce_get_item_data', 'csp_display_cart_item_data', 10, 2);
function csp_display_cart_item_data($item_data, $cart_item) {
    if (isset($cart_item['csp_height'])) {
        $item_data[] = [
            'name' => 'Height',
            'value' => $cart_item['csp_height']
        ];
    }
    
    if (isset($cart_item['csp_width'])) {
        $item_data[] = [
            'name' => 'Width',
            'value' => $cart_item['csp_width']
        ];
    }
    
    return $item_data;
}

// Update cart item price
add_action('woocommerce_before_calculate_totals', 'csp_update_cart_item_price');
function csp_update_cart_item_price($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    
    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['csp_price'])) {
            $cart_item['data']->set_price($cart_item['csp_price']);
        }
    }
}

// Add custom data to order items
add_action('woocommerce_checkout_create_order_line_item', 'csp_add_order_item_meta', 10, 4);
function csp_add_order_item_meta($item, $cart_item_key, $values, $order) {
    if (isset($values['csp_height'])) {
        $item->add_meta_data('Height', $values['csp_height']);
    }
    
    if (isset($values['csp_width'])) {
        $item->add_meta_data('Width', $values['csp_width']);
    }
}
