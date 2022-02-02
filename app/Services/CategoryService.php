<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    /**
     * @param int $page
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function list(int $page, int $perPage): LengthAwarePaginator
    {
        return Category::query()
            ->select([
                'id',
                'name',
            ])
            ->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
