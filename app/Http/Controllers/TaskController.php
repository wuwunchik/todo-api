<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;  // Добавьте импорт для валидации
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)  // Измените на TaskRequest для валидации
    {
        $task = auth()->user()->tasks()->create($request->validated());
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)  // Измените на TaskRequest для валидации
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $task->update($request->validated());
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $task->delete();
        return response()->json(null, 204);
    }
}
