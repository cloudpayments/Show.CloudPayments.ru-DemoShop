<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Интернет-магазин Cloudpayments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?= $assets_url ?>css/style.min.css" type="text/css" rel="stylesheet">
    <script src="<?= $assets_url ?>js/plugins/jquery-3.4.1.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet">
</head>

<body>

<?= $content ?>

<footer class="page-footer <?= $footer_classes ?>">
    <section class="page-footer__wrapper">
        <nav class="page-footer__nav footer-navigation">
            <ul class="footer-navigation__list">
                <li class="footer-navigation__item"><a href="tel:+74953747860" class="footer-navigation__link">+7 495 374-78-60</a></li>
                <li class="footer-navigation__item"><a href="mailto:sales@cloudpayments.ru" class="footer-navigation__link">sales@cloudpayments.ru</a></li>
            </ul>
            <ul class="footer-navigation__list">
                <li class="footer-navigation__item"><a href="https://cloudpayments.ru/wiki/podkluchenie/poryadok_podkluchenia/123" class="footer-navigation__link" target="_blank">Порядок подключения</a></li>
                <li class="footer-navigation__item"><a href="https://cloudpayments.ru/wiki/podkluchenie/poryadok_podkluchenia/oferta" class="footer-navigation__link" target="_blank">Оферта</a></li>
            </ul>
            <ul class="footer-navigation__list">
                <li class="footer-navigation__item"><a href="https://developers.cloudpayments.ru/" class="footer-navigation__link" target="_blank">Разработчикам</a></li>
                <li class="footer-navigation__item"><a href="https://merchant.cloudpayments.ru/login" class="footer-navigation__link" target="_blank">Войти</a></li>
            </ul>
            <ul class="footer-navigation__list footer-navigation__list--last">
                <li class="footer-navigation__item">CloudPayments © 2014 - 2019</li>
                <li class="footer-navigation__item footer-navigation__item--appstore"><a href="https://itunes.apple.com/ru/app/cloudpayments/id1151790998?mt=8" class="footer-navigation__link footer-navigation__link--appstore" target="_blank"></a></li>
                <li class="footer-navigation__item footer-navigation__item--googleplay"><a href="https://play.google.com/store/apps/details?id=ru.cloudpayments.merchant" class="footer-navigation__link footer-navigation__link--googleplay" target="_blank"></a></li>
            </ul>
        </nav>
    </section>

</footer>

<?= $this->js() ?>

</body>

</html>

