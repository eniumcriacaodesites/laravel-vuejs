Vue.filter('doneLabel', function (value) {
    return (value == 1) ? "Paga" : "Não paga";
});
