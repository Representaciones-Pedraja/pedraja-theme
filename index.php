<?php get_header(); ?>

<?php if (is_front_page()): ?>

<!-- SLIDER PRINCIPAL -->
<?php if (get_theme_mod("show_slider", true)): ?>
<section class="hero-section">
    <div class="swiper hero-swiper" style="height:500px">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background:linear-gradient(135deg,#667eea,#764ba2)">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center text-white px-4">
                            <h1 class="display-4 fw-bold mb-3">
                                <?php echo esc_html(get_theme_mod("slider_title", "Bienvenido a Representaciones Pedraja")); ?>
                            </h1>
                            <p class="lead mb-4">
                                <?php echo esc_html(get_theme_mod("slider_subtitle", "Solo Andalucía, Ceuta y Melilla")); ?>
                            </p>
                            <a href="<?php echo get_permalink(wc_get_page_id("shop")); ?>" class="btn btn-light btn-lg px-5">Ver Tienda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
<?php endif; ?>

<!-- NOVEDADES -->
<section class="products-section py-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Novedades</h2>
            <a href="<?php echo get_permalink(wc_get_page_id("shop")) . "?orderby=date"; ?>" class="btn btn-ver-mas btn-sm">
                Ver más <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <?php echo do_shortcode("[products limit=\"8\" columns=\"4\" orderby=\"date\"]"); ?>
        
        <!-- Botón Todos los productos -->
        <div class="text-center mt-4">
            <a href="<?php echo get_permalink(wc_get_page_id("shop")); ?>" class="btn all-products-btn">
                Todos los productos
            </a>
        </div>
    </div>
</section>

<!-- PRODUCTOS POPULARES -->
<section class="products-section py-5 bg-light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Productos Populares</h2>
            <a href="<?php echo get_permalink(wc_get_page_id("shop")) . "?orderby=popularity"; ?>" class="btn btn-ver-mas btn-sm">
                Ver más <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <?php echo do_shortcode("[products limit=\"8\" columns=\"4\" orderby=\"popularity\"]"); ?>
        
        <!-- Botón Todos los productos -->
        <div class="text-center mt-4">
            <a href="<?php echo get_permalink(wc_get_page_id("shop")); ?>" class="btn all-products-btn">
                Todos los productos
            </a>
        </div>
    </div>
</section>

<!-- BANNER OFERTAS ESPECIALES (Rosa) -->
<section class="py-5">
    <div class="container-fluid">
        <div class="banner-ofertas">
            <h2>Ofertas Especiales</h2>
        </div>
    </div>
</section>

<!-- LOS MÁS VENDIDOS -->
<section class="products-section py-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Los más vendidos</h2>
            <a href="<?php echo get_permalink(wc_get_page_id("shop")) . "?orderby=rating"; ?>" class="btn btn-ver-mas btn-sm">
                Ver más <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <?php echo do_shortcode("[products limit=\"8\" columns=\"4\" orderby=\"rating\"]"); ?>
        
        <!-- Botón Todos los productos -->
        <div class="text-center mt-4">
            <a href="<?php echo get_permalink(wc_get_page_id("shop")); ?>" class="btn all-products-btn">
                Todos los productos
            </a>
        </div>
    </div>
</section>

<?php else: ?>

<!-- CONTENIDO GENÉRICO -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
                        <h2 class="entry-title"><?php the_title(); ?></h2>
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Leer más</a>
                    </article>
                <?php endwhile; ?>
                
                <div class="pagination-wrapper mt-4">
                    <?php 
                    the_posts_pagination([
                        'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                        'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>'
                    ]); 
                    ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No se encontraron publicaciones.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php get_footer(); ?>