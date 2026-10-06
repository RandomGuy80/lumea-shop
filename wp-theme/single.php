<?php get_header(); ?>

<div class="container">
    <?php while (have_posts()): the_post(); ?>
        <?php wc_get_template_part('content', 'single-product'); ?>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
