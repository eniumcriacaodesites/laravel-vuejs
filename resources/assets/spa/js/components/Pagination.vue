<template>
    <ul class="pagination">
        <li :class="{'disabled': currentPage < 1}">
            <a @click.prevent="prevPage()">
                <i class="material-icons">chevron_left</i>
            </a>
        </li>

        <li v-for="o in pages" class="waves-effect" :class="{'active': currentPage == o}">
            <a @click.prevent="setCurrentPage(o)">{{ o + 1 }}</a>
        </li>

        <li :class="{'disabled': currentPage == pages - 1}">
            <a @click.prevent="nextPage()">
                <i class="material-icons">chevron_right</i>
            </a>
        </li>
        <li></li>
    </ul>
</template>

<script type="text/javascript">
    export default {
        props: {
            currentPage: {
                type: Number,
                'default': 0
            },
            perPage: {
                type: Number,
                required: true
            },
            totalRecords: {
                type: Number,
                required: true
            }
        },
        computed: {
            pages() {
                let pages = Math.ceil(this.totalRecords / this.perPage);
                return Math.max(pages, 1);
            }
        },
        methods: {
            prevPage() {
                if (this.currentPage > 0) {
                    this.currentPage--;
                }
            },
            nextPage() {
                if (this.currentPage < this.pages - 1) {
                    this.currentPage++;
                }
            },
            setCurrentPage(page) {
                this.currentPage = page;
            }
        },
        watch: {
            currentPage(newValue) {
                this.$dispatch('pagination::changed', newValue);
            }
        }
    }
</script>
