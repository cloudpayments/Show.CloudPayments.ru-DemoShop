'use strict';

(function() {
  var popupDown = document.querySelector('.popup-down');
  var popupDownCloseBtn = document.querySelector('.popup-down__close-btn');
  var popupDownMinus = document.querySelector('.popup-down__minus');
  var popupDownPlus = document.querySelector('.popup-down__plus');
  var popupDownNumber = document.querySelector('.popup-down__number');
  var popupDownCost = document.querySelector('.popup-down__cost');
  var popupDownTextBold = document.querySelector('.popup-down__text-bold');
  var overlay = document.querySelector('.overlay');
  var ESC_CODE = 27;

//  popupDown.classList.remove('popup-down--hidden');

  var goodsMinus = function () {
    var numberGoods = Number(popupDownNumber.textContent);
    if (numberGoods > 0) {
      numberGoods = numberGoods - 1;
      popupDownCost.textContent = numberGoods + 'р.';
      popupDownTextBold.textContent = 'Итого:' + ' ' + numberGoods + 'р.';
    return popupDownNumber.textContent = numberGoods;
    }
  }

  var goodsPlus = function () {
    var numberGoods = Number(popupDownNumber.textContent);
    numberGoods = numberGoods + 1;
    popupDownCost.textContent = numberGoods + 'р.';
    popupDownTextBold.textContent = 'Итого:' + ' ' + numberGoods + 'р.';
    return popupDownNumber.textContent = numberGoods;
  }

//  var closePopup = function () {
//    overlay.classList.add('overlay--invis');
//    popupDown.classList.add('popup-down--hidden');
//    popupDownCloseBtn.removeEventListener('click', closePopup);
//  }

//  var clickEsc = function (e) {
//    if (e.keyCode === ESC_CODE) {
//      overlay.classList.add('overlay--invis');
//      popupDown.classList.add('popup-down--hidden');
//      popupDownCloseBtn.removeEventListener('click', closePopup);
//    }
//  }

//  document.addEventListener('keydown', clickEsc);
  popupDownMinus.addEventListener('click', goodsMinus);
  popupDownPlus.addEventListener('click', goodsPlus);
//  popupDownCloseBtn.addEventListener('click', closePopup);
})();
