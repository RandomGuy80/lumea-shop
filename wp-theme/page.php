<?php get_header(); ?>

<div class="container page-content">
    <?php while (have_posts()): the_post(); ?>
        <h1 class="page-content__title"><?php the_title(); ?></h1>
        <div class="page-content__body">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
