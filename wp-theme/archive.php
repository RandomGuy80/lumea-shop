<?php get_header(); ?>

<div class="container shop-layout">
    <aside class="shop-sidebar">
        <?php dynamic_sidebar('shop-sidebar'); ?>
    </aside>

    <div class="shop-main">
        <div class="shop-header">
            <h1 class="shop-header__title">
                <?php woocommerce_page_title(); ?>
            </h1>
            <div class="shop-header__sort">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

        <?php if (have_posts()): ?>
            <div class="products__grid" id="products-grid">
                <?php while (have_posts()): the_post();
                    get_template_part('template-parts/product', 'card');
                endwhile; ?>
            </div>
            <div class="shop-pagination">
                <?php woocommerce_pagination(); ?>
            </div>
        <?php else: ?>
            <p class="shop-empty">Товары не найдены.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
