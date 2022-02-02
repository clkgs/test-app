import qs from 'qs'

const articlesListUrl = '/api/v1/articles'
const categoriesListUrl = '/api/v1/categories'

export const client = {
    articlesList({ categoryId, search, page, perPage }) {
        return axios.post(articlesListUrl + '?' + qs.stringify({ page, perPage }), { categoryId, search })
    },
    categoriesList({ page, perPage }) {
        return axios.get(categoriesListUrl + '?' + qs.stringify({ page, perPage }))
    },
}
