<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>{{ title }}</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <search @on-submit="filter" :model.sync="search"></search>
                <table class="bordered striped highlight responsive-table">
                    <thead>
                    <tr>
                        <th v-for="(key, o) in table.headers" :width="o.width">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{ o.label }}
                                <i class="material-icons right" v-if="order.key == key">
                                    {{ order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                </i>
                            </a>
                        </th>
                        <th width="5%">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index, o) in billReceives">
                        <td>{{ o.id }}</td>
                        <td>{{ o.date_due }}</td>
                        <td>{{ o.name }}</td>
                        <td>{{ o.value }}</td>
                        <td :class="{'bg-yes': o.done, 'bg-not': !o.done}">
                            <div v-if="o.done === 1">
                                <a href="#" @click.prevent="openModalReceive(o)">{{ o.done }}</a>
                            </div>
                            <div v-else>
                                <a href="#" @click.prevent="openModalReceive(o)">{{ o.done }}</a>
                            </div>
                        </td>
                        <td nowrap="nowrap">
                            <a v-link="{name: 'bill-receives.update', params: {id: o.id}}">Editar</a> |
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="pagination.current_page"
                            :per-page="pagination.per_page"
                            :total-records="pagination.total"></pagination>
            </div>
        </div>
    </div>
    <modal :modal="modalDelete">
        <div slot="content" v-if="billToDelete">
            <h4>Deseja excluir esta conta?</h4>
            <table class="bordered">
                <tr>
                    <td>Data:</td>
                    <td>{{ billToDelete.date_due }}</td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td>{{ billToDelete.name }}</td>
                </tr>
                <tr>
                    <td>Valor:</td>
                    <td>{{ billToDelete.value }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok  modal-close modal-action" @click="deleteBill()">Ok</button>
        </div>
    </modal>
    <modal :modal="modalReceive">
        <div slot="content" v-if="billToReceive">
            <h4>Deseja alterar o status desta conta?</h4>
            <table class="bordered">
                <tr>
                    <td>Data:</td>
                    <td>{{ billToReceive.date_due }}</td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td>{{ billToReceive.name }}</td>
                </tr>
                <tr>
                    <td>Valor:</td>
                    <td>{{ billToReceive.value }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok  modal-close modal-action" @click="receiveBill()">Ok</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../Pagination.vue';
    import {BillReceiveResource} from '../../services/resource';
    import PageTitleComponent from '../PageTitle.vue';
    import SearchComponent from '../Search.vue';

    export default {
        components: {
            modal: ModalComponent,
            pagination: PaginationComponent,
            pageTitle: PageTitleComponent,
            search: SearchComponent
        },
        data() {
            return {
                title: 'Minhas contas a receber',
                billReceives: [],
                billToDelete: null,
                billToReceive: null,
                modalDelete: {
                    id: 'modal-delete'
                },
                modalReceive: {
                    id: 'modal-receive'
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
                },
                search: '',
                order: {
                    key: 'id',
                    sort: 'asc'
                },
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
                            width: '15%'
                        },
                        done: {
                            label: 'Recebeu?',
                            width: '15%'
                        }
                    }
                }
            };
        },
        created() {
            this.getBillReceive();
        },
        methods: {
            deleteBill() {
                BillReceiveResource.delete({id: this.billToDelete.id}).then((response) => {
                    this.billReceives.$remove(this.billToDelete);
                    this.billToDelete = null;

                    if (this.billReceives.length === 0 && this.pagination.current_page > 0) {
                        this.pagination.current_page--;
                    }

                    Materialize.toast('Conta excluída com sucesso!', 4000);
                });
            },
            receiveBill() {
                this.billToReceive.done = !this.billToReceive.done;
                BillReceiveResource.update({id: this.billToReceive.id}, this.billToReceive).then((response) => {
                    Materialize.toast('Conta alterada com sucesso!', 4000);
                });
            },
            openModalDelete(bill) {
                this.billToDelete = bill;
                $('#modal-delete').modal();
                $('#modal-delete').modal('open');
            },
            openModalReceive(bill) {
                this.billToReceive = bill;
                $('#modal-receive').modal();
                $('#modal-receive').modal('open');
            },
            getBillReceive() {
                BillReceiveResource.query({
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search
                }).then((response) => {
                    this.billReceives = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key) {
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getBillReceive();
            },
            filter() {
                this.pagination.current_page = 0;
                this.getBillReceive();
            }
        },
        events: {
            'pagination::changed'(page) {
                this.getBillReceive();
            }
        }
    };
</script>
