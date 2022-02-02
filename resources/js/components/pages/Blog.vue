<template>
    <div>
        <blog-filter></blog-filter>
        <div class='articles-list' v-for='article in articles'>
            <blog-article
                :key='article.id'
                :article='article'></blog-article>
            <hr />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BlogArticle from '../BlogArticle'
import BlogFilter from '../BlogFilter'

export default {
    name: 'Blog',
    components: {
        BlogFilter,
        BlogArticle,
    },
    computed: {
        ...mapGetters([
            'articles',
        ]),
    },
}
</script>
