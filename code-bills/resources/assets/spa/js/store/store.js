import Vuex from "vuex";
import auth from "./auth";
import bank from "./bank";
import bankAccount from "./bank-account";

export default new Vuex.Store({
    modules: {
        auth, bank, bankAccount
    }
});
