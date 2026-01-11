<?php
/**
 * Template para todas las páginas de WooCommerce
 */
get_header(); ?>

<div class="container py-4">
    <div class="row">
        
        <?php if (is_active_sidebar('shop-sidebar')): ?>
            <!-- Sidebar con filtros -->
            <aside class="col-lg-3 mb-4">
                <div class="shop-sidebar">
                    <?php dynamic_sidebar('shop-sidebar'); ?>
                </div>
            </aside>
            <div class="col-lg-9">
        <?php else: ?>
            <div class="col-12">
        <?php endif; ?>
        
            <?php
            // Breadcrumbs de WooCommerce
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb([
                    'delimiter'   => ' <i class="fas fa-chevron-right small mx-2"></i> ',
                    'wrap_before' => '<nav class="woocommerce-breadcrumb mb-4 small text-muted">',
                    'wrap_after'  => '</nav>',
                ]);
            }
            
            // Contenido principal de WooCommerce
            woocommerce_content();
            ?>
            
        </div>
    </div>
</div>

<?php get_footer(); ?>