<?php
/**
 * Pedraja Theme - Falcon Style
 * Version: 3.0.0
 */

if (!defined("ABSPATH")) exit;

define("PEDRAJA_VERSION", "3.0.0");
define("PEDRAJA_URI", get_template_directory_uri());
define("PEDRAJA_DIR", get_template_directory());

// =============================
// SETUP THEME
// =============================
function pedraja_setup() {
    add_theme_support("title-tag");
    add_theme_support("custom-logo", [
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support("post-thumbnails");
    
    // Tamaños de imagen
    add_image_size("pedraja-thumb", 300, 300, true);
    add_image_size("pedraja-medium", 600, 600, true);
    add_image_size("pedraja-large", 1200, 1200, false);
    
    // Menús
    register_nav_menus([
        "primary" => __("Menú Principal", "pedraja"),
        "footer" => __("Menú Footer", "pedraja")
    ]);
    
    // WooCommerce
    add_theme_support("woocommerce");
    add_theme_support("wc-product-gallery-zoom");
    add_theme_support("wc-product-gallery-lightbox");
    add_theme_support("wc-product-gallery-slider");
    
    // HTML5
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
        "style",
        "script"
    ]);
    
    // Editor styles
    add_theme_support("editor-styles");
    add_editor_style("assets/css/editor-style.css");
    
    // Responsive embeds
    add_theme_support("responsive-embeds");
    
    // Custom background
    add_theme_support("custom-background", [
        'default-color' => 'ffffff',
    ]);
}
add_action("after_setup_theme", "pedraja_setup");

// =============================
// ENQUEUE SCRIPTS & STYLES
// =============================
function pedraja_scripts() {
    // CSS
    wp_enqueue_style("bootstrap", "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css", [], "5.3.2");
    wp_enqueue_style("fontawesome", "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css", [], "6.5.1");
    wp_enqueue_style("swiper", "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css", [], "11.0.0");
    wp_enqueue_style("pedraja-style", get_stylesheet_uri(), [], PEDRAJA_VERSION);
    wp_enqueue_style("pedraja-custom", PEDRAJA_URI . "/assets/css/custom.css", ["pedraja-style"], PEDRAJA_VERSION);
    
    // JS
    wp_enqueue_script("bootstrap", "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js", [], "5.3.2", true);
    wp_enqueue_script("swiper", "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js", [], "11.0.0", true);
    wp_enqueue_script("pedraja-theme", PEDRAJA_URI . "/assets/js/theme.js", ["jquery"], PEDRAJA_VERSION, true);
    
    // Localize script
    wp_localize_script("pedraja-theme", "pedrajaData", [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('pedraja_nonce'),
        'cartUrl' => wc_get_cart_url(),
    ]);
}
add_action("wp_enqueue_scripts", "pedraja_scripts", 999);

// Desactivar CSS de WooCommerce que interfiere
add_filter('woocommerce_enqueue_styles', function($styles) {
    unset($styles['woocommerce-general']);
    unset($styles['woocommerce-layout']);
    return $styles;
});

// =============================
// WIDGETS
// =============================
function pedraja_widgets() {
    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar([
            "name" => sprintf(__("Footer %d", "pedraja"), $i),
            "id" => "footer-" . $i,
            "description" => sprintf(__("Área de widgets del footer %d", "pedraja"), $i),
            "before_widget" => '<div id="%1$s" class="widget %2$s mb-3">',
            "after_widget" => '</div>',
            "before_title" => '<h4 class="widget-title fw-bold mb-3">',
            "after_title" => '</h4>'
        ]);
    }
    
    // Shop sidebar
    register_sidebar([
        "name" => __("Sidebar Tienda", "pedraja"),
        "id" => "shop-sidebar",
        "description" => __("Aparece en las páginas de la tienda", "pedraja"),
        "before_widget" => '<div id="%1$s" class="widget sidebar-widget mb-4 %2$s">',
        "after_widget" => '</div>',
        "before_title" => '<h4 class="widget-title fw-bold text-uppercase mb-3">',
        "after_title" => '</h4>'
    ]);
}
add_action("widgets_init", "pedraja_widgets");

