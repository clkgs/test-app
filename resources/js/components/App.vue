<template>
    <div>
        <nav class='navbar'>
            <div class='container-fluid'>
                <span class='navbar-brand h1'>Blog</span>
            </div>
        </nav>
        <div class='container'>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'App',
    props: {
        perPage: {
            type: Number,
            default: 20,
        },
        page: {
            type: Number,
            default: 1,
        },
    },
    mounted() {
        let categoryId = null
        let search = ''

        if (typeof this.$route.params.categoryId !== 'undefined') {
            categoryId = this.$route.params.categoryId
        }
        if (typeof this.$route.query.search !== 'undefined') {
            search = this.$route.query.search
        }

        this.setCategoryId({ categoryId })
        this.setSearch({ search })
        this.fetchCategories()
        this.fetchArticles()
    },
    methods: {
        ...mapActions([
            'setCategoryId',
            'setSearch',
            'fetchArticles',
            'fetchCategories',
        ]),
    },
}
</script>
