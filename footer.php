</main>

<!-- FOOTER PRINCIPAL -->
<footer class="site-footer bg-dark text-white py-5 mt-5">
    <div class="container-fluid">
        
        <!-- COLUMNAS FOOTER -->
        <div class="row g-4 mb-4">
            
            <!-- Productos -->
            <div class="col-6 col-md-3">
                <div class="footer-section">
                    <h4 class="text-white text-uppercase mb-3 fw-bold">
                        <span class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#footerCol1" role="button">
                            Productos
                            <i class="fas fa-chevron-down d-md-none"></i>
                        </span>
                    </h4>
                    <div id="footerCol1" class="collapse show">
                        <?php if (is_active_sidebar("footer-1")): 
                            dynamic_sidebar("footer-1"); 
                        else: ?>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?orderby=date">Novedades</a></li>
                            <li class="mb-2"><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?on_sale=1">Ofertas</a></li>
                            <li class="mb-2"><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>?orderby=popularity">Los más vendidos</a></li>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Nuestra empresa -->
            <div class="col-6 col-md-3">
                <div class="footer-section">
                    <h4 class="text-white text-uppercase mb-3 fw-bold">
                        <span class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#footerCol2" role="button">
                            Nuestra empresa
                            <i class="fas fa-chevron-down d-md-none"></i>
                        </span>
                    </h4>
                    <div id="footerCol2" class="collapse show">
                        <?php if (is_active_sidebar("footer-2")): 
                            dynamic_sidebar("footer-2"); 
                        else: ?>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="<?php echo home_url('/contacto'); ?>">Contáctenos</a></li>
                            <li class="mb-2"><a href="<?php echo home_url('/sobre-nosotros'); ?>">Sobre Nosotros</a></li>
                            <li class="mb-2"><a href="<?php echo home_url('/terminos'); ?>">Términos y Condiciones</a></li>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Información de la tienda -->
            <div class="col-6 col-md-3">
                <div class="footer-section">
                    <h4 class="text-white text-uppercase mb-3 fw-bold">
                        <span class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#footerCol3" role="button">
                            Información de la tienda
                            <i class="fas fa-chevron-down d-md-none"></i>
                        </span>
                    </h4>
                    <div id="footerCol3" class="collapse show">
                        <?php if (is_active_sidebar("footer-3")): 
                            dynamic_sidebar("footer-3"); 
                        else: ?>
                        <div class="small">
                            <p class="mb-2"><strong class="text-white">Representaciones Pedraja</strong></p>
                            <p class="mb-1">Andalucía</p>
                            <p class="mb-3">España</p>
                            <p class="mb-0">
                                <i class="fas fa-phone me-2"></i>
                                <a href="tel:+34<?php echo get_theme_mod("pedraja_phone", "622138001"); ?>">
                                    Llamamos <?php echo get_theme_mod("pedraja_phone", "622138001"); ?>
                                </a>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Su cuenta -->
            <div class="col-6 col-md-3">
                <div class="footer-section">
                    <h4 class="text-white text-uppercase mb-3 fw-bold">
                        <span class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#footerCol4" role="button">
                            Su cuenta
                            <i class="fas fa-chevron-down d-md-none"></i>
                        </span>
                    </h4>
                    <div id="footerCol4" class="collapse show">
                        <?php if (is_active_sidebar("footer-4")): 
                            dynamic_sidebar("footer-4"); 
                        else: ?>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="<?php echo wc_get_page_permalink("myaccount"); ?>">Mi cuenta</a></li>
                            <li class="mb-2"><a href="<?php echo wc_get_account_endpoint_url("orders"); ?>">Mis pedidos</a></li>
                            <li class="mb-2"><a href="<?php echo wc_get_page_permalink("myaccount"); ?>">Información personal</a></li>
                        </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- COPYRIGHT -->
        <div class="row pt-4 border-top border-secondary">
            <div class="col-12 text-center">
                <p class="small mb-0" style="color: rgba(255,255,255,0.7)">
                    &copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?>. 
                    <?php echo esc_html(get_theme_mod("footer_copyright", "Todos los derechos reservados")); ?>
                </p>
            </div>
        </div>
        
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>