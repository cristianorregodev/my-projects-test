<?php

namespace App\Http\Controllers;

use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProjectController extends Controller
{

    public function index()
    {

        $projects = ProjectResource::collection(Project::all());

        return Inertia::render('Projects/Index', ['projects' => $projects]);
    }


    public function create()
    {
        $users = User::all();
        return Inertia::render('Projects/Create', ['users' => $users]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required'
        ]);
        $project = new Project($request->input());
        $project->save();


        if (count($request->users) > 0) {
            $project->users()->attach($request->users);
        } else {
            $project->users()->attach(auth()->user()->id);
        }

        return redirect('projects');
    }


    public function show(Project $project)

    {
        $tasks = $project->tasks;
        $users = $project->users;
        return Inertia::render('Projects/Show', ['project' => $project, 'tasks' => $tasks, 'users' => $users]);
    }


    public function edit(Project $project)
    {
        $users = User::all();

        $assignedUsers = $project->users->pluck('id');
        return Inertia::render('Projects/Edit', ['project' => $project, 'assignedUsers' => $assignedUsers, 'users' => $users]);
    }


    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required'
        ]);
        $project->update($request->input());
        if (count($request->users) > 0) {
            $project->users()->sync($request->users);
        }
        return redirect('projects');
    }


    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('projects');
    }
}
