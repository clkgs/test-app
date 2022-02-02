<?php

namespace App\Http\API\V1\Controllers;

use App\Http\API\Requests\PaginateRequest;
use App\Services\CategoryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryController
{
    /**
     * @param PaginateRequest $paginateRequest
     * @param CategoryService $categoryService
     *
     * @return array|LengthAwarePaginator
     */
    public function index(PaginateRequest $paginateRequest, CategoryService $categoryService)
    {
        try {
            return $categoryService->list(
                $paginateRequest->page ?? 1,
                $paginateRequest->perPage ?? 20,
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
