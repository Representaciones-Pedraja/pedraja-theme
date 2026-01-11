<?php
/**
 * Template para página 404 - No encontrada
 */
get_header(); ?>

<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-6">
            
            <div class="error-404-content">
                <h1 class="display-1 fw-bold text-primary mb-4">404</h1>
                <h2 class="h3 mb-3">Página no encontrada</h2>
                <p class="lead text-muted mb-4">
                    Lo sentimos, la página que buscas no existe o ha sido movida.
                </p>
                
                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <a href="<?php echo home_url(); ?>" class="btn-theme btn-lg px-4">
                        <i class="fas fa-home me-2"></i> Ir al inicio
                    </a>
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-outline-theme btn-lg px-4">
                        <i class="fas fa-shopping-bag me-2"></i> Ver tienda
                    </a>
                </div>
                
                <!-- Búsqueda -->
                <div class="mt-5">
                    <h5 class="mb-3">¿Buscas algo específico?</h5>
                    <form method="get" action="<?php echo home_url('/'); ?>">
                        <div class="input-group mx-auto" style="max-width: 500px;">
                            <input type="search" class="form-control form-control-lg" name="s" placeholder="Buscar productos...">
                            <input type="hidden" name="post_type" value="product">
                            <button class="btn-theme btn-lg" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Enlaces útiles -->
                <div class="mt-5">
                    <h5 class="mb-3">Enlaces útiles:</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="text-decoration-none">Tienda</a></li>
                        <li><a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="text-decoration-none">Mi cuenta</a></li>
                        <li><a href="<?php echo get_permalink(get_page_by_path('contacto')); ?>" class="text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<?php get_footer(); ?>