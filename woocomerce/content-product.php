<?php
/**
 * The template for displaying product content within loops
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>
    
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     */
    do_action('woocommerce_before_shop_loop_item');
    ?>
    
    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
        
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         * @hooked pedraja_product_new_badge - 10 (nuestro custom)
         * @hooked pedraja_sale_badge - 10 (nuestro custom)
         * @hooked pedraja_quick_view_icon - 15 (nuestro custom)
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>
        
        <?php
        /**
         * Hook: woocommerce_shop_loop_item_title.
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');
        ?>
        
        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>
        
    </a>
    
    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>
    
</li>