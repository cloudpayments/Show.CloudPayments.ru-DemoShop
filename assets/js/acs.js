'use strict';

(function() {
    var popupPay = document.querySelector('.popup-pay');
    var popupIFrame = popupPay.querySelector('.popup-pay__iframe');
    var overlay = document.querySelector('.overlay');

    var ESC_KEY = 27;

// Изменение попапа (true - open / false - close)
    function changePopup(logic) {
        document.body.classList[logic ? 'add' : 'remove']('modal-open');
        popupPay.classList[logic ? 'add' : 'remove']('popup--vis');
        overlay.classList[logic ? 'remove' : 'add']('overlay--invis');
        document[logic ? 'addEventListener' : 'removeEventListener']('keydown', closeEscPopup);
    }

    function closePopup(e) {
        changePopup(false);
    }

    function closeEscPopup(e) {
        if (e.keyCode === ESC_KEY) {
            changePopup(false);
        }
    }

    overlay.addEventListener('click', closePopup);

    window.openAcs = function (form) {
        popupIFrame.contentDocument.write(form);
        changePopup(true);
    }
})();
