<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::count();
        $tasks = Task::count();
        $users = User::count();
        return Inertia::render('Dashboard', ['projects' => $projects, 'tasks' => $tasks, 'users' => $users]);
    }

    public function users()
    {

        $users = User::with('roles')->get();
        return Inertia::render('Users/Index', ['users' => $users]);
    }
}
