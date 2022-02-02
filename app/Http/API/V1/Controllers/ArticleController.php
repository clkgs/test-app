<?php

namespace App\Http\API\V1\Controllers;


use App\Http\API\Requests\V1\Article\FilterArticleRequest;
use App\Services\ArticleService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ArticleController
{
    /**
     * @param FilterArticleRequest $request
     * @param ArticleService $articleService
     *
     * @return array|LengthAwarePaginator
     */
    public function index(FilterArticleRequest $request, ArticleService $articleService)
    {
        try {
            return $articleService->list(
                $request->categoryId,
                $request->search,
                $request->page ?? 1,
                $request->perPage ?? 20,
            );
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'error',
                'error' => 'Internal server error',
            ];
        }
    }
}
