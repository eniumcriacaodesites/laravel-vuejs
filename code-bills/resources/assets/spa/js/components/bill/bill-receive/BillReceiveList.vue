<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Minhas contas a receber</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <search @on-submit="filter" :model.sync="search"></search>
                <table class="bordered striped highlight responsive-table">
                    <thead>
                    <tr>
                        <th v-for="(key, o) in table.headers" :width="o.width" :class="o.class">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{ o.label }}
                                <i class="material-icons right" v-if="searchOptions.order.key == key">
                                    {{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                </i>
                            </a>
                        </th>
                        <th width="5%">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index, o) in bills">
                        <td>{{ o.id }}</td>
                        <td>{{ o.date_due | dateFormat }}</td>
                        <td>{{ o.name }}</td>
                        <td class="right-align">{{ o.value | numberFormat true }}</td>
                        <td class="center-align">
                            <a href="#" @click.prevent="openModalDone(o)">{{{ o.done | doneLabel }}}</a>
                        </td>
                        <td nowrap="nowrap">
                            <a href="#" @click.prevent="openModalEdit(index)">Editar</a> |
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="searchOptions.pagination.current_page"
                            :per-page="searchOptions.pagination.per_page"
                            :total-records="searchOptions.pagination.total"></pagination>
            </div>

            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" @click.prevent="openModalCreate()">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
    </div>

    <bill-receive-create :modal-options="modalCreate"></bill-receive-create>
    <bill-receive-update :modal-options="modalEdit" :index="indexUpdate"></bill-receive-update>

    <modal :modal="modalDelete">
        <div slot="content" v-if="billReceiveDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja excluir esta conta?</strong></p>
            <table class="bordered">
                <tr>
                    <td>Data:</td>
                    <td>{{ billReceiveDelete.date_due | dateFormat }}</td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td>{{ billReceiveDelete.name }}</td>
                </tr>
                <tr>
                    <td>Valor:</td>
                    <td>{{ billReceiveDelete.value | numberFormat true }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok modal-close modal-action" @click="destroy()">Ok</button>
        </div>
    </modal>
    <modal :modal="modalDone">
        <div slot="content" v-if="billReceiveDone">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja alterar o status desta conta?</strong></p>
            <table class="bordered">
                <tr>
                    <td>Data:</td>
                    <td>{{ billReceiveDone.date_due | dateFormat }}</td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td>{{ billReceiveDone.name }}</td>
                </tr>
                <tr>
                    <td>Valor:</td>
                    <td>{{ billReceiveDone.value | numberFormat true }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok modal-close modal-action" @click="done()">Ok</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../../_default/components/Modal.vue';
    import PaginationComponent from '../../Pagination.vue';
    import PageTitleComponent from '../../PageTitle.vue';
    import SearchComponent from '../../Search.vue';
    import BillReceiveCreateComponent from './BillReceiveCreate.vue';
    import BillReceiveUpdateComponent from './BillReceiveUpdate.vue';
    import store from '../../../store/store';

    export default {
        components: {
            modal: ModalComponent,
            pagination: PaginationComponent,
            pageTitle: PageTitleComponent,
            search: SearchComponent,
            billReceiveCreate: BillReceiveCreateComponent,
            billReceiveUpdate: BillReceiveUpdateComponent
        },
        data() {
            return {
                modalDelete: {
                    id: 'modal-delete'
                },
                modalCreate: {
                    id: 'modal-create'
                },
                modalEdit: {
                    id: 'modal-edit'
                },
                modalDone: {
                    id: 'modal-done'
                },
                indexUpdate: 0,
                table: {
                    headers: {
                        id: {
                            label: '#',
                            width: '5%'
                        },
                        date_due: {
                            label: 'Data',
                            width: '10%'
                        },
                        name: {
                            label: 'Nome',
                            width: '40%'
                        },
                        value: {
                            label: 'Valor',
                            width: '10%',
                            'class': 'right-align'
                        },
                        done: {
                            label: 'Recebeu?',
                            width: '10%',
                            'class': 'center-align'
                        }
                    }
                }
            };
        },
        computed: {
            bills() {
                return store.state.billReceive.bills;
            },
            searchOptions() {
                return store.state.billReceive.searchOptions;
            },
            search: {
                get() {
                    return store.state.billReceive.searchOptions.search;
                },
                set(value) {
                    store.commit('billReceive/setFilter', value);
                }
            },
            billReceiveDelete() {
                return store.state.billReceive.billDelete;
            },
            billReceiveDone() {
                return store.state.billReceive.billDelete;
            }
        },
        created() {
            store.dispatch('billReceive/query');
            store.dispatch('bankAccount/lists');
            store.dispatch('categoryRevenue/query');
        },
        methods: {
            destroy() {
                store.dispatch('billReceive/delete').then((response) => {
                    Materialize.toast('Conta excluída com sucesso!', 4000);
                });
            },
            done() {
                store.dispatch('billReceive/done').then((response) => {
                    Materialize.toast('Conta alterada com sucesso!', 4000);
                });
            },
            openModalCreate() {
                $('#modal-create').modal('open');
            },
            openModalEdit(index) {
                this.indexUpdate = index;
                $('#modal-edit').modal('open');
            },
            openModalDelete(billReceive) {
                store.commit('billReceive/setDelete', billReceive);
                $('#modal-delete').modal('open');
            },
            openModalDone(billReceive) {
                store.commit('billReceive/setDelete', billReceive);
                $('#modal-done').modal('open');
            },
            sortBy(key) {
                store.dispatch('billReceive/queryWithSortBy', key);
            },
            filter() {
                store.dispatch('billReceive/queryWithFilter');
            }
        },
        events: {
            'pagination::changed'(page) {
                store.dispatch('billReceive/queryWithPagination', page);
            }
        }
    };
</script>
