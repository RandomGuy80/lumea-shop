<?php get_header(); ?>

<section class="hero">
    <div class="container hero__inner">
        <div class="hero__content">
            <span class="hero__label">Новая коллекция</span>
            <h1 class="hero__title">Открой свою&nbsp;<br>красоту</h1>
            <p class="hero__text">Натуральная косметика для сияющей кожи</p>
            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn--primary">
                Смотреть каталог
            </a>
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

<section class="featured">
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
