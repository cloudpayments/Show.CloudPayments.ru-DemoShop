$(function () {
    var merchantIdentifier = window.cloudpayments_config.applepay_merchant_id;

    //в примере используется библиотека jquery
    //дополнительные скрипты прописывать не требуется, все объекты для платежей Apple Pay уже есть в браузере Safari
    if (window.ApplePaySession) { //проверка устройства
        var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
        promise.then(function (canMakePayments) {
            if (canMakePayments) {
                $('#apple-pay').removeClass('button--order-hidden'); //кнопка Apple Pay
            }
        }).catch(function (err) {
            alert(err.message);
        });
    }

    $(document).on('click', '#apple-pay', function (e) { //обработчик кнопки
        e.preventDefault();
        var request = {
            requiredShippingContactFields: ['email'], //Раскомментируйте, если вам нужен e-mail. Также можно запросить postalAddress, phone, name.
            countryCode: 'RU',
            currencyCode: 'RUB',
            supportedNetworks: ['visa', 'masterCard'],
            merchantCapabilities: ['supports3DS'],
            //Назначение платежа указывайте только латиницей!
            total: {label: 'Test_Pay', amount: window.order_cost}, //назначение платежа и сумма
        };
        var session = new ApplePaySession(1, request);

        // обработчик события для создания merchant session.
        session.onvalidatemerchant = function (event) {
            var data = {
                validationUrl: event.validationURL
            };
            // отправьте запрос на ваш сервер, а далее запросите API CloudPayments
            // для запуска сессии
            data['action'] = 'startSession';
            data['pay'] = 'Apple';
            $.post("/order/", data).then(function (result) {
                session.completeMerchantValidation(result.Model);
            });
        };

        // обработчик события авторизации платежа
        session.onpaymentauthorized = function (event) {
            var data = {
                cryptogram: JSON.stringify(event.payment.token)
            };

            //отправьте запрос на ваш сервер, а далее запросите API CloudPayments
            //для проведения оплаты
            data['action'] = 'pay';
            data['pay'] = 'Apple';
            if ($('#checkSms').is(':checked')) {
                data['Phone'] = $('#tel').val();
            } else {
                data['Email'] = $('#email').val();
            }

            $.ajax({
                url: "/order/",
                data: data,
                type: 'post',
                dataType: 'json',
            }).done(function (response) {
                var status;
                if (response.Success) {
                    status = ApplePaySession.STATUS_SUCCESS;
                    window.location.replace('/success/');
                } else {
                    status = ApplePaySession.STATUS_FAILURE;
                    alert(response['Message']);
                }
                session.completePayment(status);
            });
        };

        // Начало сессии Apple Pay
        session.begin();
    });
});
