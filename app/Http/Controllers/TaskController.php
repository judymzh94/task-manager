<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): Collection
    {
        return Task::with('keywords')->get();
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $task = Task::create($request->validated());

        if ($request->has('keywords')) {
            $task->keywords()->sync($request->keywords);
        }

        return response()->json([
            'message' => 'Task created successfully',
            'data' => new TaskResource($task->load('keywords'))
        ], 201);
    }

    public function toggle($id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->update([
                'is_done' => !$task->is_done,
            ]);

            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
