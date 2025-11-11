<?php


namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pendiente,en_progreso,completada',
        ]);
        $validated['user_id'] = Auth::id();
        Task::create($validated);
        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return Inertia::render('Tasks/Show', [
            'task' => $task,
        ]);
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        return Inertia::render('Tasks/Edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pendiente,en_progreso,completada',
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada correctamente.');
    }
}
