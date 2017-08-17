import SearchOptions from "../services/search-options";

export default () => {

    const include = 'category,bankAccount';

    const state = {
        bills: [],
        billData: {
            total_paid: 0,
            total_to_pay: 0,
            total_expired: 0
        },
        billDelete: null,
        resource: null,
        searchOptions: new SearchOptions(include),
        total_today: 0,
        total_rest_of_month: 0
    };

    const mutations = {
        set(state, bills) {
            state.bills = bills;
        },
        setBillData(state, billData) {
            state.billData = billData;
        },
        setTotalToday(state, totalToday) {
            state.total_today = totalToday;
        },
        setTotalRestOfMonth(state, totalRestOfMonth) {
            state.total_rest_of_month = totalRestOfMonth;
        },
        setDelete(state, bill) {
            state.billDelete = bill;
        },
        update(state, {index, bill}) {
            state.bills.$set(index, bill);
        },
        'delete'(state) {
            state.bills.$remove(state.billDelete);
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
        totalToday(context) {
            return context.state.resource.totalToday().then((response) => {
                context.commit('setTotalToday', response.data.total);
            });
        },
        totalRestOfMonth(context) {
            return context.state.resource.totalRestOfMonth().then((response) => {
                context.commit('setTotalRestOfMonth', response.data.total);
            });
        },
        query(context) {
            return context.state.resource.query(context.state.searchOptions.createOptions())
                .then((response) => {
                    context.commit('set', response.data.data.bills.data);
                    context.commit('setPagination', response.data.data.bills.meta.pagination);
                    context.commit('setBillData', response.data.data.bill_data);
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
            return context.state.resource.delete({id: context.state.billDelete.id})
                .then((response) => {
                    context.commit('delete');
                    context.commit('setDelete', null);

                    let bills = context.state.bills;
                    let pagination = context.state.searchOptions.pagination;

                    if (bills.length === 0 && pagination.current_page > 0) {
                        context.commit('setCurrentPage', pagination.current_page--);
                    }

                    return response;
                });
        },
        save(context, bill) {
            return context.state.resource.save({}, bill.toJSON()).then((response) => {
                context.dispatch('query');
                return response;
            });
        },
        edit(context, {index, bill}) {
            return context.state.resource.update({id: bill.id, include: include}, bill.toJSON()).then((response) => {
                context.commit('update', {index, bill: response.data.data});
                return response;
            });
        },
        done(context) {
            let bill = context.state.billDelete;
            bill.done = !bill.done;

            return context.state.resource.update({id: bill.id, include: include}, bill).then((response) => {
                context.dispatch('query');
                return response;
            });
        }
    };

    const getters = {
        billByIndex: (state) => (index) => {
            return state.bills[index];
        }
    };

    const module = {
        namespaced: true, state, mutations, actions, getters
    };

    return module;
}
