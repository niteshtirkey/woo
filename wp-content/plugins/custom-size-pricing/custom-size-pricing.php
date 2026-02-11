<?php
/**
 * Plugin Name: Custom Size Pricing
 * Description: Custom size-based product variations with dynamic pricing
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

define('CSP_PATH', plugin_dir_path(__FILE__));
define('CSP_URL', plugin_dir_url(__FILE__));

// Include files
require_once CSP_PATH . 'admin/product-meta-box.php';
require_once CSP_PATH . 'public/product-page.php';
require_once CSP_PATH . 'public/cart-checkout.php';

// Enqueue admin scripts
add_action('admin_enqueue_scripts', 'csp_admin_scripts');
function csp_admin_scripts($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    
    global $post;
    if ($post->post_type !== 'product') return;
    
    wp_enqueue_script('csp-admin', CSP_URL . 'assets/admin.js', ['jquery'], '1.0', true);
    wp_enqueue_style('csp-admin', CSP_URL . 'assets/admin.css', [], '1.0');
}

// Enqueue frontend scripts
add_action('wp_enqueue_scripts', 'csp_frontend_scripts');
function csp_frontend_scripts() {
    if (is_product()) {
        wp_enqueue_script('csp-frontend', CSP_URL . 'assets/frontend.js', ['jquery'], '1.0', true);
        wp_enqueue_style('csp-frontend', CSP_URL . 'assets/frontend.css', [], '1.0');
    }
}
