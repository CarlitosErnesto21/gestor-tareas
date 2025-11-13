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

    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Task::where('user_id', Auth::id());
        if ($status && in_array($status, ['pendiente', 'en_progreso', 'completada'])) {
            $query->where('status', $status);
        }
        $tasks = $query->get();

        // Si la petición es parcial (Inertia partial reload)
        if ($request->hasHeader('X-Inertia-Partial-Data')) {
            $props = [];
            $partial = explode(',', $request->header('X-Inertia-Partial-Data'));
            if (in_array('tasks', $partial)) {
                $props['tasks'] = $tasks;
            }
            if (in_array('filterStatus', $partial)) {
                $props['filterStatus'] = $status;
            }
            return Inertia::render('Tasks/Index', $props);
        }

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'filterStatus' => $status,
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
        return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente.');
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

        // Respuesta vacía exitosa para Inertia DELETE
        return response('', 200);
    }
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validate([
            'status' => 'required|in:pendiente,en_progreso,completada',
        ]);

        // Actualizar el estado de la tarea
        $task->update(['status' => $validated['status']]);

        // Respuesta vacía exitosa para Inertia PATCH
        return response('', 200);
    }
}
