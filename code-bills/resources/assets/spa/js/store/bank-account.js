import {BankAccountResource} from "../services/resource";
import SearchOptions from "../services/search-options";
import _ from "lodash";

const state = {
    lists: [],
    bankAccounts: [],
    bankAccountDelete: null,
    searchOptions: new SearchOptions('bank'),
};

const mutations = {
    set(state, bankAccounts) {
        state.bankAccounts = bankAccounts;
    },
    setLists(state, lists) {
        state.lists = lists;
    },
    setDelete(state, bankAccount) {
        state.bankAccountDelete = bankAccount;
    },
    'delete'(state) {
        state.bankAccounts.$remove(state.bankAccountDelete);
    },
    setOrder(state, key) {
        state.searchOptions.order.key = key;
        state.searchOptions.order.sort = (state.searchOptions.order.sort == 'desc') ? 'asc' : 'desc';
    },
    setSort(state, sort) {
        state.searchOptions.order.sort = sort;
    },
    setLimit(state, limit) {
        state.searchOptions.limit = limit;
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
    lists(context) {
        return BankAccountResource.lists().then((response) => {
            context.commit('setLists', response.data);
        });
    },
    query(context) {
        return BankAccountResource.query(context.state.searchOptions.createOptions())
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
    'delete'(context) {
        return BankAccountResource.delete({id: context.state.bankAccountDelete.id})
            .then((response) => {
                context.commit('delete');
                context.commit('setDelete', null);

                let bankAccounts = context.state.bankAccounts;
                let pagination = context.state.searchOptions.pagination;

                if (bankAccounts.length === 0 && pagination.current_page > 0) {
                    context.commit('setCurrentPage', pagination.current_page--);
                }

                return response;
            });
    },
    find(context, bankId) {
        return BankAccountResource.get({id: bankId, include: 'bank'}).then((response) => {
            return response;
        });
    },
    save(context, bankAccount) {
        if (bankAccount.id !== undefined) { // updating
            BankAccountResource.update({id: bankAccount.id}, bankAccount).then((response) => {
                return response;
            });
        } else { // creating
            return BankAccountResource.save({}, bankAccount.toJSON()).then((response) => {
                return response;
            });
        }
    }
};

const getters = {
    filterBankAccountByName: (state) => (name) => {
        let bankAccounts = _.filter(state.lists, (o) => {
            return _.includes(o.name.toLowerCase(), name.toLowerCase());
        });

        return bankAccounts;
    },
    mapBankAccounts: (state, getters) => (name) => {
        let bankAccounts = getters.filterBankAccountByName(name);

        return bankAccounts.map((o) => {
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
