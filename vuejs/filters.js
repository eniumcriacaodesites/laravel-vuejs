Vue.filter('doneLabel', function (value) {
    return (value == 1) ? "Paga" : "Não paga";
});

Vue.filter('statusLabel', function (value) {
    if (value === 0) {
        return '<span class="green">&raquo; Nenhuma conta a pagar.</span>';
    } else if (value === 1) {
        return '<span class="red">&raquo; Existe ' + value + ' conta a ser paga.</span>';
    } else if (value > 1) {
        return '<span class="red">&raquo; Existem ' + value + ' contas a serem pagas.</span>';
    }
    return '<span class="gray">&raquo; Nenhuma conta cadastrada.</span>';
});
