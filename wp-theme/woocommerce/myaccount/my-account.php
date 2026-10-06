<?php defined('ABSPATH') || exit; ?>

<?php get_header(); ?>

<div class="container account-page">
    <?php if (is_user_logged_in()): ?>
        <div class="account-layout">
            <aside class="account-sidebar">
                <nav class="account-nav">
                    <?php foreach (wc_get_account_menu_items() as $endpoint => $label): ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"
                           class="account-nav__item <?php echo wc_is_account_page() && isset($_GET['action']) && $_GET['action'] === $endpoint ? 'is-active' : (wc_get_account_menu_item_classes($endpoint) ? 'is-active' : ''); ?>">
                            <?php echo esc_html($label); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </aside>

            <div class="account-content">
                <?php woocommerce_account_content(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="account-auth">
            <div class="account-auth__login">
                <h2 class="checkout-section__title">Войти</h2>
                <?php woocommerce_login_form(['redirect' => wc_get_page_permalink('myaccount')]); ?>
            </div>
            <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes'): ?>
            <div class="account-auth__register">
                <h2 class="checkout-section__title">Зарегистрироваться</h2>
                <?php woocommerce_register_form(); ?>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
