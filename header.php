<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo("charset"); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOP BAR (Teléfono + Modo día/noche) -->
<?php if (get_theme_mod("show_phone_header", true) || get_theme_mod("show_theme_toggle", true)): ?>
<div class="top-bar bg-light border-bottom py-2">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6">
                <?php if (get_theme_mod("show_phone_header", true)): ?>
                <small class="text-muted">
                    <i class="fas fa-phone me-1"></i> 
                    Llamamos <?php echo get_theme_mod("pedraja_phone", "622138001"); ?>
                </small>
                <?php endif; ?>
            </div>
            <div class="col-6 text-end">
                <?php if (get_theme_mod("show_theme_toggle", true)): ?>
                <button id="theme-toggle" class="btn btn-sm btn-outline-secondary border-0" aria-label="Cambiar tema">
                    <i class="fas fa-sun theme-icon-light"></i>
                    <i class="fas fa-moon theme-icon-dark d-none"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- HEADER PRINCIPAL -->
<header class="main-header bg-white py-3 shadow-sm sticky-top">
    <div class="container-fluid">
        <div class="row align-items-center gx-3">
            
            <!-- HAMBURGUESA (móvil) + LOGO -->
            <div class="col-auto d-flex align-items-center gap-3">
                <button class="btn btn-link text-dark p-0 border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Menú">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <a href="<?php echo home_url(); ?>" class="logo-link">
                    <?php if (has_custom_logo()): 
                        the_custom_logo(); 
                    else: ?>
                        <h1 class="h5 mb-0">Representaciones Pedraja</h1>
                    <?php endif; ?>
                </a>
            </div>

            <!-- BUSCADOR CENTRAL (Desktop) -->
            <div class="col d-none d-lg-block">
                <form method="get" action="<?php echo home_url(); ?>" class="search-form-header">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-lg border-end-0" name="s" placeholder="Introduce lo que buscas" aria-label="Buscar">
                        <input type="hidden" name="post_type" value="product">
                        <button type="submit" class="btn btn-outline-secondary border-start-0 bg-white" aria-label="Buscar">
                            <i class="fas fa-search text-primary"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- ICONOS DERECHA -->
            <div class="col-auto">
                <div class="d-flex align-items-center gap-3">
                    
                    <!-- Lupa móvil -->
                    <button class="btn btn-link text-dark p-0 border-0 d-lg-none" type="button" data-bs-toggle="modal" data-bs-target="#searchModal" aria-label="Buscar">
                        <i class="fas fa-search fa-lg"></i>
                    </button>

                    <!-- Usuario -->
                    <a href="<?php echo wc_get_page_permalink("myaccount"); ?>" class="text-dark" aria-label="Mi cuenta">
                        <i class="fas fa-user fa-lg"></i>
                    </a>

                    <!-- CARRITO -->
                    <?php if (class_exists("WooCommerce")): ?>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="text-dark position-relative" aria-label="Carrito">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <?php $count = WC()->cart->get_cart_contents_count(); if ($count > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary" style="font-size:10px">
                            <?php echo $count; ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</header>

<!-- MENÚ HORIZONTAL (Desktop) -->
<nav class="horizontal-nav bg-white border-top border-bottom d-none d-lg-block">
    <div class="container-fluid">
        <ul class="nav justify-content-start mb-0">
            <?php
            // Obtener categorías padre de WooCommerce
            if (class_exists('WooCommerce')) {
                $categories = get_terms([
                    'taxonomy' => 'product_cat',
                    'parent' => 0,
                    'hide_empty' => true,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ]);
                
                if ($categories && !is_wp_error($categories)):
                    foreach ($categories as $category):
            ?>
            <li class="nav-item">
                <a class="nav-link text-dark fw-semibold text-uppercase px-4 py-3" href="<?php echo get_term_link($category); ?>">
                    <?php echo esc_html($category->name); ?>
                </a>
            </li>
            <?php
                    endforeach;
                endif;
            }
            ?>
        </ul>
    </div>
</nav>

<!-- OFFCANVAS MENÚ MÓVIL -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="mobileMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush">
            <?php
            if (class_exists('WooCommerce')) {
                $categories = get_terms([
                    'taxonomy' => 'product_cat',
                    'parent' => 0,
                    'hide_empty' => true
                ]);
                
                if ($categories && !is_wp_error($categories)):
                    foreach ($categories as $category):
            ?>
            <a href="<?php echo get_term_link($category); ?>" class="list-group-item list-group-item-action text-uppercase fw-semibold">
                <?php echo esc_html($category->name); ?>
            </a>
            <?php
                    endforeach;
                endif;
            }
            ?>
            
            <?php if (get_theme_mod("show_phone_header", true)): ?>
            <div class="list-group-item border-top mt-3">
                <small class="text-muted">
                    <i class="fas fa-phone me-2"></i>
                    Llamamos <?php echo get_theme_mod("pedraja_phone", "622138001"); ?>
                </small>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL BÚSQUEDA MÓVIL -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body pt-0">
                <form method="get" action="<?php echo home_url(); ?>">
                    <div class="input-group input-group-lg">
                        <input type="search" class="form-control border-0 border-bottom rounded-0" name="s" placeholder="Introduce lo que buscas" autofocus>
                        <input type="hidden" name="post_type" value="product">
                        <button type="submit" class="btn btn-link text-primary">
                            <i class="fas fa-search fa-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="site-main">