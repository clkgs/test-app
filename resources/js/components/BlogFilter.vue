<template>
    <div>
        <div class='row mb-3'>
            <label for='filter-category' class='col-sm-2 col-form-label'>Category</label>
            <div class='col-sm-6'>
                <select
                    class='form-select'
                    id='filter-category'
                    v-model='category'
                >
                    <option :value='null'>All</option>
                    <option
                        v-for='category in categories'
                        :key='category.id'
                        :value='category.id'
                    >{{ category.name }}
                    </option>
                </select>
            </div>
        </div>
        <div class='row mb-3'>
            <label for='filter-search' class='col-sm-2 col-form-label'>Search</label>
            <div class='col-sm-6'>
                <input
                    class='form-control'
                    id='filter-search'
                    placeholder='Type to search...'
                    v-model='searchValue'
                >
            </div>
            <div class='col-sm-2'>
                <button
                    class='btn btn-secondary'
                    :disabled='searchDisabled'
                    @click='applySearch'>Search
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'BlogFilter',
    computed: {
        ...mapGetters([
            'categories',
            'categoryId',
            'search',
        ]),
        category: {
            get() {
                return this.categoryId
            },
            set(value) {
                this.setCategoryId({ categoryId: value })
            },
        },
        searchValue: {
            get() {
                return this.search
            },
            set(value) {
                this.setSearch({ search: value })
            },
        },
        searchDisabled() {
            return this.search.length > 0 && this.search.length < 3
        }
    },
    mounted() {
        this.searchValue = this.search
    },
    methods: {
        ...mapActions([
            'setCategoryId',
            'setSearch',
            'fetchArticles',
        ]),
        applySearch() {
            this.updateRoute()
            this.fetchArticles()
        },
        updateRoute() {
            const { categoryId, search } = this

            this.$router.push({
                name: categoryId ? 'category-blog' : 'blog',
                params: categoryId ? { categoryId } : {},
                query: search ? { search } : {},
            }).catch(() => {})
        },
    },
}
</script>
