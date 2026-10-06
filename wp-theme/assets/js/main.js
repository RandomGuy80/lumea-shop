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

    // Single product gallery thumbnails
    document.querySelectorAll('.product-single__thumb').forEach(thumb => {
        thumb.addEventListener('click', function () {
            const mainImg = document.getElementById('main-product-img');
            if (mainImg) mainImg.src = this.dataset.full;
            document.querySelectorAll('.product-single__thumb').forEach(t => t.classList.remove('is-active'));
            this.classList.add('is-active');
        });
    });

    // Quantity control
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = this.closest('.qty-control').querySelector('.qty-input');
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 999;
            let val = parseInt(input.value) || 1;
            if (this.dataset.action === 'plus') val = Math.min(val + 1, max);
            if (this.dataset.action === 'minus') val = Math.max(val - 1, min);
            input.value = val;
        });
    });

    // Single product add to cart with quantity
    $(document).on('click', '.btn--cart-single', function () {
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const nonce = $btn.data('nonce');
        const qty = parseInt($('#product-qty').val()) || 1;

        $btn.text('Добавляем...').prop('disabled', true);

        $.ajax({
            url: lumea_ajax.ajax_url,
            type: 'POST',
            data: { action: 'woocommerce_ajax_add_to_cart', product_id: productId, quantity: qty, nonce: nonce },
            success: function (response) {
                if (!response.error) {
                    $btn.text('Добавлено!');
                    $(document.body).trigger('wc_fragment_refresh');
                    setTimeout(() => { $btn.text('Добавить в корзину').prop('disabled', false); }, 2000);
                } else {
                    $btn.text('Добавить в корзину').prop('disabled', false);
                }
            },
            error: function () { $btn.text('Добавить в корзину').prop('disabled', false); },
        });
    });

    // Accordion
    document.querySelectorAll('.accordion__toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            this.classList.toggle('is-open');
            const body = this.nextElementSibling;
            body.style.display = body.style.display === 'none' ? 'block' : 'none';
        });
    });

    // Price filter
    const applyPriceBtn = document.getElementById('apply-price');
    if (applyPriceBtn) {
        applyPriceBtn.addEventListener('click', function () {
            const min = document.getElementById('price-min').value;
            const max = document.getElementById('price-max').value;
            const url = new URL(window.location.href);
            if (min) url.searchParams.set('min_price', min);
            else url.searchParams.delete('min_price');
            if (max) url.searchParams.set('max_price', max);
            else url.searchParams.delete('max_price');
            window.location.href = url.toString();
        });
    }

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
