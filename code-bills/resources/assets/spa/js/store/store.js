import Vuex from "vuex";
import auth from "./auth";
import bank from "./bank";
import bankAccount from "./bank-account";
import categoryModule from "./category";
import billModule from "./bill";
import {
    BillPayResource,
    BillReceiveResource,
    CategoryExpenseResource,
    CategoryRevenueResource
} from "../services/resource";

let categoryRevenue = categoryModule(), categoryExpense = categoryModule();
categoryRevenue.state.resource = CategoryRevenueResource;
categoryExpense.state.resource = CategoryExpenseResource;

let billPay = billModule(), billReceive = billModule();
billPay.state.resource = BillPayResource;
billReceive.state.resource = BillReceiveResource;

export default new Vuex.Store({
    modules: {
        auth,
        bank,
        bankAccount,
        categoryRevenue,
        categoryExpense,
        billPay,
        billReceive,
    }
});
