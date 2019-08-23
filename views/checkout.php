
<header class="page-header header">
    <a class="header__basket basket" href="<?= $base_url ?>order/">
        <span class="header__basket-count basket-count <?php if ($order['total_count'] == 0): ?>basket-count--none<?php endif ?>"><?= $order['total_count'] ?></span>
    </a>
    <div class="page-header__wrapper header__wrapper">
        <a href="<?= $base_url ?>" class="page-header__link"><span class="visually-hidden">Главная страница CloudPayments</span></a>
        <h1 class="page-header__title header__title">Интернет-магазин</h1>
        <p class="header__text">Мы сделали для вас пример интернет-магазина. Здесь можно посмотреть, как ваши покупатели будут видеть платежи через CloudPayments. Добавьте в корзину товар, который хотите купить. Деньги не спишутся — все товары, как и платежи, не настоящие.</p>
        <!-- <p class="header__text">Посмотрите, как выглядят платежи через CloudPayments для покупателей. Выберите товары, которые нужно приобрести. Товары не&nbsp;настоящие, платежи тоже&nbsp;&mdash; деньги тратить не&nbsp;придется.</p>-->
    </div>
</header>

<main class="page-goods page-goods--checkout">
    <h2 class="visually-hidden">Окно товаров</h2>
    <ul class="page-goods__list page-goods__list--checkout">
        <?php foreach ($products as $product):?>
            <?php $in_cart = isset($order['items'][$product['id']]) ? $order['items'][$product['id']]['count'] : 0 ?>
            <li class="goods">
                <div class="goods__image-wrapper goods__image-wrapper--checkout">
                    <img class="goods__image" src="<?= $assets_url . $product['image']?>" srcset="<?= $assets_url . $product['image2x']?> 2x" alt="подушка">
                </div>
                <div class="goods__content">
                    <div class="goods__text-wrapper">
                        <h3 class="goods__text"><?= $product['name'] ?></h3>
                        <p class="goods__text-price"><?= $product['price'] ?> р.</p>
                    </div>
                    <button type="button"
                            class="button button--goods addBtn <?php if ($in_cart): ?>button--basket<?php endif ?>"
                            value="<?= $in_cart ?>" data-product-id="<?= $product['id'] ?>"><?php if ($in_cart): ?>Удалить<?php else: ?>Купить<?php endif ?>
                    </button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</main>

<section class="popup-one popup">
    <div class="popup-one__wrapper">
        <h3 class="popup-one__title">Товар добавлен в корзину</h3>
        <button class="popup-one__close-btn close-button" type="button" name="button"><span class="visually-hidden">Закрыть попап</span></button>
        <ul class="popup-one__list">
        </ul>
        <div class="popup-one__btn-wrapper">
            <button class="button button-popup button-popup--continue popup-one__button" type="button">Продолжить покупки</button>
            <a class="button button-popup button-popup--link" href="<?= $base_url ?>order/">Оформить заказ</a>
        </div>
    </div>
</section>

<div class="overlay overlay--invis"></div>

<?php $this->addJs($assets_url . 'js/basket.js') ?>
<?php $this->addJs($assets_url . 'js/checkout-basket.js') ?>
