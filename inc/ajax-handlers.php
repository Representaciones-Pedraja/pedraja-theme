<?php
/**
 * AJAX Handlers - Quick View, Add to Cart, etc.
 */

if (!defined('ABSPATH')) exit;

// =============================
// QUICK VIEW
// =============================
function pedraja_quick_view() {
    check_ajax_referer('pedraja_nonce', 'nonce');
    
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    
    if (!$product_id) {
        wp_send_json_error('Invalid product ID');
    }
    
    global $post, $product;
    $post = get_post($product_id);
    $product = wc_get_product($product_id);
    
    if (!$product) {
        wp_send_json_error('Product not found');
    }
    
    setup_postdata($post);
    
    ob_start();
    
    wc_get_template('content-single-product-quick-view.php', [
        'product' => $product
    ]);
    
    $html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success([
        'html' => $html
    ]);
}
add_action('wp_ajax_pedraja_quick_view', 'pedraja_quick_view');
add_action('wp_ajax_nopriv_pedraja_quick_view', 'pedraja_quick_view');

// =============================
// ADD TO CART (AJAX)
// =============================
function pedraja_ajax_add_to_cart() {
    check_ajax_referer('pedraja_nonce', 'nonce');
    
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if ($product_id) {
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
        
        if ($cart_item_key) {
            wp_send_json_success([
                'message' => 'Producto añadido al carrito',
                'cart_count' => WC()->cart->get_cart_contents_count(),
                'cart_total' => WC()->cart->get_cart_total()
            ]);
        }
    }
    
    wp_send_json_error('Error al añadir producto');
}
add_action('wp_ajax_pedraja_add_to_cart', 'pedraja_ajax_add_to_cart');
add_action('wp_ajax_nopriv_pedraja_add_to_cart', 'pedraja_ajax_add_to_cart');

// =============================
// UPDATE CART FRAGMENTS
// =============================
function pedraja_cart_fragments($fragments) {
    ob_start();
    ?>
    <span class="cart-count badge position-absolute top-0 start-100 translate-middle bg-primary">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'pedraja_cart_fragments');

// =============================
// LOAD MORE PRODUCTS (AJAX)
// =============================
function pedraja_load_more_products() {
    check_ajax_referer('pedraja_nonce', 'nonce');
    
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = get_theme_mod('products_per_page', 12);
    
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'post_status' => 'publish'
    ];
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        woocommerce_product_loop_start();
        
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
        
        woocommerce_product_loop_end();
    }
    
    $html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success([
        'html' => $html,
        'max_pages' => $query->max_num_pages,
        'current_page' => $paged
    ]);
}
add_action('wp_ajax_pedraja_load_more', 'pedraja_load_more_products');
add_action('wp_ajax_nopriv_pedraja_load_more', 'pedraja_load_more_products');

// =============================
// PRODUCT SEARCH SUGGESTIONS (AJAX)
// =============================
function pedraja_search_suggestions() {
    check_ajax_referer('pedraja_nonce', 'nonce');
    
    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    
    if (strlen($search_query) < 3) {
        wp_send_json_success(['products' => []]);
    }
    
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 5,
        's' => $search_query,
        'post_status' => 'publish'
    ];
    
    $query = new WP_Query($args);
    $products = [];
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            
            $products[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'price' => $product->get_price_html()
            ];
        }
    }
    
    wp_reset_postdata();
    
    wp_send_json_success(['products' => $products]);
}
add_action('wp_ajax_pedraja_search', 'pedraja_search_suggestions');
add_action('wp_ajax_nopriv_pedraja_search', 'pedraja_search_suggestions');
?>