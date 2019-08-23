(function() {
    var gateway = window.cloudpayments_config.googlepay_gateway;
    var gatewayMerchantId = window.cloudpayments_config.public_id; //ваш public id
    var merchantId = window.cloudpayments_config.googlepay_merchant_id;; //выдается после регистрации в Google

//в примере используется библиотека jquery
    var allowedPaymentMethods = ['CARD', 'TOKENIZED_CARD'];
    var allowedCardNetworks = ['MASTERCARD', 'VISA'];
    var tokenizationParameters = {
        tokenizationType: 'PAYMENT_GATEWAY',
        parameters: {
            'gateway': gateway,
            'gatewayMerchantId': gatewayMerchantId
        }
    };

    function getGooglePaymentsClient() {
        return (new google.payments.api.PaymentsClient({environment: 'PRODUCTION'}));
    }

    //обработчик загрузки Google Pay API
    window.onGooglePayLoaded = function() {
        var paymentsClient = getGooglePaymentsClient();
        //проверка устройства
        paymentsClient.isReadyToPay({allowedPaymentMethods: allowedPaymentMethods})
            .then(function (response) {
                if (response.result) {
                    $('#google-pay').removeClass('button--order-hidden'); //кнопка Apple Pay
                    $(document).on('click', '#google-pay',onGooglePaymentButtonClicked);
                }
            });
    }

    //настройки
    function getGooglePaymentDataConfiguration() {
        return {
            merchantId: merchantId, //выдается после регистрации в Google
            paymentMethodTokenizationParameters: tokenizationParameters,
            allowedPaymentMethods: allowedPaymentMethods,
            cardRequirements: {
                allowedCardNetworks: allowedCardNetworks
            }
        };
    }

    //информация о транзакции
    function getGoogleTransactionInfo() {
        return {
            currencyCode: 'RUB',
            totalPriceStatus: 'FINAL',
            totalPrice: order_cost
        };
    }

    //обработчик кнопки
    function onGooglePaymentButtonClicked(e) {
        e.preventDefault();
        var paymentDataRequest = getGooglePaymentDataConfiguration();
        paymentDataRequest.transactionInfo = getGoogleTransactionInfo();

        var paymentsClient = getGooglePaymentsClient();
        paymentsClient.loadPaymentData(paymentDataRequest)
            .then(function (paymentData) {
                processPayment(paymentData);
            });
    }

    //обработка платежа
    function processPayment(paymentData) {
        var data = {
            cryptogram: JSON.stringify(paymentData.paymentMethodToken.token)
        };
        // отправьте запрос на ваш сервер, а далее запросите API CloudPayments
        // для проведения оплаты
        data['action'] = 'pay';
        data['pay'] = 'Google';
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
            if (response['Success']) {
                //оплата успешно завершена
                window.location.replace('/success/');
            } else {
                if (response['acs_form']) {
                    window.openAcs(response['acs_form']);
                } else {
                    alert('Оплата отколнена');
                }
            }
        });
    }
})();
