<?php
global $product;
$product = wc_get_product(get_the_ID());
if (!$product) return;
?>
<div class="product-card">
    <a href="<?php the_permalink(); ?>" class="product-card__img-wrap">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('woocommerce_thumbnail', ['class' => 'product-card__img']); ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg"
                 alt="<?php the_title_attribute(); ?>" class="product-card__img">
        <?php endif; ?>
        <?php if ($product->is_on_sale()): ?>
            <span class="product-card__badge">Sale</span>
        <?php endif; ?>
    </a>
    <div class="product-card__info">
        <h3 class="product-card__name">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="product-card__price">
            <?php echo $product->get_price_html(); ?>
        </div>
        <button class="btn btn--add-to-cart"
                data-product-id="<?php echo get_the_ID(); ?>"
                data-nonce="<?php echo wp_create_nonce('add-to-cart'); ?>">
            В корзину
        </button>
    </div>
</div>
