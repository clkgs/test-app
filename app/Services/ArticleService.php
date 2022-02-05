<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Content;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleService
{
    /**
     * @param string|null $categoryId
     * @param string|null $search
     * @param int $page
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function list(?string $categoryId, ?string $search, int $page, int $perPage): LengthAwarePaginator
    {
        $query = Article::query()
            ->select([
                'articles.id',
                'articles.title',
                'articles.subtitle',
                'articles.slug',
            ])
            ->with([
                'categories' => function (BelongsToMany $query) {
                    $query->select([
                        'categories.id',
                        'categories.name',
                    ])
                        ->orderBy('categories.name');
                },
                'contents' => function (HasMany $query) {
                    $query->select([
                        'article_id',
                        'content',
                    ]);
                },
                'medias' => function (HasMany $query) {
                    $query->select([
                        'article_id',
                        'slug',
                        'attributes'
                    ]);
                },
            ])
            ->latest('published');

        if ($categoryId) {
            $query->leftJoin('article_category', 'articles.id', 'article_category.article_id')
                ->leftJoin('categories', 'article_category.category_id', 'categories.id')
                ->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereRaw('MATCH(`articles`.`title`) AGAINST (?)', [$search])
                    ->orWhereIn('articles.id', Content::query()
                        ->select('article_id')
                        ->whereRaw('MATCH(`content`) AGAINST (?)', [$search]));
            });
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
