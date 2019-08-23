'use strict';

(function() {
  var payButton = document.getElementById('payButton');
  var cardFields = document.querySelectorAll('.card__field');
  var cardForm = document.querySelector('.card__form');
  var monthField = document.getElementById('monthIn');
  var yearField = document.getElementById('yearIn');
  var numberField = document.getElementById('numberIn');
  var nameField = document.getElementById('nameIn');

  var CARD_LENGTH = 18;
  var NAME_LENGTH = 5;
  var DATE_LENGTH = 1;
  var CVV_LENGTH = 2;
  var wordsArr = [CARD_LENGTH, NAME_LENGTH, DATE_LENGTH, DATE_LENGTH, CVV_LENGTH];
  var dataValid = [];

  var yearDate = new Date().getFullYear();
  var monthDate = new Date().getMonth() + 1;
  var currentYear = +('' + yearDate).split('').splice(2).join(''); // последние две цифры года

/* function luhnValid(cardNo) {
    var sum = 0, even = false;
    cardNo.split("").reverse().forEach(function(dstr){ d = parseInt(dstr);
      sum += ((even = !even) ? d : (d < 5) ? d * 2 : (d - 5) * 2 + 1);
      });
    return (sum % 10 == 0);
  }
  */
 /*
  function valid_credit_card(value) {
      // Accept only digits, dashes or spaces
	  if (/[^0-9-\s]+/.test(value)) return false;
	    // The Luhn Algorithm. It's so pretty.
	  let nCheck = 0, bEven = false;
	    value = value.replace(/\D/g, "");
  	    for (var n = value.length - 1; n >= 0; n--) {
		      var cDigit = value.charAt(n),
			    nDigit = parseInt(cDigit, 10);
		  if (bEven && (nDigit *= 2) > 9) nDigit -= 9;
    nCheck += nDigit;
		bEven = !bEven;
	}
	return (nCheck % 10) == 0;
  }
 */


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

  function setCvvElement(field) {
    field.classList[field.value.length <= CVV_LENGTH ? 'add' : 'remove']('card__field--error');
    field.setAttribute('data-valid', [field.value.length <= CVV_LENGTH ? 0 : 1]);
    if (window.matchMedia("(max-width: 768px)").matches) {
      field.classList[field.value.length <= CVV_LENGTH ? 'remove' : 'add']('card__field--success');
    }
  }

  function setStyleFields(flag, field) {
    if (field.getAttribute('data-number') == 4) {
      setCvvElement(field);
    } else {
      field.setAttribute('data-valid', [flag ? 0 : 1]);
      field.classList[flag ? 'add' : 'remove']('card__field--error');
      field.classList[flag ? 'remove' : 'add']('card__field--success');
    }
  }

  function onInputHandler(event) {
    var target = event.target;
    var targetNum = event.target.getAttribute('data-number');
    target.value = target.value.replace(/\D/g, '');

    if (targetNum == 2) {
      if (cardFields[3].value < currentYear && cardFields[3].value.length > 0) {
        setStyleFields(true, target);
        monthField.textContent = 'ММ';
      } else if (cardFields[3].value == currentYear && +target.value < monthDate) {
        setStyleFields(true, target);
        monthField.textContent = 'ММ';
      } else if (target.value.length === 0) {
        setStyleFields(true, target);
        monthField.textContent = 'ММ';
      } else if (+target.value <= 0 || +target.value > 12) {
        setStyleFields(true, target);
        monthField.textContent = 'ММ';
        } else {
        setStyleFields(false, target);
        monthField.textContent = target.value;
        }
    }
    else if (targetNum == 3) {
      if (+target.value < currentYear) {
        setStyleFields(true, target);
        yearField.textContent = 'ГГ';
        if (cardFields[2].value.length > 0) {
          setStyleFields(true, cardFields[2]);
          monthField.textContent = 'ММ';
        }
      } else if (target.value == currentYear) {
        setStyleFields(false, target);
        yearField.textContent = cardFields[3].value;
        if (+cardFields[2].value >= monthDate && +cardFields[2].value < 13) {
          setStyleFields(false, cardFields[2]);
          monthField.textContent = cardFields[2].value;
          }
      } else if (+target.value >= currentYear) {
        setStyleFields(false, target);
        yearField.textContent = cardFields[3].value;
        if (cardFields[2].value.length > 0 && +cardFields[2].value < 13) {
          setStyleFields(false, cardFields[2]);
          monthField.textContent = cardFields[2].value;
        }
        }
    }
    else if (targetNum == 4) {
      setCvvElement(target);
      }
    }

  function onBlurHandler(evt) {
    var field = evt.target;
    var targetNum = field.getAttribute('data-number');

    if (targetNum == 0) {
      if (field.value.length <= wordsArr[targetNum]) {
        setStyleFields(true, field);
        numberField.textContent = '0000';
      } else {
        setStyleFields(false, field);
        numberField.textContent = field.value.slice(15);
      }
    }
    else if (targetNum == 1) {
      if (field.value.length > 1) {
        setStyleFields(false, field);
        nameField.textContent = cardFields[targetNum].value.toUpperCase();
      } else {
        setStyleFields(true, field);
        nameField.textContent = 'Имя Владельца';
      }
    }
  }

  for (var i = 0; i < 2; i++) {
    cardFields[i].addEventListener('blur', onBlurHandler);
  }
  for (var i = 2; i < 5; i++) {
    cardFields[i].addEventListener('input', onInputHandler);
  }

})();
