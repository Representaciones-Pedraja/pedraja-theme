<?php
/**
 * Widgets Personalizados - Pedraja Theme
 */

if (!defined('ABSPATH')) exit;

// =============================
// WIDGET: FILTRO POR PRECIO
// =============================
class Pedraja_Price_Filter_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'pedraja_price_filter',
            __('Pedraja: Filtro de Precio', 'pedraja'),
            ['description' => __('Filtrar productos por rango de precio', 'pedraja')]
        );
    }
    
    public function widget($args, $instance) {
        if (!class_exists('WooCommerce')) return;
        
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
        }
        
        global $wp;
        $current_url = home_url($wp->request);
        $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
        $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000;
        
        ?>
        <form method="get" action="<?php echo esc_url($current_url); ?>" class="price-filter-form">
            
            <?php
            // Mantener otros parámetros de URL
            foreach ($_GET as $key => $value) {
                if ($key !== 'min_price' && $key !== 'max_price') {
                    echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
                }
            }
            ?>
            
            <div class="price-filter-inputs mb-3">
                <div class="row g-2">
                    <div class="col-6">
                        <input type="number" 
                               name="min_price" 
                               class="form-control form-control-sm" 
                               placeholder="Min €" 
                               value="<?php echo esc_attr($min_price); ?>" 
                               min="0" 
                               step="0.01">
                    </div>
                    <div class="col-6">
                        <input type="number" 
                               name="max_price" 
                               class="form-control form-control-sm" 
                               placeholder="Max €" 
                               value="<?php echo esc_attr($max_price); ?>" 
                               min="0" 
                               step="0.01">
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-filter me-1"></i> Filtrar
            </button>
            
            <?php if ($min_price > 0 || $max_price < 10000): ?>
            <a href="<?php echo esc_url($current_url); ?>" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                <i class="fas fa-times me-1"></i> Limpiar
            </a>
            <?php endif; ?>
            
        </form>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Filtrar por precio', 'pedraja');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Título:', 'pedraja'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// =============================
// WIDGET: PRODUCTOS DESTACADOS
// =============================
class Pedraja_Featured_Products_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'pedraja_featured_products',
            __('Pedraja: Productos Destacados', 'pedraja'),
            ['description' => __('Muestra productos destacados', 'pedraja')]
        );
    }
    
    public function widget($args, $instance) {
        if (!class_exists('WooCommerce')) return;
        
        $title = !empty($instance['title']) ? $instance['title'] : __('Productos Destacados', 'pedraja');
        $limit = !empty($instance['limit']) ? intval($instance['limit']) : 4;
        
        $query_args = [
            'post_type' => 'product',
            'posts_per_page' => $limit,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_featured',
                    'value' => 'yes'
                ]
            ]
        ];
        
        $products = new WP_Query($query_args);
        
        if (!$products->have_posts()) return;
        
        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        echo '<ul class="featured-products-list list-unstyled">';
        
        while ($products->have_posts()): $products->the_post();
            global $product;
            ?>
            <li class="featured-product-item d-flex gap-2 mb-3 pb-3 border-bottom">
                <div class="product-thumb" style="min-width: 60px;">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php echo $product->get_image('thumbnail'); ?>
                    </a>
                </div>
                <div class="product-info">
                    <h4 class="product-title mb-1" style="font-size: 13px;">
                        <a href="<?php echo get_permalink(); ?>" class="text-dark text-decoration-none">
                            <?php the_title(); ?>
                        </a>
                    </h4>
                    <div class="product-price small fw-bold text-primary">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                </div>
            </li>
            <?php
        endwhile;
        
        echo '</ul>';
        
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Productos Destacados', 'pedraja');
        $limit = !empty($instance['limit']) ? $instance['limit'] : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Título:', 'pedraja'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>">
                <?php _e('Número de productos:', 'pedraja'); ?>
            </label>
            <input class="tiny-text" 
                   id="<?php echo esc_attr($this->get_field_id('limit')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('limit')); ?>" 
                   type="number" 
                   value="<?php echo esc_attr($limit); ?>" 
                   min="1" 
                   max="10">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 4;
        return $instance;
    }
}

// =============================
// WIDGET: CATEGORÍAS CON CONTADOR
// =============================
class Pedraja_Category_List_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'pedraja_category_list',
            __('Pedraja: Lista de Categorías', 'pedraja'),
            ['description' => __('Lista de categorías de productos con contador', 'pedraja')]
        );
    }
    
    public function widget($args, $instance) {
        if (!class_exists('WooCommerce')) return;
        
        $title = !empty($instance['title']) ? $instance['title'] : __('Categorías', 'pedraja');
        $show_count = !empty($instance['show_count']) ? true : false;
        
        $categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0
        ]);
        
        if (empty($categories) || is_wp_error($categories)) return;
        
        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        echo '<ul class="product-categories list-unstyled">';
        
        foreach ($categories as $category) {
            $current_class = (is_tax('product_cat', $category->term_id)) ? ' active' : '';
            ?>
            <li class="cat-item mb-2">
                <a href="<?php echo get_term_link($category); ?>" 
                   class="d-flex justify-content-between align-items-center text-decoration-none text-dark p-2 rounded<?php echo $current_class; ?>">
                    <span><?php echo esc_html($category->name); ?></span>
                    <?php if ($show_count): ?>
                        <span class="badge bg-secondary"><?php echo $category->count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php
        }
        
        echo '</ul>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Categorías', 'pedraja');
        $show_count = !empty($instance['show_count']) ? true : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Título:', 'pedraja'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" 
                   type="checkbox" 
                   <?php checked($show_count, true); ?> 
                   id="<?php echo esc_attr($this->get_field_id('show_count')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('show_count')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_count')); ?>">
                <?php _e('Mostrar contador de productos', 'pedraja'); ?>
            </label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_count'] = (!empty($new_instance['show_count'])) ? 1 : 0;
        return $instance;
    }
}

// =============================
// REGISTRAR WIDGETS
// =============================
function pedraja_register_widgets() {
    register_widget('Pedraja_Price_Filter_Widget');
    register_widget('Pedraja_Featured_Products_Widget');
    register_widget('Pedraja_Category_List_Widget');
}
add_action('widgets_init', 'pedraja_register_widgets');
?>