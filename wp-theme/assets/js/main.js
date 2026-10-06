(function ($) {
    'use strict';

    // Mobile burger menu
    const burger = document.querySelector('.header__burger');
    const nav = document.querySelector('.header__nav');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            nav.classList.toggle('header__nav--open');
            burger.classList.toggle('header__burger--active');
        });
    }

    // Add to cart via AJAX
    $(document).on('click', '.btn--add-to-cart', function () {
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const nonce = $btn.data('nonce');

        $btn.text('Добавляем...').prop('disabled', true);

        $.ajax({
            url: lumea_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: productId,
                quantity: 1,
                nonce: nonce,
            },
            success: function (response) {
                if (response.error) {
                    $btn.text('В корзину').prop('disabled', false);
                    return;
                }
                $btn.text('Добавлено!');
                $(document.body).trigger('wc_fragment_refresh');
                setTimeout(() => {
                    $btn.text('В корзину').prop('disabled', false);
                }, 2000);
            },
            error: function () {
                $btn.text('В корзину').prop('disabled', false);
            },
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})(jQuery);
