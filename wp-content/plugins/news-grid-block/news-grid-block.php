<?php
/**
 * Plugin Name: News Grid Block
 * Description: Custom Gutenberg block for displaying News posts in a grid
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

// Register News Custom Post Type
add_action('init', 'ngb_register_news_cpt');
function ngb_register_news_cpt() {
    register_post_type('news', [
        'labels' => [
            'name' => 'News',
            'singular_name' => 'News',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New News',
            'edit_item' => 'Edit News',
            'all_items' => 'All News'
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-megaphone'
    ]);
    
    register_taxonomy('news_category', 'news', [
        'labels' => [
            'name' => 'News Categories',
            'singular_name' => 'News Category'
        ],
        'hierarchical' => true,
        'show_in_rest' => true
    ]);
}

// Register Gutenberg Block
add_action('init', 'ngb_register_block');
function ngb_register_block() {
    wp_register_script(
        'ngb-block-editor',
        plugins_url('block.js', __FILE__),
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'],
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );
    
    wp_register_style(
        'ngb-block-style',
        plugins_url('style.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );
    
    register_block_type('ngb/news-grid', [
        'editor_script' => 'ngb-block-editor',
        'style' => 'ngb-block-style',
        'render_callback' => 'ngb_render_block',
        'attributes' => [
            'category' => [
                'type' => 'string',
                'default' => ''
            ],
            'postsPerPage' => [
                'type' => 'number',
                'default' => 6
            ]
        ]
    ]);
}

// Render Block on Frontend
function ngb_render_block($attributes) {
    $category = isset($attributes['category']) ? $attributes['category'] : '';
    $posts_per_page = isset($attributes['postsPerPage']) ? $attributes['postsPerPage'] : 6;
    
    $args = [
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish'
    ];
    
    if (!empty($category)) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'news_category',
                'field' => 'slug',
                'terms' => $category
            ]
        ];
    }
    
    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        return '<p>No news found.</p>';
    }
    
    ob_start();
    ?>
    <div class="ngb-news-grid">
        <?php while ($query->have_posts()): $query->the_post(); ?>
            <div class="ngb-news-item">
                <a href="<?php the_permalink(); ?>" class="ngb-news-link">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="ngb-news-thumbnail">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="ngb-news-title"><?php the_title(); ?></h3>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
