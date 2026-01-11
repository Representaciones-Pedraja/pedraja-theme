jQuery(document).ready(function($) {
    
    // ===== SLIDER HERO =====
    if ($(".hero-swiper").length) {
        new Swiper(".hero-swiper", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            effect: "fade",
            fadeEffect: {
                crossFade: true
            }
        });
    }

    // ===== MODO DÍA/NOCHE =====
    $("#theme-toggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("dark-mode");
        localStorage.setItem("theme", $("body").hasClass("dark-mode") ? "dark" : "light");
    });

    if (localStorage.getItem("theme") === "dark") {
        $("body").addClass("dark-mode");
    }

    // ===== CARRITO HOVER =====
    $(".cart-trigger").on("mouseenter", function() {
        $(this).next(".cart-dropdown-content").stop(true, true).fadeIn(200);
    });

    $(".cart-dropdown").on("mouseleave", function() {
        $(".cart-dropdown-content").stop(true, true).fadeOut(200);
    });

    // ===== QUICK VIEW =====
    var quickViewModal = null;
    
    $(document).on("click", ".quick-view-icon, .quick-view-btn", function(e) {
        e.preventDefault();
        
        var productId = $(this).data("product-id") || $(this).closest(".product").find(".button").data("product_id");
        
        if (!productId) return;
        
        // Crear modal si no existe
        if (!$("#quickViewModal").length) {
            $("body").append(`
                <div class="modal fade" id="quickViewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="quickViewContent">
                                <div class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        
        // Mostrar modal
        quickViewModal = new bootstrap.Modal(document.getElementById("quickViewModal"));
        quickViewModal.show();
        
        // Cargar contenido via AJAX
        $.ajax({
            url: pedrajaData.ajaxUrl,
            type: "POST",
            data: {
                action: "pedraja_quick_view",
                product_id: productId,
                nonce: pedrajaData.nonce
            },
            success: function(response) {
                if (response.success) {
                    $("#quickViewContent").html(response.data.html);
                } else {
                    $("#quickViewContent").html("<p class='text-danger text-center'>Error al cargar el producto</p>");
                }
            },
            error: function() {
                $("#quickViewContent").html("<p class='text-danger text-center'>Error de conexión</p>");
            }
        });
    });

    // ===== AJAX ADD TO CART =====
    $(document).on("click", ".add-to-cart-ajax", function(e) {
        e.preventDefault();
        
        var $btn = $(this);
        var productId = $btn.data("product-id");
        var quantity = $btn.closest("form").find("input[name='quantity']").val() || 1;
        
        $btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Añadiendo...');
        
        $.ajax({
            url: pedrajaData.ajaxUrl,
            type: "POST",
            data: {
                action: "pedraja_add_to_cart",
                product_id: productId,
                quantity: quantity,
                nonce: pedrajaData.nonce
            },
            success: function(response) {
                if (response.success) {
                    $btn.html('<i class="fas fa-check"></i> ¡Añadido!').removeClass("btn-primary").addClass("btn-success");
                    
                    // Actualizar contador del carrito
                    $(".cart-count").text(response.data.cart_count);
                    
                    // Cerrar modal si existe
                    if (quickViewModal) {
                        setTimeout(function() {
                            quickViewModal.hide();
                        }, 1000);
                    }
                    
                    // Resetear botón
                    setTimeout(function() {
                        $btn.prop("disabled", false)
                            .html('<i class="fas fa-shopping-cart"></i> Añadir al carrito')
                            .removeClass("btn-success")
                            .addClass("btn-primary");
                    }, 2000);
                } else {
                    $btn.prop("disabled", false).html("Error");
                }
            },
            error: function() {
                $btn.prop("disabled", false).html("Error de conexión");
            }
        });
    });

    // ===== BÚSQUEDA CON SUGERENCIAS =====
    var searchTimeout;
    var $searchInput = $(".search-form input[type='search']");
    var $searchSuggestions = $("<div>", {
        class: "search-suggestions position-absolute bg-white border rounded shadow-lg",
        css: {
            width: "100%",
            top: "100%",
            left: 0,
            "z-index": 1000,
            "max-height": "400px",
            "overflow-y": "auto",
            display: "none"
        }
    });
    
    $searchInput.parent().append($searchSuggestions);
    
    $searchInput.on("keyup", function() {
        var query = $(this).val();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 3) {
            $searchSuggestions.hide();
            return;
        }
        
        searchTimeout = setTimeout(function() {
            $.ajax({
                url: pedrajaData.ajaxUrl,
                type: "POST",
                data: {
                    action: "pedraja_search",
                    search: query,
                    nonce: pedrajaData.nonce
                },
                success: function(response) {
                    if (response.success && response.data.products.length > 0) {
                        var html = "<div class='p-3'>";
                        
                        response.data.products.forEach(function(product) {
                            html += `
                                <a href="${product.url}" class="d-flex align-items-center text-decoration-none text-dark p-2 hover-bg-light">
                                    <img src="${product.image}" alt="${product.title}" style="width:50px;height:50px;object-fit:contain" class="me-3">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">${product.title}</div>
                                        <div class="text-primary small">${product.price}</div>
                                    </div>
                                </a>
                            `;
                        });
                        
                        html += "</div>";
                        
                        $searchSuggestions.html(html).show();
                    } else {
                        $searchSuggestions.hide();
                    }
                }
            });
        }, 300);
    });
    
    // Cerrar sugerencias al hacer clic fuera
    $(document).on("click", function(e) {
        if (!$(e.target).closest(".search-form").length) {
            $searchSuggestions.hide();
        }
    });

    // ===== LOAD MORE PRODUCTS =====
    var currentPage = 1;
    var isLoading = false;
    
    $(document).on("click", ".load-more-products", function(e) {
        e.preventDefault();
        
        if (isLoading) return;
        
        isLoading = true;
        var $btn = $(this);
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Cargando...');
        
        currentPage++;
        
        $.ajax({
            url: pedrajaData.ajaxUrl,
            type: "POST",
            data: {
                action: "pedraja_load_more",
                paged: currentPage,
                nonce: pedrajaData.nonce
            },
            success: function(response) {
                if (response.success) {
                    $(".products").append(response.data.html);
                    
                    if (currentPage >= response.data.max_pages) {
                        $btn.remove();
                    } else {
                        $btn.html("Cargar más productos");
                    }
                }
                
                isLoading = false;
            },
            error: function() {
                $btn.html("Error - Reintentar");
                isLoading = false;
            }
        });
    });

    // ===== FOOTER ACCORDION (MÓVIL) =====
    if ($(window).width() < 768) {
        $(".footer-section h4 span[data-bs-toggle]").on("click", function() {
            var target = $(this).attr("data-bs-target");
            $(target).collapse("toggle");
        });
    }

    // ===== SMOOTH SCROLL =====
    $('a[href^="#"]').on("click", function(e) {
        var target = $(this.getAttribute("href"));
        if (target.length) {
            e.preventDefault();
            $("html, body").stop().animate({
                scrollTop: target.offset().top - 100
            }, 600);
        }
    });

    // ===== CERRAR OFFCANVAS AL CLICK EN ENLACE =====
    $(".offcanvas-body a").on("click", function() {
        var offcanvas = bootstrap.Offcanvas.getInstance($("#mobileMenu"));
        if (offcanvas) {
            offcanvas.hide();
        }
    });

    // ===== VALIDACIÓN NEWSLETTER =====
    $(".newsletter-form").on("submit", function(e) {
        var email = $(this).find("input[type=email]").val();
        if (!email || email.length === 0) {
            e.preventDefault();
            alert("Por favor, introduce tu email");
            return false;
        }
    });

    // ===== NÚMEROS EN INPUTS DE CANTIDAD =====
    $(document).on("change", "input[type='number']", function() {
        var min = parseInt($(this).attr("min")) || 1;
        var max = parseInt($(this).attr("max")) || 9999;
        var val = parseInt($(this).val()) || min;
        
        if (val < min) $(this).val(min);
        if (val > max) $(this).val(max);
    });

});