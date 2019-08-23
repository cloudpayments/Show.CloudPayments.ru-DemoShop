'use strict';

(function() {
  var checkoutBtns = document.querySelectorAll('.addBtn');
  var popup = document.querySelector('.popup-one');
  var overlay = document.querySelector('.overlay');
  var closeBtn = popup.querySelector('.close-button');
  var continueBtn = popup.querySelector('.button-popup--continue');
  var addedItem = popup.querySelector('.popup-one__list');

  var ADD_COUNT = 1;
  var REMOVE_COUNT = 0;

  function changeContent (el, state1, state2, state3) {
    el.value = state1;
    el.classList[state1 === ADD_COUNT ? 'add' : 'remove'](state2);
    el.textContent = state3;
  }

  function closePopup () {
    overlay.classList.add('overlay--invis');
    document.body.classList.remove('modal-open');
    popup.classList.remove('popup--vis');
    closeBtn.removeEventListener('click', closePopup);
    continueBtn.removeEventListener('click', closePopup);
    overlay.removeEventListener('click', onPopupClick);
    document.removeEventListener('keydown', escPushHandler);
  }

  function onPopupClick (event) {
    if (event.target.classList.contains('overlay')) {
      closePopup();
    }
  }

  function escPushHandler (e) {
    if (e.keyCode === 27) {
      closePopup();
    }
  }

  function openPopup (value) {
    if (value == 1) {
      overlay.classList.remove('overlay--invis');
      document.body.classList.add('modal-open');
      popup.classList.add('popup--vis');
      closeBtn.addEventListener('click', closePopup);
      continueBtn.addEventListener('click', closePopup);
      overlay.addEventListener('click', onPopupClick);
      document.addEventListener('keydown', escPushHandler);
    }
  }

  function changeCount (evt) {
    var target = evt.target;

    if (target.value == 0) {
      window.basket.add(target.dataset['productId'], function (response) {
        addedItem.innerHTML = response['cart_added'];
        changeContent(target, ADD_COUNT, 'button--basket', 'Удалить');
        openPopup(target.value);
      });
    } else {
      window.basket.remove(target.dataset['productId'], function (response) {
        changeContent(target, REMOVE_COUNT, 'button--basket', 'Купить');
      });
    }
  }

  for (var i = 0; i < checkoutBtns.length; i++) {
    checkoutBtns[i].addEventListener('click', changeCount);
  }

})();
