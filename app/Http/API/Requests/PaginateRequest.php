<?php

namespace App\Http\API\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $page
 * @property int $perPage
 */
class PaginateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'integer|min:1',
            'perPage' => 'integer|min:1',
        ];
    }
}
