</main>

<footer class="footer">
    <div class="container footer__inner">
        <div class="footer__brand">
            <a href="<?php echo home_url('/'); ?>" class="footer__logo">
                <?php bloginfo('name'); ?>
            </a>
            <p class="footer__tagline">Красота в каждой детали</p>
        </div>

        <nav class="footer__nav">
            <?php wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer__list',
                'fallback_cb'    => false,
            ]); ?>
        </nav>

        <div class="footer__copy">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Все права защищены.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
