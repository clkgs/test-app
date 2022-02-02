import Vue from 'vue'
import Vuex from 'vuex'
import { client } from '../api/client'

const state = {
        categoryId: null,
        search: '',
        page: 1,
        perPage: 20,
        categories: () => [],
        articles: () => [],
    },
    getters = {
        categoryId: (state) => state.categoryId,
        search: (state) => state.search,
        page: (state) => state.page,
        perPage: (state) => state.perPage,
        categories: (state) => state.categories,
        articles: (state) => state.articles,
    },
    actions = {
        setPage: ({ commit }, { page }) => {
            commit('setPage', page)
        },
        setCategoryId: ({ commit, dispatch, getters }, { categoryId }) => {
            commit('setCategoryId', categoryId)
        },
        setSearch: ({ commit, dispatch, getters }, { search }) => {
            commit('setSearch', search)
        },
        setCategories: ({ commit }, { categories }) => {
            commit('setCategories', categories)
        },
        setArticles: ({ commit }, { articles }) => {
            commit('setArticles', articles)
        },
        fetchCategories: ({ dispatch }) => {
            return client.categoriesList({
                page: 1,
                perPage: 100,
            }).then(response => {
                dispatch('setCategories', {
                    categories: response.data.data,
                })
            }).catch(error => console.log(error))
        },
        fetchArticles: ({ dispatch, getters }) => {
            return client.articlesList({
                page: getters.page,
                perPage: getters.perPage,
                search: getters.search,
                categoryId: getters.categoryId,
            }).then(response => dispatch('setArticles', {
                articles: response.data.data,
            })).catch(error => console.log(error))
        },
    },
    mutations = {
        setPage: (state, page) => Vue.set(state, 'page', page),
        setCategoryId: (state, categoryId) => Vue.set(state, 'categoryId', categoryId),
        setSearch: (state, search) => Vue.set(state, 'search', search),
        setCategories: (state, categories) => Vue.set(state, 'categories', categories),
        setArticles: (state, articles) => Vue.set(state, 'articles', articles),
    }

Vue.use(Vuex)

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
})
