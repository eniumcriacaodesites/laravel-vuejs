import Vuex from "vuex";
import auth from "./auth";
import bank from "./bank";
import bankAccount from "./bank-account";
import categoryModule from "./category";
import {CategoryExpenseResource, CategoryRevenueResource} from "../services/resource";

let categoryRevenue = categoryModule(), categoryExpense = categoryModule();
categoryRevenue.state.resource = CategoryRevenueResource;
categoryExpense.state.resource = CategoryExpenseResource;

export default new Vuex.Store({
    modules: {
        auth,
        bank,
        bankAccount,
        categoryRevenue,
        categoryExpense,
    }
});
