<?php
/**
 * Template para categorías de productos - Pedraja Theme
 */

defined('ABSPATH') || exit;
get_header('shop');
?>

<div class="container-fluid py-4">
    
    <!-- BANNER NUEVO CATÁLOGO (si está activado en customizer) -->
    <?php if (get_theme_mod('show_category_banner', true) && is_product_category()): ?>
    <div class="category-banner bg-danger text-white text-center py-3 mb-4 rounded">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start">
                <h2 class="h5 mb-0 fw-bold">
                    <i class="fas fa-gift me-2"></i>
                    <?php echo esc_html(get_theme_mod('category_banner_text', '¡DESCÁRGATE NUESTRO NUEVO CATÁLOGO!')); ?>
                </h2>
            </div>
            <div class="col-md-6 text-md-end">
                <?php if (get_theme_mod('category_banner_link')): ?>
                <a href="<?php echo esc_url(get_theme_mod('category_banner_link')); ?>" class="btn btn-light btn-sm" target="_blank">
                    <i class="fas fa-download me-1"></i> Descargar Catálogo
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
        
        <!-- SIDEBAR IZQUIERDO -->
        <aside class="col-lg-3 d-none d-lg-block">
            <div class="shop-sidebar">
                
                <!-- CATEGORÍAS -->
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title fw-bold text-uppercase mb-3" style="font-size: 14px;">Categorías</h4>
                    <ul class="list-unstyled category-list">
                        <?php
                        $current_cat = get_queried_object();
                        $current_cat_id = is_tax('product_cat') ? $current_cat->term_id : 0;
                        
                        // Obtener categorías padre
                        $parent_cats = get_terms([
                            'taxonomy' => 'product_cat',
                            'parent' => 0,
                            'hide_empty' => true,
                            'orderby' => 'name'
                        ]);
                        
                        foreach ($parent_cats as $parent_cat):
                            $is_current = ($current_cat_id == $parent_cat->term_id);
                            $has_children = get_term_children($parent_cat->term_id, 'product_cat');
                        ?>
                        <li class="mb-2">
                            <a href="<?php echo get_term_link($parent_cat); ?>" 
                               class="d-block py-2 px-3 rounded text-decoration-none <?php echo $is_current ? 'bg-primary text-white fw-bold' : 'text-dark'; ?>">
                                <?php echo esc_html($parent_cat->name); ?>
                                <span class="badge bg-light text-dark float-end"><?php echo $parent_cat->count; ?></span>
                            </a>
                            
                            <?php if ($has_children && $is_current): 
                                $child_cats = get_terms([
                                    'taxonomy' => 'product_cat',
                                    'parent' => $parent_cat->term_id,
                                    'hide_empty' => true
                                ]);
                            ?>
                            <ul class="list-unstyled ps-3 mt-2">
                                <?php foreach ($child_cats as $child_cat): ?>
                                <li class="mb-1">
                                    <a href="<?php echo get_term_link($child_cat); ?>" class="d-block py-1 px-2 text-secondary small">
                                        <?php echo esc_html($child_cat->name); ?> (<?php echo $child_cat->count; ?>)
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <!-- FILTROS DE WOOCOMMERCE (si hay widgets) -->
                <?php if (is_active_sidebar('shop-sidebar')): ?>
                    <?php dynamic_sidebar('shop-sidebar'); ?>
                <?php endif; ?>
                
            </div>
        </aside>
        
        <!-- CONTENIDO PRINCIPAL -->
        <div class="col-lg-9">
            
            <?php if (apply_filters('woocommerce_show_page_title', true)): ?>
                <h1 class="page-title section-title mb-3"><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>
            
            <?php do_action('woocommerce_archive_description'); ?>
            
            <!-- SUBCATEGORÍAS COMO BOTONES -->
            <?php if (is_product_category()): 
                $current_cat = get_queried_object();
                $subcategories = get_terms([
                    'taxonomy' => 'product_cat',
                    'parent' => $current_cat->term_id,
                    'hide_empty' => true
                ]);
                
                if ($subcategories && !is_wp_error($subcategories)):
            ?>
            <div class="subcategories-buttons mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <?php 
                    $show_images = get_theme_mod('subcategories_show_images', false);
                    foreach ($subcategories as $subcat): 
                        $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true);
                        $image = wp_get_attachment_url($thumbnail_id);
                    ?>
                    <a href="<?php echo get_term_link($subcat); ?>" class="btn btn-outline-primary btn-sm text-uppercase">
                        <?php if ($show_images && $image): ?>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($subcat->name); ?>" style="height:20px;width:auto;margin-right:5px">
                        <?php endif; ?>
                        <?php echo esc_html($subcat->name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; endif; ?>
            
            <?php if (woocommerce_product_loop()): ?>
                
                <?php do_action('woocommerce_before_shop_loop'); ?>
                
                <?php woocommerce_product_loop_start(); ?>
                
                <?php if (wc_get_loop_prop('total')): ?>
                    <?php while (have_posts()): the_post(); ?>
                        <?php do_action('woocommerce_shop_loop'); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>
                <?php endif; ?>
                
                <?php woocommerce_product_loop_end(); ?>
                
                <?php do_action('woocommerce_after_shop_loop'); ?>
                
            <?php else: ?>
                <?php do_action('woocommerce_no_products_found'); ?>
            <?php endif; ?>
            
        </div>
        
    </div>
    
</div>

<?php get_footer('shop'); ?>