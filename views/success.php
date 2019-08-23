<script type="text/javascript">
    (function () {
        //Внутри iframe, открываем стараницу в главном окне
        if (window.top !== window.self) {
            top.window.location.href = self.window.location.href;
        }
    })();
</script>

<header class="page-header">
    <div class="page-header__wrapper">
        <a href="<?= $base_url ?>" class="page-header__link"><span class="visually-hidden">Главная страница CloudPayments</span></a>
    </div>
</header>

<section class="popup-success">
    <h3 class="visually-hidden">Успешная оплата</h3>
    <div class="popup-success__wrapper">
        <img class="popup-success__image" src="<?= $assets_url ?>img/svg/success-order.svg" alt="Удачное оформление">
        <p class="popup-success__text">Заказ оплачен</p>
        <a class="popup-success__btn button" href="https://show.cloudpayments.ru/widget">Вернуться в магазин</a>
    </div>
</section>