// =============================
// INCLUDES
// =============================
require_once PEDRAJA_DIR . "/inc/customizer.php";
require_once PEDRAJA_DIR . "/inc/woocommerce-functions.php";

if (file_exists(PEDRAJA_DIR . "/inc/ajax-handlers.php")) {
    require_once PEDRAJA_DIR . "/inc/ajax-handlers.php";
}

// =============================
// CONTENT WIDTH
// =============================
if (!isset($content_width)) {
    $content_width = 1200;
}

// =============================
// EXCERPT
// =============================
function pedraja_excerpt_length($length) {
    return get_theme_mod('excerpt_length', 20);
}
add_filter("excerpt_length", "pedraja_excerpt_length");

function pedraja_excerpt_more($more) {
    return '...';
}
add_filter("excerpt_more", "pedraja_excerpt_more");

// =============================
// BODY CLASSES
// =============================
function pedraja_body_classes($classes) {
    if (is_user_logged_in()) {
        $classes[] = 'logged-in-user';
    }
    
    if (is_singular('product')) {
        $classes[] = 'single-product-page';
    }
    
    if (is_shop() || is_product_category() || is_product_tag()) {
        $classes[] = 'shop-page';
    }
    
    return $classes;
}
add_filter("body_class", "pedraja_body_classes");

// =============================
// CSS CRÍTICO INLINE
// =============================
function pedraja_critical_css() {
    ?>
    <style id="pedraja-critical-css">
    /* Grid forzado para productos */
    .woocommerce ul.products,
    ul.products {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 25px !important;
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .woocommerce ul.products li.product {
        min-height: 420px !important;
        display: flex !important;
        flex-direction: column !important;
        padding: 25px !important;
        background: #fff !important;
        border: 1px solid #e5e5e5 !important;
        border-radius: 8px !important;
        margin: 0 !important;
        width: auto !important;
        float: none !important;
    }
    
    .woocommerce ul.products li.product img {
        height: 250px !important;
        width: 100% !important;
        object-fit: contain !important;
        margin-bottom: 20px !important;
    }
    
    .woocommerce ul.products li.product .button {
        width: 100% !important;
        padding: 14px 24px !important;
        margin-top: auto !important;
        background: <?php echo get_theme_mod('pedraja_primary_color', '#0273EB'); ?> !important;
        color: #fff !important;
        border: none !important;
    }
    
    @media (max-width: 991px) {
        .woocommerce ul.products {
            grid-template-columns: repeat(3, 1fr) !important;
        }
    }
    
    @media (max-width: 767px) {
        .woocommerce ul.products {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15px !important;
        }
        .woocommerce ul.products li.product {
            padding: 15px !important;
            min-height: 320px !important;
        }
        .woocommerce ul.products li.product img {
            height: 150px !important;
        }
    }
    </style>
    <?php
}
add_action("wp_head", "pedraja_critical_css", 1);

// =============================
// ADMIN NOTICES
// =============================
function pedraja_admin_notices() {
    if (!class_exists('WooCommerce')) {
        ?>
        <div class="notice notice-error">
            <p><strong>Pedraja Theme:</strong> Este theme requiere WooCommerce. Por favor, instala y activa WooCommerce.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'pedraja_admin_notices');

// =============================
// REMOVE EMOJI
// =============================
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// =============================
// SEARCH ONLY PRODUCTS
// =============================
function pedraja_search_filter($query) {
    if ($query->is_search && !is_admin() && $query->is_main_query()) {
        if (get_theme_mod('search_only_products', true)) {
            $query->set('post_type', 'product');
        }
    }
    return $query;
}
add_filter('pre_get_posts', 'pedraja_search_filter');
?>