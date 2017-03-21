<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Administração de categorias</h5>
            </page-title>

            <div class="card-panel z-depth-2">
                <category-tree :categories="categories"></category-tree>
            </div>

            <category-save :modal-options="modalOptionsSave"
                           :category.sync="categorySave"
                           @save-category="saveCategory()">
                <div slot="title">{{ title }}</div>
                <div slot="footer">
                    <button type="submit" class="btn btn-flat waves-effect blue lighten-2 modal-close modal-action">
                        OK
                    </button>
                    <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
                </div>
            </category-save>
        </div>
    </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoryTreeComponent from './CategoryTree.vue';
    import CategorySaveComponent from './CategorySave.vue';
    import {CategoryResource} from '../../services/resource';

    export default {
        components: {
            pageTitle: PageTitleComponent,
            categoryTree: CategoryTreeComponent,
            categorySave: CategorySaveComponent
        },
        data() {
            return {
                title: 'Adicionar categoria',
                categories: [],
                categorySave: {
                    id: 0,
                    name: '',
                    parent_id: 0
                },
                modalOptionsSave: {
                    id: 'modal-category-save'
                },
                selected: 0
            };
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                CategoryResource.query().then(response => {
                    this.categories = response.data.data;
                });
            },
            saveCategory() {
                console.log('ok!!!');
            },
            modalNew(category) {
                this.categorySave = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category) {
                console.log(category);
            },
            modalDelete(category) {
                console.log(category);
            }
        },
        events: {
            'category-new'(category) {
                this.modalNew(category);
                console.log('category-new');
            },
            'category-edit'(category) {
                this.modalEdit(category);
                console.log('category-edit');
            },
            'category-delete'(category) {
                this.modalDelete(category);
                console.log('category-delete');
            },
        }
    };
</script>
