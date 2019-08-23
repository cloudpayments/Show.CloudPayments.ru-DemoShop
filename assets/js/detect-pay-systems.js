'use strict';

(function () {
    var AMERICAN__EXPRESS = /^3[47][0-9]{0,}$/; // /^3[47][0-9]{13}$/;
    var JCB = /^(?:2131|1800|35)[0-9]{0,}$/; // /^(?:2131|1800|35\d{3})\d{11}$/;
    var MAESTRO = /^(5[06789]|6)[0-9]{0,}$/;
    var MASTER_CARD = /^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$/; ///^5[1-5][0-9]{14}$/;
    var MIR = /^2[2][0-9]{0,}$/;
    var VISA = /^4[0-9]{0,}$/; // /^4[0-9]{12}(?:[0-9]{3})?$/;
    var image = document.querySelector('.card__image');
    var baseUrl = image.dataset['baseUrl'];

    image.classList.add('card__image--none');

    function addViewSystem(src) {
        image.setAttribute('src', src);
        image.classList.remove('card__image--none');
    }

    function viewCards(e) {
        var target = e.target.value.replace(/\D/g, '');

        if (target.match(AMERICAN__EXPRESS)) {
            addViewSystem(baseUrl + 'img/cards/ae.svg');
        } else if (target.match(JCB)) {
            addViewSystem(baseUrl + 'img/cards/jcb.svg');
        } else if (target.match(MAESTRO)) {
            addViewSystem(baseUrl + 'img/cards/maestro.svg');
        } else if (target.match(MASTER_CARD)) {
            addViewSystem(baseUrl + 'img/cards/master-card.svg');
        } else if (target.match(MIR)) {
            addViewSystem(baseUrl + 'img/cards/mir.svg');
        } else if (target.match(VISA)) {
            addViewSystem(baseUrl + 'img/cards/visa.svg');
        } else {
            image.classList.add('card__image--none');
        }
    }

    window.numCard.addEventListener('input', viewCards);
})();
