<?php

namespace App\Http\API\Requests\V1\Article;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property string $categoryId
 * @property string $search
 * @property int $page
 * @property int $perPage
 */
class FilterArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'categoryId' => 'nullable|uuid',
            'search' => 'nullable|string|min:3',
            'page' => 'integer|min:1',
            'perPage' => 'integer|min:1',
        ];
    }
}
