<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{

    public function index()
    {
        $projects = Project::all();
        $tasks = Task::with('project')->get();
        return Inertia::render('Tasks/Index', ['tasks' => $tasks, 'projects' => $projects]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'state' => 'required',
            'project_id' => 'required',
        ]);

        $task = new Task($request->input());
        $task->save();
        return redirect('tasks');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'state' => 'required',
            'project_id' => 'required',
        ]);


        $task->update($request->input());
        return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('tasks');
    }
}
