import {StatementResource} from "../services/resource";
import SearchOptions from "../services/search-options";

const state = {
    statements: [],
    searchOptions: new SearchOptions(),
};

const mutations = {
    set(state, statements) {
        state.statements = statements;
    },
    setOrder(state, key) {
        state.searchOptions.order.key = key;
        state.searchOptions.order.sort = (state.searchOptions.order.sort == 'desc') ? 'asc' : 'desc';
    },
    setPagination(state, pagination) {
        state.searchOptions.pagination = pagination;
    },
    setCurrentPage(state, currentPage) {
        state.searchOptions.pagination.current_page = currentPage;
    },
    setFilter(state, filter) {
        state.searchOptions.search = filter;
    }
};

const actions = {
    query(context) {
        return StatementResource.query(context.state.searchOptions.createOptions())
            .then((response) => {
                context.commit('set', response.data.data);
                context.commit('setPagination', response.data.meta.pagination);
            });
    },
    queryWithSortBy(context, key) {
        context.commit('setOrder', key);
        context.dispatch('query');
    },
    queryWithPagination(context, currentPage) {
        context.commit('setCurrentPage', currentPage);
        context.dispatch('query');
    },
    queryWithFilter(context) {
        context.dispatch('query');
    },
};

const getters = {
    filterBankAccountByName: (state) => (name) => {
        let statements = _.filter(state.lists, (o) => {
            return _.includes(o.name.toLowerCase(), name.toLowerCase());
        });

        return statements;
    },
    mapBankAccounts: (state, getters) => (name) => {
        let statements = getters.filterBankAccountByName(name);

        return statements.map((o) => {
            return {id: o.id, text: getters.textAutocomplete(o)};
        });
    },
    textAutocomplete: (state) => (bankAccount) => {
        return `${bankAccount.name} - ${bankAccount.account}`;
    }
};

const module = {
    namespaced: true, state, mutations, actions, getters
};

export default module;
