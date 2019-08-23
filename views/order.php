<header class="page-header header header--order">
    <div class="page-header__wrapper header__wrapper">
        <a href="<?= $base_url ?>" class="page-header__link header__link"></a>
    </div>
</header>
<main>
    <section class="order">
        <div class="order__wrapper">
            <h1 class="order__title">Ваш заказ</h1>
            <a class="order__btn-back" href="<?= $base_url ?>checkout/">Назад</a>
            <?php if (count($order['items'])): ?>
            <form class="order__main" action="#">
                <?= $this->fetch('cart_order', array('order' => $order)) ?>
                <div class="order__group">
                    <span class="order__text">Выслать кассовый чек</span>
                    <input class="order__radio visually-hidden" type="radio" name="check" checked="" id="checkMail">
                    <label class="radio-popup radio-popup--mail" for="checkMail">На почту</label>
                    <input class="order__radio visually-hidden" type="radio" name="check" id="checkSms">
                    <label class="radio-popup" for="checkSms">sms</label>
                </div>
                <label class="order__mail">
                    <input class="input-field" type="email" placeholder="ваш e-mail" id="email" autofocus
                           title="Введите свой электронный адрес"
                           pattern="^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$"
                           required=""><span class="visually-hidden">Ваш email</span>
                </label>
                <label class="order__tel order__invis">
                    <input class="input-field" type="tel" placeholder="ваш телефон" id="tel"
                           title="Введите свой телефон" pattern="\+7\s[0-9]{3}\s[0-9]{3}-[0-9]{2}-[0-9]{2}" required=""><span
                            class="visually-hidden">Ваш телефон</span>
                </label>
            </form>
            <span class="order__warning">⚠︎ Оплата тестовая, можно использовать любые карты</span>
            <div class="order__btns">
                <button class="button button--order button--order-card" type="button" disabled="">Оплатить картой</button>
                <button id="apple-pay" class="button button--order button--order-apple button--order-hidden" type="button" disabled><span class="button__text">Pay</span></button>
                <button id="google-pay" class="button button--order button--order-google button--order-hidden" type="button" disabled><span class="button__text">Pay</span></button>
            </div>
            <?php else: ?>
                <span class="order__warning">В корзине нет товаров</span>
            <?php endif ?>
        </div>
    </section>

    <section class="card card--invis">
        <div class="card__wrapper">
            <h3 class="visually-hidden">Оплата картой</h3>
            <form class="card__form" method="post" id="payment-form">
                <input class="card__field" data-number="0" type="text" id="numCard" placeholder="Номер карты" autocomplete="off" data-valid="0" data-cp="cardNumber" autofocus>
                <label class="card__check card__check--num" for="numCard"><span class="visually-hidden">Номер карты</span></label>
                <input class="card__field card__field--nameOwner" data-number="1" type="hidden" id="nameOwner"  data-valid="0" data-cp="name" value="Walter White">
                <label class="card__check card__check--nameOwner" for="nameOwner"><span class="visually-hidden">Walter White</span></label>
                <div class="card__cvv-section">
                    <input class="card__field card__field--month" data-number="2" maxlength="2" type="text" id="month" placeholder="ММ" autocomplete="off" data-valid="0" data-cp="expDateMonth">
                    <label class="card__check card__check--month" for="month"><span class="visually-hidden">Месяц и год</span></label>
                    <input class="card__field card__field--year" data-number="3" maxlength="2" type="text" id="year" placeholder="ГГ" autocomplete="off" data-valid="0" data-cp="expDateYear">
                    <label class="card__check card__check--year" for="year"><span class="visually-hidden">Месяц и год</span></label>
                    <input class="card__field card__field--cvv" data-number="4" type="text" id="cvvCard" placeholder="CVC / CVV2" autocomplete="off" data-valid="0" maxlength="3" data-cp="cvv">
                    <label class="card__check card__check--cvv" for="cvvCard"><span class="visually-hidden">CVV карты</span></label>
                </div>
                <div class="card__view">
                    <p class="card__stars">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;<span class="card__number-input" id="numberIn">0000</span></p>
                    <b class="card__name-input" id="nameIn">Walter White</b>
                    <p class="card__life-date">
                        <span>Действует до</span>
                    <div class="card__date-input">
                        <span id="monthIn">ММ</span>&#47;<span id="yearIn">ГГ</span>
                    </div>
                    </p>
                    <img class="card__image" src="<?= $assets_url ?>img/cards/mok.png" data-base-url="<?= $assets_url ?>">
                </div>
                <button class="card__btn-pay" id="payButton" type="submit" name="button">Оплатить&nbsp;<span class="card__sum-pay"><?= $order['total_cost']?></span>&nbsp;&#8381;</button>
            </form>
            <picture class="card__pay-systems">
                <img src="<?= $assets_url ?>img/svg/pay-systems.svg" alt="Платежные системы">
            </picture>
        </div>
    </section>
