import {CashFlow} from "../services/resource";
import moment from "moment";

const state = {
    cashFlows: null,
    cashFlowsMonthly: null,
    firstPeriod: null,
};

const mutations = {
    set(state, cashFlows) {
        state.cashFlows = cashFlows;
    },
    setMonthly(state, cashFlowsMonthly) {
        state.cashFlowsMonthly = cashFlowsMonthly;
    },
    setFirstPeriod(state, date) {
        state.firstPeriod = moment(date)
            .startOf('day')
            .subtract(1, 'months')
            .format('YYYY-MM');
    }
};

const actions = {
    query(context) {
        return CashFlow.query().then((response) => {
            context.commit('set', response.data);
        });
    },
    monthly(context) {
        return CashFlow.monthly().then((response) => {
            context.commit('setMonthly', response.data);
        });
    }
};

const getters = {
    indexSecondPeriod(state, getters) {
        return getters.hasFirstPeriod ? 1 : 0;
    },
    filterPeriod: (state) => (period) => {
        if (state.cashFlows.hasOwnProperty('period_list')) {
            return state.cashFlows.period_list.filter((item) => {
                return item.period == period;
            });
        }

        return [];
    },
    hasFirstPeriod(state, getters) {
        return getters.filterPeriod(state.firstPeriod).length > 0;
    },
    firstBalance(state, getters) {
        let balanceBeforeFirstMonth = state.cashFlows.balance_before_first_month;
        let balanceFirstMonth = 0;

        if (getters.hasFirstPeriod) {
            let firstPeriod = getters.filterPeriod(state.firstPeriod);
            balanceFirstMonth = firstPeriod[0].revenues.total - firstPeriod[0].expenses.total;
        }

        return balanceBeforeFirstMonth + balanceFirstMonth;
    },
    secondBalance(state, getters) {
        let firstBalance = getters.firstBalance;
        let indexSecondMonth = getters.indexSecondPeriod;
        let secondPeriod = state.cashFlows.period_list[indexSecondMonth].period;
        let secondMonthObj = getters.filterPeriod(secondPeriod)[0];

        return firstBalance + secondMonthObj.revenues.total - secondMonthObj.expenses.total;
    },
    periodsListBalanceFinal(state, getters) {
        let length = state.cashFlows.period_list.length;

        return state.cashFlows.period_list.slice(getters.indexSecondPeriod + 1, length);
    },
    periodsListBalancePrevious(state, getters) {
        let length = state.cashFlows.period_list.length;

        return state.cashFlows.period_list.slice(getters.indexSecondPeriod + 2, length);
    },
    hasCashFlows(state) {
        return state.cashFlows != null && state.cashFlows.period_list.length > 1;
    },
    hasCashFlowsMonthly(state) {
        return state.cashFlowsMonthly != null && state.cashFlowsMonthly.period_list.length > 1;
    },
    balance: (state, getters) => (index) => {
        return getters._calculateBalance(index + getters.indexSecondPeriod + 1);
    },
    _calculateBalance: (state, getters) => (index) => {
        let indexSecondMonth = getters.indexSecondPeriod;
        let previousIndex = index - 1;
        let previousBalance = 0;

        switch (previousIndex) {
            case 0:
                previousBalance = indexSecondMonth === 0 ? getters.secondBalance : getters.firstBalance;
                break;
            case 1:
                previousBalance = indexSecondMonth === 1 ? getters.secondBalance : getters._calculateBalance(previousIndex);
                break;
            default:
                previousBalance = getters._calculateBalance(previousIndex);
        }

        let period = state.cashFlows.period_list[index].period;
        let monthObj = getters.filterPeriod(period)[0];

        return previousBalance + monthObj.revenues.total - monthObj.expenses.total;
    },
    categoryTotal: (state, getters) => (category, period) => {
        let periodResult = category.periods.filter(item => {
            return item.period === period;
        });

        return periodResult.length === 0 ? {total: ""} : periodResult[0];
    }
};

const module = {
    namespaced: true, state, mutations, actions, getters
};

export default module;
