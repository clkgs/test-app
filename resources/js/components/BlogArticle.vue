<template>
    <article>
        <h3 v-html='article.title'></h3>
        <h4 v-if='article.subtitle' v-html='article.subtitle'></h4>
        <div v-if='article.categories.length' class='mb-2'>
            <span
                class='badge me-1'
                :class='category.pivot.is_primary ? "bg-primary" : "bg-secondary"'
                v-for='category in article.categories'
                :key='category.id'>
                {{ category.name }}
            </span>
        </div>
        <div class='article-media' v-for='media in article.medias' :key='media.id'>
            <img :src='media.attributes.url' :alt='media.slug'>
        </div>
        <div class='article-no-media' v-if='!article.medias.length'>
            <svg class='article-placeholder-img' width='100%' height='180' xmlns='http://www.w3.org/2000/svg'
                 role='img' aria-label='Placeholder' preserveAspectRatio='xMidYMid slice' focusable='false'><title>
                Placeholder</title>
                <rect width='100%' height='100%' fill='#868e96'></rect>
            </svg>
        </div>
        <div
            class='article-content'
            v-for='content in article.contents'
            :key='content.id'
            v-html='content.content'>
        </div>
    </article>
</template>

<script>
export default {
    name: 'BlogArticle',
    props: {
        article: {
            type: Object,
            required: true,
        },
    },
}
</script>

<style scoped lang='scss'>
.article-media {
    img {
        max-height: 10rem;
    }
}
</style>
