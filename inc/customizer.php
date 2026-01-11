<?php
/**
 * Customizer DEFINITIVO - 100% Configurable
 * Pedraja Theme - Falcon Style
 */

function pedraja_customizer($wp_customize) {
    
    // =============================
    // PANEL PRINCIPAL
    // =============================
    $wp_customize->add_panel('pedraja_panel', [
        'title' => __('Configuración Pedraja', 'pedraja'),
        'priority' => 10,
    ]);
    
    // =============================
    // INFORMACIÓN GENERAL
    // =============================
    $wp_customize->add_section("pedraja_general", [
        "title" => __("Información General", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 10
    ]);
    
    // Teléfono
    $wp_customize->add_setting("pedraja_phone", [
        "default" => "622138001",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "refresh"
    ]);
    $wp_customize->add_control("pedraja_phone", [
        "label" => __("Teléfono de contacto", "pedraja"),
        "description" => __("Aparece en el header y footer", "pedraja"),
        "section" => "pedraja_general",
        "type" => "text"
    ]);
    
    // Icono del teléfono
    $wp_customize->add_setting("phone_icon", [
        "default" => "fas fa-phone",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    $wp_customize->add_control("phone_icon", [
        "label" => __("Icono del teléfono (FontAwesome)", "pedraja"),
        "description" => __("Ej: fas fa-phone, fas fa-mobile-alt, fas fa-phone-alt", "pedraja"),
        "section" => "pedraja_general",
        "type" => "text"
    ]);
    
    // Mostrar teléfono en header
    $wp_customize->add_setting("show_phone_header", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_phone_header", [
        "label" => __("Mostrar teléfono en header", "pedraja"),
        "section" => "pedraja_general",
        "type" => "checkbox"
    ]);
    
    // Botón día/noche
    $wp_customize->add_setting("show_theme_toggle", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_theme_toggle", [
        "label" => __("Mostrar botón modo oscuro/claro", "pedraja"),
        "section" => "pedraja_general",
        "type" => "checkbox"
    ]);
    
    // Email
    $wp_customize->add_setting("pedraja_email", [
        "default" => "",
        "sanitize_callback" => "sanitize_email"
    ]);
    $wp_customize->add_control("pedraja_email", [
        "label" => __("Email de contacto", "pedraja"),
        "section" => "pedraja_general",
        "type" => "email"
    ]);
    
    // =============================
    // COLORES
    // =============================
    $wp_customize->add_section("pedraja_colors", [
        "title" => __("Colores", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 20
    ]);
    
    // Color primario
    $wp_customize->add_setting("pedraja_primary_color", [
        "default" => "#0273EB",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage"
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "pedraja_primary_color", [
        "label" => __("Color Primario", "pedraja"),
        "description" => __("Botones, enlaces, badges", "pedraja"),
        "section" => "pedraja_colors"
    ]));
    
    // Color secundario
    $wp_customize->add_setting("pedraja_secondary_color", [
        "default" => "#6c757d",
        "sanitize_callback" => "sanitize_hex_color"
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "pedraja_secondary_color", [
        "label" => __("Color Secundario", "pedraja"),
        "section" => "pedraja_colors"
    ]));
    
    // Color del footer
    $wp_customize->add_setting("pedraja_footer_bg", [
        "default" => "#2d2d2d",
        "sanitize_callback" => "sanitize_hex_color"
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "pedraja_footer_bg", [
        "label" => __("Color de fondo del Footer", "pedraja"),
        "section" => "pedraja_colors"
    ]));
    
    // =============================
    // BANNER DE CATEGORÍAS
    // =============================
    $wp_customize->add_section("pedraja_category_banner", [
        "title" => __("Banner de Categorías", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 30
    ]);
    
    // Mostrar banner
    $wp_customize->add_setting("show_category_banner", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_category_banner", [
        "label" => __("Mostrar banner en categorías", "pedraja"),
        "section" => "pedraja_category_banner",
        "type" => "checkbox"
    ]);
    
    // Texto del banner
    $wp_customize->add_setting("category_banner_text", [
        "default" => "¡DESCÁRGATE NUESTRO NUEVO CATÁLOGO!",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    $wp_customize->add_control("category_banner_text", [
        "label" => __("Texto del banner", "pedraja"),
        "section" => "pedraja_category_banner",
        "type" => "text"
    ]);
    
    // Enlace del catálogo
    $wp_customize->add_setting("category_banner_link", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw"
    ]);
    $wp_customize->add_control("category_banner_link", [
        "label" => __("Enlace del catálogo (PDF)", "pedraja"),
        "description" => __("URL completa del PDF", "pedraja"),
        "section" => "pedraja_category_banner",
        "type" => "url"
    ]);
    
    // Mostrar imágenes o texto en banner de marcas
    $wp_customize->add_setting("banner_brands_type", [
        "default" => "text",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    $wp_customize->add_control("banner_brands_type", [
        "label" => __("Tipo de visualización de marcas", "pedraja"),
        "description" => __("Mostrar imágenes o nombres de categorías", "pedraja"),
        "section" => "pedraja_category_banner",
        "type" => "select",
        "choices" => [
            "text" => __("Texto (nombres)", "pedraja"),
            "images" => __("Imágenes", "pedraja")
        ]
    ]);
    
    // Seleccionar categorías padre para el banner
    $wp_customize->add_setting("banner_categories", [
        "default" => "",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    
    // Obtener categorías padre de WooCommerce
    $parent_categories = [];
    if (class_exists('WooCommerce')) {
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'parent' => 0,
            'hide_empty' => false
        ]);
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $parent_categories[$term->term_id] = $term->name;
            }
        }
    }
    
    $wp_customize->add_control("banner_categories", [
        "label" => __("Categorías a mostrar", "pedraja"),
        "description" => __("Deja vacío para mostrar todas las categorías padre", "pedraja"),
        "section" => "pedraja_category_banner",
        "type" => "select",
        "choices" => array_merge(
            ['' => __('Todas las categorías padre', 'pedraja')],
            $parent_categories
        )
    ]);
    
    // =============================
    // SUBCATEGORÍAS
    // =============================
    $wp_customize->add_section("pedraja_subcategories", [
        "title" => __("Subcategorías", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 40
    ]);
    
    // Mostrar imágenes en botones de subcategorías
    $wp_customize->add_setting("subcategories_show_images", [
        "default" => false,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("subcategories_show_images", [
        "label" => __("Mostrar imágenes en botones de subcategorías", "pedraja"),
        "section" => "pedraja_subcategories",
        "type" => "checkbox"
    ]);
    
    // =============================
    // PRODUCTOS
    // =============================
    $wp_customize->add_section("pedraja_products", [
        "title" => __("Productos", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 50
    ]);
    
    // Productos por página
    $wp_customize->add_setting("products_per_page", [
        "default" => 12,
        "sanitize_callback" => "absint"
    ]);
    $wp_customize->add_control("products_per_page", [
        "label" => __("Productos por página", "pedraja"),
        "section" => "pedraja_products",
        "type" => "number",
        "input_attrs" => ["min" => 4, "max" => 48, "step" => 4]
    ]);
    
    // Columnas desktop
    $wp_customize->add_setting("products_columns", [
        "default" => 4,
        "sanitize_callback" => "absint"
    ]);
    $wp_customize->add_control("products_columns", [
        "label" => __("Columnas en Desktop", "pedraja"),
        "section" => "pedraja_products",
        "type" => "select",
        "choices" => [
            "3" => "3 columnas",
            "4" => "4 columnas",
            "5" => "5 columnas"
        ]
    ]);
    
    // Badge "Nuevo"
    $wp_customize->add_setting("show_new_badge", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_new_badge", [
        "label" => __("Mostrar badge 'Nuevo'", "pedraja"),
        "section" => "pedraja_products",
        "type" => "checkbox"
    ]);
    
    // Días para badge nuevo
    $wp_customize->add_setting("new_badge_days", [
        "default" => 30,
        "sanitize_callback" => "absint"
    ]);
    $wp_customize->add_control("new_badge_days", [
        "label" => __("Días para mostrar 'Nuevo'", "pedraja"),
        "section" => "pedraja_products",
        "type" => "number",
        "input_attrs" => ["min" => 1, "max" => 90]
    ]);
    
    // Vista rápida
    $wp_customize->add_setting("show_quick_view", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_quick_view", [
        "label" => __("Mostrar icono de vista rápida", "pedraja"),
        "section" => "pedraja_products",
        "type" => "checkbox"
    ]);
    
    // =============================
    // PÁGINA DE PRODUCTO
    // =============================
    $wp_customize->add_section("pedraja_product_page", [
        "title" => __("Página de Producto", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 60
    ]);
    
    // Política de ventas
    $wp_customize->add_setting("show_sales_policy", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_sales_policy", [
        "label" => __("Mostrar política de ventas", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "checkbox"
    ]);
    
    $wp_customize->add_setting("sales_policy_text", [
        "default" => "Solo venta a profesionales del sector.",
        "sanitize_callback" => "sanitize_textarea_field"
    ]);
    $wp_customize->add_control("sales_policy_text", [
        "label" => __("Texto política de ventas", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "textarea"
    ]);
    
    // Política de pedidos
    $wp_customize->add_setting("show_order_policy", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_order_policy", [
        "label" => __("Mostrar política de pedidos", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "checkbox"
    ]);
    
    $wp_customize->add_setting("order_policy_text", [
        "default" => "Un pedido por fabricante.",
        "sanitize_callback" => "sanitize_textarea_field"
    ]);
    $wp_customize->add_control("order_policy_text", [
        "label" => __("Texto política de pedidos", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "textarea"
    ]);
    
    // Soporte
    $wp_customize->add_setting("show_support", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_support", [
        "label" => __("Mostrar información de soporte", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "checkbox"
    ]);
    
    $wp_customize->add_setting("support_text", [
        "default" => "Atención al Cliente 24/7",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    $wp_customize->add_control("support_text", [
        "label" => __("Texto de soporte", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "text"
    ]);
    
    // Compartir
    $wp_customize->add_setting("show_product_share", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_product_share", [
        "label" => __("Mostrar botones de compartir", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "checkbox"
    ]);
    
    // Productos relacionados
    $wp_customize->add_setting("show_related_products", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean"
    ]);
    $wp_customize->add_control("show_related_products", [
        "label" => __("Mostrar productos relacionados", "pedraja"),
        "section" => "pedraja_product_page",
        "type" => "checkbox"
    ]);
    
    // =============================
    // REDES SOCIALES
    // =============================
    $wp_customize->add_section("pedraja_social", [
        "title" => __("Redes Sociales", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 70
    ]);
    
    $social_networks = [
        "facebook" => "Facebook",
        "twitter" => "Twitter",
        "instagram" => "Instagram",
        "linkedin" => "LinkedIn",
        "youtube" => "YouTube"
    ];
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("social_" . $network, [
            "default" => "",
            "sanitize_callback" => "esc_url_raw"
        ]);
        $wp_customize->add_control("social_" . $network, [
            "label" => sprintf(__("URL de %s", "pedraja"), $label),
            "section" => "pedraja_social",
            "type" => "url"
        ]);
    }
    
    // =============================
    // FOOTER
    // =============================
    $wp_customize->add_section("pedraja_footer", [
        "title" => __("Footer", "pedraja"),
        "panel" => "pedraja_panel",
        "priority" => 80
    ]);
    
    // Copyright
    $wp_customize->add_setting("footer_copyright", [
        "default" => "Todos los derechos reservados",
        "sanitize_callback" => "sanitize_text_field"
    ]);
    $wp_customize->add_control("footer_copyright", [
        "label" => __("Texto de copyright", "pedraja"),
        "section" => "pedraja_footer",
        "type" => "text"
    ]);
}
add_action("customize_register", "pedraja_customizer");

// Aplicar colores personalizados
function pedraja_custom_colors() {
    $primary = get_theme_mod("pedraja_primary_color", "#0273EB");
    $footer_bg = get_theme_mod("pedraja_footer_bg", "#2d2d2d");
    ?>
    <style id="pedraja-custom-colors">
    :root {
        --theme-primary: <?php echo esc_attr($primary); ?>;
        --footer-bg: <?php echo esc_attr($footer_bg); ?>;
    }
    .btn-primary, .btn-theme, .woocommerce .button,
    .woocommerce ul.products li.product .button,
    .badge.bg-primary {
        background: var(--theme-primary) !important;
        border-color: var(--theme-primary) !important;
    }
    .text-primary, a:hover, .horizontal-nav .nav-link:hover,
    .product-price, .woocommerce ul.products li.product .price ins {
        color: var(--theme-primary) !important;
    }
    .site-footer {
        background: var(--footer-bg) !important;
    }
    </style>
    <?php
}
add_action("wp_head", "pedraja_custom_colors", 99);
?>