<?php get_header(); ?>

<div class="container shop-layout">
    <aside class="shop-sidebar">
        <div class="widget">
            <h3 class="widget__title">Категории</h3>
            <ul class="filter-cats">
                <li>
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"
                       class="filter-cats__item <?php echo !isset($_GET['cat']) ? 'is-active' : ''; ?>">
                        Все товары
                    </a>
                </li>
                <?php
                $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'exclude' => [get_option('default_product_cat')]]);
                foreach ($cats as $cat):
                    $active = (isset($_GET['cat']) && $_GET['cat'] == $cat->slug) ? 'is-active' : '';
                ?>
                <li>
                    <a href="?cat=<?php echo esc_attr($cat->slug); ?>"
                       class="filter-cats__item <?php echo $active; ?>">
                        <?php echo esc_html($cat->name); ?>
                        <span class="filter-cats__count"><?php echo $cat->count; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="widget">
            <h3 class="widget__title">Цена</h3>
            <div class="filter-price">
                <div class="filter-price__inputs">
                    <input type="number" id="price-min" class="filter-price__input" placeholder="От"
                           value="<?php echo isset($_GET['min_price']) ? intval($_GET['min_price']) : ''; ?>">
                    <span class="filter-price__sep">—</span>
                    <input type="number" id="price-max" class="filter-price__input" placeholder="До"
                           value="<?php echo isset($_GET['max_price']) ? intval($_GET['max_price']) : ''; ?>">
                </div>
                <button class="btn btn--outline filter-price__btn" id="apply-price">Применить</button>
            </div>
        </div>

        <?php dynamic_sidebar('shop-sidebar'); ?>
    </aside>

    <div class="shop-main">
        <div class="shop-header">
            <h1 class="shop-header__title">
                <?php woocommerce_page_title(); ?>
                <span class="shop-header__count">
                    (<?php echo wc_get_loop_prop('total') ?: $wp_query->found_posts; ?> товаров)
                </span>
            </h1>
            <div class="shop-header__sort">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

        <div class="products__grid" id="products-grid">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post();
                    global $product;
                    $product = wc_get_product(get_the_ID());
                    get_template_part('template-parts/product', 'card');
                endwhile; ?>
            <?php else: ?>
                <p class="shop-empty">Товары не найдены. Попробуйте изменить фильтры.</p>
            <?php endif; ?>
        </div>

        <div class="shop-pagination">
            <?php woocommerce_pagination(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
