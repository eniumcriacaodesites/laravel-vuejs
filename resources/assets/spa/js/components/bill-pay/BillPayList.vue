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
                    <tr v-for="(index, o) in billPays">
                        <td>{{ o.id }}</td>
                        <td>{{ o.date_due }}</td>
                        <td>{{ o.name }}</td>
                        <td>{{ o.value }}</td>
                        <td :class="{'bg-yes': o.done, 'bg-not': !o.done}">
                            <div v-if="o.done === 1">
                                <a href="#" @click.prevent="openModalPay(o)">{{ o.done }}</a>
                            </div>
                            <div v-else>
                                <a href="#" @click.prevent="openModalPay(o)">{{ o.done }}</a>
                            </div>
                        </td>
                        <td nowrap="nowrap">
                            <a v-link="{name: 'bill-pays.update', params: {id: o.id}}">Editar</a> |
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
            <button class="btn-ok modal-close modal-action" @click="deleteBill()">Ok</button>
        </div>
    </modal>
    <modal :modal="modalPay">
        <div slot="content" v-if="billToPay">
            <h4>Deseja alterar o status desta conta?</h4>
            <table class="bordered">
                <tr>
                    <td>Data:</td>
                    <td>{{ billToPay.date_due }}</td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td>{{ billToPay.name }}</td>
                </tr>
                <tr>
                    <td>Valor:</td>
                    <td>{{ billToPay.value }}</td>
                </tr>
            </table>
        </div>
        <div slot="footer">
            <button class="btn-cancel modal-close modal-action">Cancel</button>
            <button class="btn-ok modal-close modal-action" @click="payBill()">Ok</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../Pagination.vue';
    import {BillPayResource} from '../../services/resource';
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
                title: 'Minhas contas a pagar',
                billPays: [],
                billToDelete: null,
                billToPay: null,
                modalDelete: {
                    id: 'modal-delete'
                },
                modalPay: {
                    id: 'modal-pay'
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
                            label: 'Pago?',
                            width: '15%'
                        }
                    }
                }
            };
        },
        created() {
            this.getBillPays();
        },
        methods: {
            deleteBill() {
                BillPayResource.delete({id: this.billToDelete.id}).then((response) => {
                    this.billPays.$remove(this.billToDelete);
                    this.billToDelete = null;

                    if (this.billPays.length === 0 && this.pagination.current_page > 0) {
                        this.pagination.current_page--;
                    }

                    Materialize.toast('Conta excluída com sucesso!', 4000);
                });
            },
            payBill() {
                this.billToPay.done = !this.billToPay.done;
                BillPayResource.update({id: this.billToPay.id}, this.billToPay).then((response) => {
                    Materialize.toast('Conta alterada com sucesso!', 4000);
                });
            },
            openModalDelete(bill) {
                this.billToDelete = bill;
                $('#modal-delete').modal();
                $('#modal-delete').modal('open');
            },
            openModalPay(bill) {
                this.billToPay = bill;
                $('#modal-pay').modal();
                $('#modal-pay').modal('open');
            },
            getBillPays() {
                BillPayResource.query({
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search
                }).then((response) => {
                    this.billPays = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key) {
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getBillPays();
            },
            filter() {
                this.pagination.current_page = 0;
                this.getBillPays();
            }
        },
        events: {
            'pagination::changed'(page) {
                this.getBillPays();
            }
        }
    };
</script>
