<?php defined('ABSPATH') || exit; ?>

<?php get_header(); ?>

<div class="container cart-page">
    <h1 class="page-content__title">Корзина</h1>

    <?php wc_print_notices(); ?>

    <form class="cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php if (WC()->cart->is_empty()): ?>
            <div class="cart-empty">
                <p>Ваша корзина пуста.</p>
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--primary">Перейти в каталог</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div class="cart-items">
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                        $product = $cart_item['data'];
                        $product_id = $cart_item['product_id'];
                        $qty = $cart_item['quantity'];
                    ?>
                    <div class="cart-item">
                        <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="cart-item__img">
                            <?php echo $product->get_image('thumbnail', ['class' => 'cart-item__photo']); ?>
                        </a>
                        <div class="cart-item__info">
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="cart-item__name">
                                <?php echo esc_html($product->get_name()); ?>
                            </a>
                            <div class="cart-item__price">
                                <?php echo WC()->cart->get_product_price($product); ?>
                            </div>
                        </div>
                        <div class="cart-item__qty">
                            <div class="qty-control">
                                <button type="button" class="qty-btn" data-action="minus">−</button>
                                <input type="number" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
                                       class="qty-input" value="<?php echo esc_attr($qty); ?>" min="1">
                                <button type="button" class="qty-btn" data-action="plus">+</button>
                            </div>
                        </div>
                        <div class="cart-item__subtotal">
                            <?php echo WC()->cart->get_product_subtotal($product, $qty); ?>
                        </div>
                        <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="cart-item__remove" aria-label="Удалить">×</a>
                    </div>
                    <?php endforeach; ?>

                    <div class="cart-actions">
                        <button type="submit" name="update_cart" class="btn btn--outline">Обновить корзину</button>
                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    </div>
                </div>

                <div class="cart-summary">
                    <h2 class="cart-summary__title">Итого</h2>
                    <div class="cart-summary__row">
                        <span>Подытог</span>
                        <span><?php wc_cart_totals_subtotal_html(); ?></span>
                    </div>
                    <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
                    <div class="cart-summary__row cart-summary__row--discount">
                        <span>Купон: <?php echo esc_html($code); ?></span>
                        <span>−<?php wc_cart_totals_coupon_html($coupon); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="cart-summary__row cart-summary__row--total">
                        <span>Итого</span>
                        <span><?php wc_cart_totals_order_total_html(); ?></span>
                    </div>
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn--primary cart-summary__checkout">
                        Оформить заказ
                    </a>
                    <div class="cart-summary__coupon">
                        <input type="text" name="coupon_code" class="cart-summary__coupon-input" placeholder="Промокод">
                        <button type="submit" name="apply_coupon" class="btn btn--outline">Применить</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php get_footer(); ?>
