<?php get_header(); ?>

<?php while (have_posts()): the_post(); ?>
<?php
global $product;
$product = wc_get_product(get_the_ID());
$gallery_ids = $product->get_gallery_image_ids();
?>

<div class="container product-single">
    <nav class="breadcrumb">
        <a href="<?php echo home_url('/'); ?>">Главная</a>
        <span>/</span>
        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Каталог</a>
        <span>/</span>
        <span><?php the_title(); ?></span>
    </nav>

    <div class="product-single__inner">
        <div class="product-single__gallery">
            <div class="product-single__main-img">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('woocommerce_single', ['class' => 'product-single__img', 'id' => 'main-product-img']); ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(wc_placeholder_img_src('woocommerce_single')); ?>"
                         class="product-single__img" id="main-product-img" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
                <?php if ($product->is_on_sale()): ?>
                    <span class="product-card__badge">Sale</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($gallery_ids)): ?>
            <div class="product-single__thumbs">
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail'); ?>"
                         class="product-single__thumb is-active" data-full="<?php echo get_the_post_thumbnail_url(null, 'woocommerce_single'); ?>"
                         alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
                <?php foreach ($gallery_ids as $img_id):
                    $thumb = wp_get_attachment_image_url($img_id, 'thumbnail');
                    $full  = wp_get_attachment_image_url($img_id, 'woocommerce_single');
                ?>
                    <img src="<?php echo esc_url($thumb); ?>" class="product-single__thumb"
                         data-full="<?php echo esc_url($full); ?>"
                         alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true)); ?>">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="product-single__info">
            <h1 class="product-single__title"><?php the_title(); ?></h1>

            <?php if ($product->get_short_description()): ?>
                <div class="product-single__short-desc">
                    <?php echo wpautop($product->get_short_description()); ?>
                </div>
            <?php endif; ?>

            <div class="product-single__price">
                <?php echo $product->get_price_html(); ?>
            </div>

            <?php if ($product->is_in_stock()): ?>
                <p class="product-single__stock in-stock">В наличии</p>
            <?php else: ?>
                <p class="product-single__stock out-of-stock">Нет в наличии</p>
            <?php endif; ?>

            <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
            <div class="product-single__add-to-cart">
                <div class="qty-control">
                    <button class="qty-btn" data-action="minus">−</button>
                    <input type="number" class="qty-input" value="1" min="1" max="<?php echo $product->get_max_purchase_quantity(); ?>" id="product-qty">
                    <button class="qty-btn" data-action="plus">+</button>
                </div>
                <button class="btn btn--primary btn--cart-single"
                        data-product-id="<?php echo get_the_ID(); ?>"
                        data-nonce="<?php echo wp_create_nonce('add-to-cart'); ?>">
                    Добавить в корзину
                </button>
            </div>
            <?php endif; ?>

            <?php if ($product->get_description()): ?>
            <div class="product-single__accordion">
                <button class="accordion__toggle is-open">Описание</button>
                <div class="accordion__body">
                    <?php echo wpautop($product->get_description()); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $related = wc_get_related_products(get_the_ID(), 4);
    if (!empty($related)):
    ?>
    <section class="product-related">
        <h2 class="section__title">Похожие товары</h2>
        <div class="products__grid">
            <?php foreach ($related as $rel_id):
                $post = get_post($rel_id);
                setup_postdata($post);
                global $product;
                $product = wc_get_product($rel_id);
                get_template_part('template-parts/product', 'card');
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
