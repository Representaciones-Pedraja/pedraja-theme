<?php
/**
 * Template para archivos de categorías, etiquetas, etc.
 */
get_header(); ?>

<div class="container py-5">
    
    <!-- Título del archivo -->
    <header class="page-header mb-4">
        <h1 class="h2"><?php the_archive_title(); ?></h1>
        <?php if (get_the_archive_description()): ?>
            <div class="archive-description text-muted">
                <?php the_archive_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="row">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <article class="card h-100 shadow-sm">
                        <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['class' => 'card-img-top']); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="h5 card-title">
                                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="card-text text-muted small">
                                <i class="far fa-calendar"></i> <?php echo get_the_date(); ?>
                            </p>
                            <div class="card-text">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-theme btn-sm mt-2">
                                Leer más <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
            
            <!-- Paginación -->
            <div class="col-12 mt-4">
                <?php
                the_posts_pagination([
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Anterior',
                    'next_text' => 'Siguiente <i class="fas fa-chevron-right"></i>',
                    'class' => 'pagination justify-content-center'
                ]);
                ?>
            </div>
            
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">No se encontraron publicaciones.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>