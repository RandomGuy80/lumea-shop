<?php get_header(); ?>

<section class="hero">
    <div class="container hero__inner">
        <div class="hero__content">
            <span class="hero__label">Новая коллекция 2026</span>
            <h1 class="hero__title">Открой свою&nbsp;<br>красоту</h1>
            <p class="hero__text">Натуральная косметика для сияющей кожи. Только лучшие ингредиенты.</p>
            <div style="display:flex;gap:16px;flex-wrap:wrap">
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--primary">
                    Смотреть каталог
                </a>
                <a href="#featured" class="btn btn--outline">Хиты продаж</a>
            </div>
        </div>
        <div class="hero__visual">
            <div class="hero__circle">
                <div class="hero__circle-text">Lumea<br>Beauty</div>
            </div>
            <div class="hero__badge hero__badge--1">🌿 Натуральный состав</div>
            <div class="hero__badge hero__badge--2">✨ Топ продаж</div>
        </div>
    </div>
</section>

<section class="categories">
    <div class="container">
        <h2 class="section__title">Категории</h2>
        <div class="categories__grid">
            <?php
            $categories = get_terms([
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 4,
                'exclude'    => [get_option('default_product_cat')],
            ]);
            foreach ($categories as $cat):
                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $image = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src('woocommerce_thumbnail');
            ?>
                <a href="<?php echo get_term_link($cat); ?>" class="category-card">
                    <div class="category-card__img">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                    </div>
                    <h3 class="category-card__name"><?php echo esc_html($cat->name); ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="promo-banner">
    <div class="container">
        <div class="promo-banner__grid">
            <div class="promo-banner__item promo-banner__item--large">
                <div class="promo-banner__content">
                    <span class="promo-banner__label">Скидка до 30%</span>
                    <h3 class="promo-banner__title">Уход за кожей лица</h3>
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--primary">Купить сейчас</a>
                </div>
            </div>
            <div class="promo-banner__item promo-banner__item--sm promo-banner__item--rose">
                <div class="promo-banner__content">
                    <span class="promo-banner__label">Новинка</span>
                    <h3 class="promo-banner__title">Сыворотки и масла</h3>
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--outline" style="border-color:white;color:white">Смотреть</a>
                </div>
            </div>
            <div class="promo-banner__item promo-banner__item--sm promo-banner__item--dark">
                <div class="promo-banner__content">
                    <span class="promo-banner__label">Бестселлер</span>
                    <h3 class="promo-banner__title">Декоративная косметика</h3>
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--outline" style="border-color:white;color:white">Смотреть</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured" id="featured">
    <div class="container">
        <h2 class="section__title">Хиты продаж</h2>
        <div class="products__grid">
            <?php
            $args = [
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'meta_key'       => 'total_sales',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ];
            $products = new WP_Query($args);
            while ($products->have_posts()):
                $products->the_post();
                global $product;
                $product = wc_get_product(get_the_ID());
                get_template_part('template-parts/product', 'card');
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
