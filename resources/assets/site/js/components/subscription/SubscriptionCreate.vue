<template>
    <div class="card-panel center">
    <span class="blue-grey-text text-darken-2">
        <h2>Concluir assinatura</h2>
    </span>
        <h4>{{ plan.name }}</h4>
        <p>{{ plan.description }}</p>
        <p>{{ plan.value | numberFormat true }}</p>
    </div>
    <div class="card-panel">
        <form id="subscription-form" method="POST" :action="action" @submit.prevent="submit">
            <input type="hidden" name="_token" :value="csrfToken">
            <input type="hidden" name="token_payment" :value="token_payment">
            <div class="row center">
                <h5>Forma de pagamento</h5>
                <div class="input-field col s6">
                    <input type="radio" v-model="payment_type" id="payment_type_bank_slip" value="bank_slip"
                           name="payment_type">
                    <label for="payment_type_bank_slip">Boleto</label>
                </div>
                <div class="input-field col s6">
                    <input type="radio" v-model="payment_type" id="payment_type_credit_card" value="credit_card"
                           name="payment_type">
                    <label for="payment_type_credit_card">Cartão de Crédito</label>
                </div>
            </div>
            <div v-if="payment_type == 'credit_card'">
                <p class="flow-text">Informe os dados do cartão de crédito para efetuar a assinatura</p>
                <div class="row">
                    <div class="input-field col s4">
                        <input type="text" id="number" v-model="credit_card.number">
                        <label for="number" class="active">Número do cartão</label>
                    </div>
                    <div class="input-field col s4">
                        <input type="text" id="cvv" v-model="credit_card.cvv">
                        <label for="cvv" class="active">Código de segurança</label>
                    </div>
                    <div class="input-field col s4">
                        <input type="text" id="expiration" v-model="credit_card.expiration" placeholder="MM/AA">
                        <label for="expiration" class="active">Data de expiração</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" id="first_name" v-model="credit_card.first_name">
                        <label for="first_name" class="active">Primeiro Nome</label>
                    </div>
                    <div class="input-field col s6">
                        <input type="text" id="last_name" v-model="credit_card.last_name">
                        <label for="last_name" class="active">Sobrenome</label>
                    </div>
                </div>
            </div>
            <div v-else>
                <p class="flow-text">Clique em assinar para gerar o boleto</p>
            </div>
            <div class="row">
                <div class="col s12">
                    <p class="center-align">
                        <button class="btn btn-large btn-default" @click="submit()">Assinar</button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: [
            'plan',
            'csrfToken',
            'action'
        ],
        data() {
            return {
                token_payment: null,
                payment_type: 'credit_card', // boleto - bank_slip
                credit_card: {
                    number: '4111111111111111',
                    cvv: '123',
                    expiration: '12/17',
                    first_name: 'Nome',
                    last_name: 'Sobrenome'
                }
            }
        },
        ready() {
            Iugu.setAccountID('63C332E29A1B44B386991BF2A6B96D43');
            Iugu.setTestMode(true);
            Iugu.setup();
        },
        methods: {
            submit() {
                if (this.payment_type === 'credit_card') {
                    let expirationArray = this.credit_card.expiration.split('/');
                    let creditCard = Iugu.CreditCard(
                        this.credit_card.number,
                        expirationArray[0],
                        expirationArray[1],
                        this.credit_card.first_name,
                        this.credit_card.last_name,
                        this.credit_card.cvv
                    );

                    let self = this;
                    Iugu.createPaymentToken(creditCard, response => {
                        if (response.errors) {
                            Materialize.toast('Erro ao processar cartão de crédito. Tente novamente!', 4000);
                        } else {
                            self.token_payment = response.id;
                            setTimeout(() => {
                                $('#subscription-form')[0].submit();
                            });
                        }
                    });
                } else {
                    $('#subscription-form')[0].submit();
                }
            }
        }
    };
</script>
