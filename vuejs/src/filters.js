Vue.filter('doneLabel', (value) => (value == 1) ? "Sim" : "Não");

Vue.filter('statusBillPay', (value) => {
    if (value === 0) {
        return '<span class="green">&raquo; Nenhuma conta a pagar.</span>';
    } else if (value === 1) {
        return '<span class="red">&raquo; Existe ' + value + ' conta a ser paga.</span>';
    } else if (value > 1) {
        return '<span class="red">&raquo; Existem ' + value + ' contas a serem pagas.</span>';
    }
    return '<span class="gray">&raquo; Nenhuma conta cadastrada.</span>';
});

Vue.filter('statusBillReceive', (value) => {
    if (value === 0) {
        return '<span class="green">&raquo; Nenhuma conta a receber.</span>';
    } else if (value === 1) {
        return '<span class="red">&raquo; Existe ' + value + ' conta a receber.</span>';
    } else if (value > 1) {
        return '<span class="red">&raquo; Existem ' + value + ' contas a serem recebidas.</span>';
    }
    return '<span class="gray">&raquo; Nenhuma conta cadastrada.</span>';
});

Vue.filter('numberFormat', {
    read(value){ // show information in the view
        let number = 0;
        if (value && typeof value !== undefined) {
            let numberRegex = value.toString().match(/\d+(\.{1}\d{1,2}){0,1}/g);
            number = numberRegex ? numberRegex[0] : numberRegex;
        }

        // ECMAScript 5
        // return new Number(number).toLocaleString('pt-br', {
        //     minimumFractionDigits: 2,
        //     maximumFractionDigits: 2,
        //     style: 'currency',
        //     currency: 'BRL'
        // });

        // ECMAScript 6
        return new Intl.NumberFormat('pt-br', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            style: 'currency',
            currency: 'BRL'
        }).format(number);
    },
    write(value){ // get value of view and convert for storage in model
        let number = 0;
        if (value.length > 0) {
            number = value.replace(/[^\d\,]/g, '').replace(/\,/g, '.');
            number = isNaN(number) ? 0 : parseFloat(number);
        }

        return number;
    }
});

Vue.filter('dateFormat', {
    read(value, lang){ // show information in the view
        if (value.length == 10) {
            let localeData = moment(value, 'YYYY-MM-DD').locale('en');
            localeData.locale(lang);
            return localeData.format('L');
        }
        return value;
    },
    write(value, oldValue, lang){ // get value of view and convert for storage in model
        if (value.length == 10) {
            let dateFormat = moment.localeData(lang).longDateFormat('L');
            let localeData = moment(value, dateFormat).locale(lang);
            localeData.locale('en');
            return localeData.format('YYYY-MM-DD');
        }
        return value;
    }
});

Vue.filter('textFormat', {
    read(value){ // show information in the view
        return value.toUpperCase();
    },
    write(value){ // get value of view and convert for storage in model
        return value.toLowerCase();
    }
});

/*
 // Testing integration with moment.js

 console.log('pt-br -> en');

 var fromDate = 'pt-br';
 var toDate = 'en';
 var myDate = '05/11/2016';

 var dateFormat = moment.localeData(fromDate).longDateFormat('L');

 var localeData = moment(myDate, dateFormat).locale(fromDate);

 localeData.locale(toDate);
 console.log(myDate + ' -> ' + localeData.format('L'));


 console.log('en -> pt-br');

 var fromDate = 'en';
 var toDate = 'pt-br';
 var myDate = '11/05/2016';

 var dateFormat = moment.localeData(fromDate).longDateFormat('L');

 var localeData = moment(myDate, dateFormat).locale(fromDate);

 localeData.locale(toDate);
 console.log(myDate + ' -> ' + localeData.format('L'));
 */
