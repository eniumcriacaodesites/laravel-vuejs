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
            number = value.toString().match(/\d+(\.{1}\d{1,2}){0,1}/g)[0] || 0;
        }

        // ECMAScript 5
        // return new Number(number).toLocaleString('pt-BR', {
        //     minimumFractionDigits: 2,
        //     maximumFractionDigits: 2,
        //     style: 'currency',
        //     currency: 'BRL'
        // });

        // ECMAScript 6
        return new Intl.NumberFormat('pt-BR', {
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