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

<section class="popup-failure">
    <h3 class="visually-hidden">Неудачная оплата</h3>
    <div class="popup-failure__wrapper">
        <img class="popup-failure__image" src="<?= $assets_url ?>img/svg/failure-order.svg" alt="Неудачное оформление">
        <p class="popup-failure__text">Заказ не был оплачен</p>
        <a class="popup-failure__btn button" href="<?= $base_url ?>">Вернуться в магазин</a>
    </div>
</section>
