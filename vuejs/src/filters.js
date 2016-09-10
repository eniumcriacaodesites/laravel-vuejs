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
