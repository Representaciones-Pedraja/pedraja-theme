<?php
/**
 * Funciones personalizadas de WooCommerce - Pedraja Theme
 */

// Columnas de productos en el loop (configurable desde Customizer)
add_filter("loop_shop_columns", function() {
    return get_theme_mod("products_columns", 4);
});

// Productos por página (configurable desde Customizer)
add_filter("loop_shop_per_page", function() {
    return get_theme_mod("products_per_page", 12);
});

// Cambiar texto "Añadir al carrito"
add_filter("woocommerce_product_add_to_cart_text", function($text) {
    return "Añadir al carrito";
});

add_filter("woocommerce_product_single_add_to_cart_text", function() {
    return "Añadir al carrito";
});

// Quitar campos opcionales del checkout
add_filter("woocommerce_checkout_fields", function($fields) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
    return $fields;
});

// Badge "Nuevo" en productos recientes
function pedraja_product_new_badge() {
    if (!get_theme_mod("show_new_badge", true)) return;
    
    global $product;
    $created = strtotime($product->get_date_created());
    $now = time();
    $days_limit = get_theme_mod("new_badge_days", 30);
    $days = floor(($now - $created) / (60 * 60 * 24));
    
    if ($days <= $days_limit) {
        echo '<span class="badge bg-primary">Nuevo</span>';
    }
}
add_action("woocommerce_before_shop_loop_item_title", "pedraja_product_new_badge", 10);

// Badge de descuento en %
function pedraja_sale_badge() {
    global $product;
    if ($product->is_on_sale()) {
        $regular = (float) $product->get_regular_price();
        $sale = (float) $product->get_sale_price();
        if ($regular && $sale && $regular > $sale) {
            $percentage = round((($regular - $sale) / $regular) * 100);
            echo '<span class="badge bg-danger">-' . $percentage . '%</span>';
        }
    }
}
add_action("woocommerce_before_shop_loop_item_title", "pedraja_sale_badge", 10);

// Cambiar número de productos relacionados
add_filter("woocommerce_output_related_products_args", function($args) {
    $args['posts_per_page'] = 4;
    $args['columns'] = 4;
    return $args;
});

// Placeholder de búsqueda
add_filter("woocommerce_product_search_form_placeholder", function() {
    return "Buscar productos...";
});

// Personalizar breadcrumbs
add_filter("woocommerce_breadcrumb_defaults", function($defaults) {
    $defaults['delimiter'] = ' / ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb mb-3 small text-muted">';
    $defaults['wrap_after'] = '</nav>';
    return $defaults;
});

// Remover tabs por defecto en página de producto
remove_action("woocommerce_after_single_product_summary", "woocommerce_output_product_data_tabs", 10);

// Añadir clase wrapper a productos
add_filter("post_class", function($classes, $product) {
    if ("product" === get_post_type($product)) {
        $classes[] = "product-item";
    }
    return $classes;
}, 10, 2);

// Customizar el ordering dropdown
add_filter("woocommerce_catalog_orderby", function($orderby) {
    $orderby = array(
        "menu_order" => "Ordenar por defecto",
        "popularity" => "Ordenar por popularidad",
        "rating" => "Ordenar por calificación",
        "date" => "Ordenar por lo más reciente",
        "price" => "Ordenar por precio: bajo a alto",
        "price-desc" => "Ordenar por precio: alto a bajo",
    );
    return $orderby;
});

// Habilitar galería de producto
add_theme_support("wc-product-gallery-zoom");
add_theme_support("wc-product-gallery-lightbox");
add_theme_support("wc-product-gallery-slider");

// Remover skeletons en carga
add_filter("woocommerce_product_loop_start", function($html) {
    return str_replace("class=\"products", "class=\"products woocommerce", $html);
});

// Asegurar que los productos se muestren en grid
add_action("wp_head", function() {
    ?>
    <style>
    .woocommerce ul.products {
        display: grid !important;
    }
    </style>
    <?php
});