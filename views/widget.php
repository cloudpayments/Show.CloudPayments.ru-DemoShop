<header class="page-header header">
    <a class="header__basket header__basket--widget basket" href="#">
        <span class="header__basket-count basket-count <?php if ($order['total_count'] == 0): ?>basket-count--none<?php endif ?>"><?= $order['total_count'] ?></span>
    </a>

    <div class="page-header__wrapper header__wrapper">
        <a href="<?= $base_url ?>" class="page-header__link"></a>
        <h1 class="page-header__title">Интернет-магазин</h1>
        <p class="header__text">Мы сделали для вас пример интернет-магазина. Здесь можно посмотреть, как ваши покупатели будут видеть платежи через CloudPayments. Добавьте в корзину товар, который хотите купить. Деньги не спишутся — все товары, как и платежи, не настоящие.</p>
    </div>
</header>
<main class="page-goods page-goods--widget">
    <h2 class="visually-hidden">Окно товаров</h2>

    <ul class="page-goods__list page-goods__list--widget">
        <?php foreach ($products as $product): ?>
            <?php $in_cart = isset($order['items'][$product['id']]) ? $order['items'][$product['id']]['count'] : 0 ?>
            <li class="goods">
                <div class="goods__image-wrapper goods__image-wrapper--checkout">
                    <img src="<?= $assets_url . $product['image'] ?>" srcset="<?= $assets_url . $product['image2x'] ?>"
                         alt="<?= $product['alt'] ?> 2x" class="goods__image">
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

<section class="popup-down popup-down--hidden">
    <div class="popup-down__wrapper">
        <h3 class="popup-down__title">Ваш заказ:</h3>
        <button class="popup-down__close-btn close-button" type="button" name="button"><span class="visually-hidden">Закрыть попап</span>
        </button>
        <form class="popup-down__main" action="#">
            <div id="widget-cart">
                <?= $this->fetch('cart_widget', array('order' => $order)) ?>
            </div>
            <div class="not-empty-cart" <?php if ($order['total_count'] == 0):?> style="display: none;"<?php endif ?>>
                <div class="popup-down__group">
                    <span class="popup-down__text">Выслать кассовый чек</span>
                    <input class="popup-down__input-radio visually-hidden" type="radio" name="check" checked=""
                           id="checkMail">
                    <label class="radio-popup radio-popup--mail popup-down__radio-mail" for="checkMail">на почту</label>
                    <input class="popup-down__input-radio visually-hidden" type="radio" name="check" id="checkSms">
                    <label class="radio-popup popup-down__radio-sms" for="checkSms">sms</label>
                </div>
                <label class="popup-down__mail order__mail">
                    <input class="input-field" type="email" placeholder="ваш e-mail" id="email"
                           title="Введите свой электронный адрес"
                           pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                           required=""><span class="visually-hidden">Ваш email</span>
                </label>
                <label class="popup-down__tel order__tel order__invis">
                    <input class="input-field" type="tel" placeholder="ваш телефон" id="tel" title="Введите свой телефон"
                           pattern="\+7\s[0-9]{3}\s[0-9]{3}-[0-9]{2}-[0-9]{2}" required=""><span class="visually-hidden">Ваш телефон</span>
                </label>
                <div class="popup-down__select-wrapper">
                    <label class="popup-down__label">
                        Выберете стиль виджета
                        <select class="popup-down__select select-active  js-example-responsive" id="widget-skin" lang="ru" style="width: 100%">
                            <option class="popup-down__select-option option-active" selected="" value="classic">Classic</option>
                            <option class="popup-down__select-option option-active" value="modern">Modern</option>
                            <option class="popup-down__select-option option-active" value="mini">Minimal</option>
                        </select>
                    </label>
                </div>
                <div class="popup-down__footer">
                    <button class="popup-down__footer-button button" type="button" id="pay" disabled>Оплатить</button>
                    <p class="popup-down__footer-text">⚠︎ Оплата тестовая, можно использовать любые карты</p>
                </div>
            </div>
            <div class="empty-cart" <?php if ($order['total_count'] > 0):?> style="display: none;"<?php endif ?>>
                <p class="popup-down__footer-text">В корзине нет товаров</p>
            </div>
        </form>
    </div>
</section>

<div class="overlay overlay--invis"></div>

<script>
    window.cloudpayments_config = <?= json_encode( $config) ?>
</script>

<?php $this->addJs($assets_url . 'js/plugins/IMask.js') ?>
<?php $this->addJs($assets_url . 'js/validation.js') ?>
<?php $this->addJs($assets_url . 'js/changeFields.js') ?>
<?php $this->addJs($assets_url . 'js/button-cv.js') ?>
<?php $this->addJs($assets_url . 'js/select-custom.js') ?>
<?php $this->addJs($assets_url . 'js/basket.js') ?>
<?php $this->addJs($assets_url . 'js/widget-basket.js') ?>
<?php $this->addJs($assets_url . 'js/plugins/select2.js') ?>

<script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
<script>
    var pay = function () {
        var email = '', phone = '';
        if ($('#checkSms').is(':checked')) {
            phone = $('#tel').val();
        } else {
            email = $('#email').val();
        }
        var skin = $('#widget-skin').val();
        //Подготавливаем данные
        var json_data = {
            'cloudPayments': {
                'customerReceipt': {
                    'Items': [],
                    'taxationSystem': 0,
                    'email': email,
                    'phone': phone
                }
            }
        };
        //Формируем чек
        var items = [],
            total_cost = 0;
        $('#widget-cart li').each(function () {
            var $this = $(this);
            var quantity = $this.find('input').val();
            items.push({
                label: $this.data('name'),
                price: parseFloat($this.data('price')),
                quantity: quantity,
                amount: quantity * parseFloat($this.data('price')),
                vat: 18
            });
            total_cost += quantity * parseFloat($this.data('price'));
        });
        if (!total_cost) {
            alert('В корзине нет товаров');
            return false;
        }
        json_data['cloudPayments']['customerReceipt']['Items'] = items;

        //Вызываем виджет
        var widget = new cp.CloudPayments();
        widget.charge({
                publicId: window.cloudpayments_config.public_id,
                description: 'Оплата товаров в <?=$_SERVER['HTTP_HOST']?>',
                amount: total_cost, //сумма
                invoiceId: "1",
                accountId: "1",
                currency: "RUB",
                email: email,
                skin: skin,
                data: json_data
            },
            function (options) { // success
                window.location.assign("<?= $base_url ?>success/");
            },
            function (reason, options) { // fail
                window.location.assign("<?= $base_url ?>widget/");
            });

    };

    $(document).on('click', '#pay', function (e) {
        e.preventDefault();
        pay();
    });

</script>
