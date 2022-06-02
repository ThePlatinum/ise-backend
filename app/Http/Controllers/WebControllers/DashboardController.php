<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $users = User::all();
    $users_identified = User::where('identified', 1)->get();
    $users_not_identified = User::where('identified', 0)->get();

    $tasks = Task::where('status', '!=', 'rejected')->get();
    $tasks_approved = Task::where('status', 'approved')->get();
    $tasks_pending = Task::where('status', 'pending')->get();

    $projects = Project::all();

    $counts = [
      'users' => $users->count(),
      'users_identified' => $users_identified->count(),
      'users_not_identified' => $users_not_identified->count(),
      'tasks' => $tasks->count(),
      'tasks_approved' => $tasks_approved->count(),
      'tasks_pending' => $tasks_pending->count(),
      'projects' => $projects->count(),
    ];
    return view('components.dashboard', compact('counts'));
  }
}