</main>

<section class="popup-pay popup">
    <h3 class="visually-hidden">Попап подтверждения оплаты</h3>
    <iframe class="popup-pay__iframe" width="586" height="704"></iframe>
    <picture class="popup-pay__image">
        <source media="(min-width: 768px)" srcset="<?= $assets_url ?>img/svg/desktop-pay.svg">
        <img src="<?= $assets_url ?>img/svg/pay-systems.svg" alt="Платёжные системы">
    </picture>
</section>

<div class="overlay overlay--invis"></div>
<script>
    window.cloudpayments_config = <?= json_encode( $config) ?>
</script>

<?php $this->addJs($assets_url . 'js/plugins/IMask.js') ?>
<?php $this->addJs($assets_url . 'js/validation.js') ?>
<?php $this->addJs($assets_url . 'js/card-masks.js') ?>
<?php $this->addJs($assets_url . 'js/changeFields.js') ?>
<?php $this->addJs($assets_url . 'js/basket.js') ?>
<?php $this->addJs($assets_url . 'js/button-cv.js') ?>
<?php $this->addJs($assets_url . 'js/validation-pay-card.js') ?>
<?php $this->addJs($assets_url . 'js/detect-pay-systems.js') ?>
<?php $this->addJs($assets_url . 'js/acs.js') ?>
<?php $this->addJs($assets_url . 'js/applepay.js') ?>
<?php $this->addJs($assets_url . 'js/googlepay.js') ?>
<?php $this->addJs('<script async src="https://pay.google.com/gp/p/js/pay.js" onload="window.onGooglePayLoaded()"></script>') ?>

<script src="https://widget.cloudpayments.ru/bundles/checkout"></script>

<script>
    window.order_cost = <?= $order['total_cost'] ?>;
    var createCryptogram = function (checkout) {
        var result = checkout.createCryptogramPacket();
        if (result.success) {
            // сформирована криптограмма
            var email = '', phone = '';
            if ($('#checkSms').is(':checked')) {
                phone = $('#tel').val();
            } else {
                email = $('#email').val();
            }
            var data = {
                action: 'sendCryptogram',
                cryptogram: result.packet,
                name: $('#nameOwner').val(),
                email: email,
                phone: phone
            };
            $.ajax({
                url: '/order/',
                data: data,
                type: 'post',
                dataType: 'json'
            }).done(function (response) {
                if (response['Success']) {
                    window.location.href = response['success_url']
                }
                else {
                    if (response['acs_form']) {
                        window.openAcs(response['acs_form']);
                    } else {
                        console.error(response);
                        alert('Произошла ошибка при оплате');
                    }
                }
            });
        } else {
            var $form = $('#payment-form');
            // найдены ошибки в введённых данных, объект `result.messages` формата:
            // { name: "В имени держателя карты слишком много символов", cardNumber: "Неправильный номер карты" }
            // где `name`, `cardNumber` соответствуют значениям атрибутов `<input ... data-cp="cardNumber">`
            for (var msgName in result.messages) {
                var $input = $form.find('[data-cp="' + msgName + '"]');
                $input.removeClass('card__field--success').addClass('card__field--error');
                console.error(msgName, result.messages[msgName]);
            }
        }
    };

    $(document).on("submit", "#payment-form", function (e) {
        e.preventDefault();
        //Проверяем ошибки в форме
        //При ошибках в файле validation-pay-card добавляется класс card__field--error
        var form_valid = true;
        $(this).find('.card__field').each(function() {
            form_valid = form_valid && !$(this).hasClass('card__field--error');
        });
        if (!form_valid) {
            return false;
        }
        /* Создание checkout */
        var checkout = new cp.Checkout(
            // public id из личного кабинета
            cloudpayments_config.public_id,
            // тег, содержащий поля данных карты
            document.getElementById("payment-form"));
            createCryptogram(checkout);
    });
</script>

<?php $this->setData('footer_classes', 'footer footer--order') ?>
