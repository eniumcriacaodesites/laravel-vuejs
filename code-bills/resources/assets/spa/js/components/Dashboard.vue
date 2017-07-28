<template>
    <div class="container">
        <div class="row">
            <div class="col s8">
                <!-- left -->
            </div>
            <div class="col s4">
                <!-- right -->
                <div class="card-panel z-depth-2">
                    <ul class="collection">
                        <li class="collection-item avatar" v-for="o in bankAccounts">
                            <img :src="o.bank.data.logo" :alt="o.bank.data.name" class="circle z-depth-1">
                            <span class="title"><strong>{{ o.name }}</strong></span>
                            <p>{{{ o.balance | currencyFormat }}}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from "../store/store";

    export default {
        computed: {
            bankAccounts() {
                return store.state.bankAccount.bankAccounts;
            }
        },
        created() {
            store.commit('bankAccount/setOrder', 'balance');
            store.commit('bankAccount/setSort', 'desc');
            store.commit('bankAccount/setLimit', 5);
            store.dispatch('bankAccount/query');
        }
    }
</script>

<style type="text/css" scoped>
    .collection, .collection-item {
        border: none;
    }
</style>
