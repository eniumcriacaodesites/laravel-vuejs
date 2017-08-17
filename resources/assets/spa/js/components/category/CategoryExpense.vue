<template>
    <div>
        <category-tree :categories="categories"></category-tree>

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
    </div>
</template>

<script type="text/javascript">
    import categoryMixin from '../../mixins/category-mixin';

    export default {
        mixins: [categoryMixin],
        methods: {
            namespace() {
                return 'categoryExpense';
            }
        }
    }
</script>
