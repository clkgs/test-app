<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /** @test */
    public function request_without_parameters_return_correct_results(): void
    {
        $this->getJson('api/v1/categories')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ]);
    }
}
