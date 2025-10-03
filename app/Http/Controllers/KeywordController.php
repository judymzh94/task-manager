<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeywordRequest;
use App\Http\Resources\KeywordResource;
use App\Models\Keyword;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class KeywordController extends Controller
{
    public function index(): Collection
    {
        return Keyword::all();
    }

    public function store(KeywordRequest $request): JsonResponse
    {
        $keyword = Keyword::create($request->validated());

        return response()->json([
            'message' => 'Keyword created successfully',
            'data' => new KeywordResource($keyword),
        ], 201);
    }
}
