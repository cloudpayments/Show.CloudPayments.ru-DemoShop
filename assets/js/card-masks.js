'use strict';

(function() {
    var numCard = document.getElementById('numCard');
    var nameOwner = document.getElementById('nameOwner');
    var month = document.getElementById('month');
    var year = document.getElementById('year');
    var cvvCard = document.getElementById('cvvCard');

    var optionNum = {
        mask: '0000 0000 0000 0000'
    }
    var cardMask = new IMask(numCard, optionNum);

    var optionName = {
        mask: 'string*string2',
        definitions: {
            '*': /\s/
        },
        blocks: {
            string: {
                mask: /^[a-zA-Z]+$/
            },
            string2: {
                mask: /^[a-zA-Z]+$/
            }
        }
    }
    var nameMask = new IMask(nameOwner, optionName);

    window.numCard = numCard;
})();
