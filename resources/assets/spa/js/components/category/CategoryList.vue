<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Administração de categorias</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab">
                                <a href="#test1" @click="getCategories('revenue')" class="active">Categorias de
                                    Receita</a>
                            </li>
                            <li class="tab">
                                <a href="#test2" @click="getCategories('expense')">Categorias de Despesa</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div id="test1" class="col s12"> &raquo; Administrar categorias de receita</div>
                    <div id="test2" class="col s12"> &raquo; Administrar categorias de despesa</div>
                </div>
                <category-tree :categories="categories"></category-tree>
            </div>

            <category-save :modal-options="modalOptionsSave"
                           :category.sync="categorySave"
                           :cp-options="cpOptions"
                           @save-category="saveCategory()">
                <div slot="title">{{ title }}</div>
                <div slot="footer">
                    <button type="button" class="btn-cancel modal-close modal-action">Cancelar</button>
                    <button type="submit" class="btn-ok modal-close modal-action">Salvar</button>
                </div>
            </category-save>

            <modal :modal="modalOptionsDelete">
                <div slot="content" v-if="categoryDelete">
                    <h4>Deseja excluir esta categoria?</h4>
                    <table class="bordered">
                        <tr>
                            <td>Nome:</td>
                            <td>{{ categoryDelete.name }}</td>
                        </tr>
                    </table>
                </div>
                <div slot="footer">
                    <button type="button" class="btn-cancel modal-close modal-action">Cancelar</button>
                    <button class="btn-ok modal-close modal-action" @click="destroy()">Ok</button>
                </div>
            </modal>

            <div class="fixed-action-btn">
                <button class="btn-floating btn-large" @click="modalNew(null)">
                    <i class="large material-icons">add</i>
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoryTreeComponent from './CategoryTree.vue';
    import CategorySaveComponent from './CategorySave.vue';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import {CategoryFormat, CategoryService} from '../../services/category-nsm';

    export default {
        components: {
            pageTitle: PageTitleComponent,
            categoryTree: CategoryTreeComponent,
            categorySave: CategorySaveComponent,
            modal: ModalComponent
        },
        data() {
            return {
                title: '',
                resource: null,
                parent: null,
                category: null,
                categoryDelete: null,
                categories: [],
                categoriesFormatted: [],
                categorySave: {
                    id: 0,
                    name: '',
                    parent_id: 0
                },
                modalOptionsSave: {
                    id: 'modal-category-save'
                },
                modalOptionsDelete: {
                    id: 'modal-category-delete'
                },
                selected: 0
            };
        },
        created() {
            this.getCategories();
        },
        computed: {
            // opções para o campo select 2 de categoria pai
            cpOptions() {
                return {
                    data: this.categoriesFormatted,
                    templateResult(category) {
                        let margin = '&nbsp;'.repeat(category.level * 6);
                        let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;

                        return `${margin}${text}`;
                    },
                    escapeMarkup(m) {
                        return m;
                    }
                };
            }
        },
        methods: {
            getCategories(type = 'revenue') {
                this.resource = new CategoryService(type);

                this.resource.query().then(response => {
                    this.categories = response.data.data;
                    this.formatCategories();
                    $('ul.tabs').tabs();
                });
            },
            saveCategory() {
                this.resource.save(this.categorySave, this.parent, this.categories, this.category)
                    .then(response => {
                        if (this.categorySave.id === 0) {
                            Materialize.toast('Categoria adicionada com sucesso!', 4000);
                        } else {
                            Materialize.toast('Categoria atualizada com sucesso!', 4000);
                        }

                        this.resetScope();
                    });
            },
            destroy() {
                this.resource.destroy(this.categoryDelete, this.parent, this.categories)
                    .then(response => {
                        Materialize.toast('Categoria excluída com sucesso!', 4000);
                        this.resetScope();
                    });
            },
            modalNew(category) {
                this.title = 'Nova categoria';
                this.categorySave = {
                    id: 0,
                    name: '',
                    parent_id: category === null ? null : category.id
                };

                this.parent = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category, parent) {
                this.title = 'Editar categoria';
                this.categorySave = {
                    id: category.id,
                    name: category.name,
                    parent_id: category.parent_id
                };

                this.parent = parent;
                this.category = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalDelete(category, parent) {
                this.categoryDelete = category;
                this.parent = parent;
                $(`#${this.modalOptionsDelete.id}`).modal('open');
            },
            formatCategories() {
                this.categoriesFormatted = CategoryFormat.getCategoriesFormatted(this.categories);
            },
            resetScope() {
                this.categorySave = {
                    id: 0,
                    name: '',
                    parent_id: 0
                };

                this.parent = null;
                this.category = null;
                this.categoryDelete = null;
                this.formatCategories();
            }
        },
        events: {
            'category-new'(category) {
                this.modalNew(category);
            },
            'category-edit'(category, parent) {
                this.modalEdit(category, parent);
            },
            'category-delete'(category, parent) {
                this.modalDelete(category, parent);
            }
        }
    };
</script>
