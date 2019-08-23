# Демонстрация технологий СloudPayments и CloudKassir в Web

В каталоге show находится код  [Демо-Магазина CloudPayments](https://show.cloudpayments.ru)      
Можете использовать его составляющие в своих проектах или для проверки/тестов на своем демо-стенде.

**Внимание!** Не является интернет магазином. Это всего лишь эмуляция витрины. 


## Структура:

 * /application  - приложение (модель, контроллер, виды)
 * /views - шаблоны представления
 * /assets - js, css, fonts, img приложения 
 * /.well-known  - фолдер для размещения файла валидации  ApplePay.
 
## Checkout Script
Установка скрипта подробно расписана в [документации](https://developers.cloudpayments.ru/#ustanovka) CloudPayments.
Для выполнения платежа используется [метод оплаты по криптограмме](https://developers.cloudpayments.ru/#oplata-po-kriptogramme), включая [обработку 3DS](https://developers.cloudpayments.ru/#obrabotka-3-d-secure). 

Онлайн чеки отправляются в CloudKassir по API кассы с помощью запроса на [формирование кассового чека](https://developers.cloudkassir.ru/#formirovanie-kassovogo-cheka).
 
## Widget
Все файлы, пронумерованные цифрой 2 в проекте - относятся к Реализации платёжного [виджета](https://developers.cloudpayments.ru/#platezhnyy-vidzhet).

Онлайн чеки в таком исполнении отправляются в CloudKassir  через платёжный виджет  непосредственно в установленном [формате](https://developers.cloudpayments.ru/#format-peredachi-dannyh-dlya-onlayn-cheka).


По возникающим вопросам технического характера обращайтесь по адресу support@cloudpayments.ru. 
Мы поможем!