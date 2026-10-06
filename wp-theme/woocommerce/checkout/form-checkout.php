<?php defined('ABSPATH') || exit; ?>

<?php get_header(); ?>

<div class="container checkout-page">
    <h1 class="page-content__title">Оформление заказа</h1>

    <?php wc_print_notices(); ?>

    <form name="checkout" class="checkout-form" method="post" action="<?php echo esc_url(wc_get_checkout_url()); ?>">
        <div class="checkout-layout">
            <div class="checkout-fields">
                <h2 class="checkout-section__title">Данные покупателя</h2>

                <?php foreach (WC()->checkout->get_checkout_fields('billing') as $key => $field): ?>
                    <?php woocommerce_form_field($key, $field, WC()->checkout->get_value($key)); ?>
                <?php endforeach; ?>

                <h2 class="checkout-section__title" style="margin-top:32px">Примечание к заказу</h2>
                <?php woocommerce_form_field('order_comments', [
                    'type'        => 'textarea',
                    'class'       => ['notes'],
                    'label'       => false,
                    'placeholder' => 'Комментарий к заказу (необязательно)',
                ], WC()->checkout->get_value('order_comments')); ?>
            </div>

            <div class="checkout-summary">
                <h2 class="checkout-section__title">Ваш заказ</h2>
                <div class="checkout-order">
                    <?php foreach (WC()->cart->get_cart() as $item):
                        $prod = $item['data'];
                    ?>
                    <div class="checkout-order__row">
                        <span><?php echo esc_html($prod->get_name()); ?> × <?php echo $item['quantity']; ?></span>
                        <span><?php echo WC()->cart->get_product_subtotal($prod, $item['quantity']); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="checkout-order__row checkout-order__row--total">
                        <span>Итого</span>
                        <span><?php wc_cart_totals_order_total_html(); ?></span>
                    </div>
                </div>

                <div id="payment">
                    <?php woocommerce_checkout_payment(); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<?php get_footer(); ?>
