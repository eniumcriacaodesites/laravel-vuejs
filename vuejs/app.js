var app = new Vue({
    el: "#app",
    data: {
        title: "Contas a pagar",
        bills: [
            {date_due: '11/08/16', name: 'Água', value: 55.99},
            {date_due: '11/08/16', name: 'Energia', value: 130.95},
            {date_due: '15/08/16', name: 'Telefone', value: 75.95},
            {date_due: '15/08/16', name: 'Cartão de crédito', value: 1350.85},
            {date_due: '20/08/16', name: 'Empréstino', value: 2000.15},
            {date_due: '20/08/16', name: 'Supermecado', value: 650.45},
            {date_due: '20/08/16', name: 'Gasolina', value: 150.25},
        ]
    }
});