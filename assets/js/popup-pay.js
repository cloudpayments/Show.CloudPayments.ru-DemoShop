'use strict';

(function() {
  var ESC_CODE = 27;
  var INPUT__VALUE = 4;

  var closeBtn = document.querySelector('.close-button');
  var submitBtn = document.querySelector('.popup-pay__btn');
  var popupPay = document.querySelector('.popup-pay');
  var input = document.getElementById('capcha');
  var overlay = document.querySelector('.overlay');

  var optionNumb = {
    mask: Number,
    min: 0,
    max: 9
  };

  var numbMask = IMask(input, optionNumb);

  function popupDel() {
    document.body.classList.remove('modal-open');
    popupPay.classList.remove('popup--vis');
    overlay.classList.add('overlay--invis');
    document.removeEventListener('keydown', closePopup);
    submitBtn.removeEventListener('click', closePopup);
    popupPay.removeEventListener('click', closeWin);
  }

  function closePopup(e) {
    if (e.keyCode === ESC_CODE) {
      popupDel();
    } else if (Number(input.value) === INPUT__VALUE && e.target.tagName == 'BUTTON') {
      e.preventDefault();
      popupDel();
    }
  }

  function closeWin() {
    popupDel();
  }

  if (popupPay.classList.contains('popup--vis')) {
    document.body.classList.add('modal-open');
    document.addEventListener('keydown', closePopup);
    submitBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', closeWin);
  }
})();
