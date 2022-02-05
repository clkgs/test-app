<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    /** @test */
    public function request_without_parameters_return_correct_results(): void
    {
        $this->postJson('api/v1/articles')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'subtitle',
                        'slug',
                        'categories' => [
                            '*' => [
                                'id',
                                'name',
                                'pivot' => [
                                    'article_id',
                                    'category_id',
                                    'is_primary',
                                ],
                            ],
                        ],
                        'contents' => [
                            '*' => [
                                'article_id',
                                'content',
                            ],
                        ],
                        'medias',
                    ],
                ],
            ]);
    }

    /** @test */
    public function request_with_category_id_return_articles_from_category(): void
    {
        $category = Category::query()
            ->first('id');

        $response = $this->postJson('api/v1/articles', [
            'category_id' => $category->getKey(),
            'perPage' => 1,
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $article = $response->decodeResponseJson()['data'][0];
        $categories = Arr::pluck($article, 'categories.*.id');

        $this->assertIsArray($categories, $category->getKey());
    }

    /** @test */
    public function request_with_search_find_article_title(): void
    {
        $search = 'China';

        $response = $this->postJson('api/v1/articles', [
            'search' => $search,
            'perPage' => 1,
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $article = $response->decodeResponseJson()['data'][0];

        $this->assertStringContainsString($search, $article['title']);
    }

    /** @test */
    public function request_with_search_find_article_content(): void
    {
        $search = 'CRISPR';

        $response = $this->postJson('api/v1/articles', [
            'search' => $search,
            'perPage' => 1,
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1, 'data');

        $article = $response->decodeResponseJson()['data'][0];

        $this->assertStringContainsString($search, $article['contents'][0]['content']);
    }
}
