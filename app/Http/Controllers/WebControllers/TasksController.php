<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
  // All tasks
  public function index()
  {
    $all = Task::with('user')->orderBy('created_at', 'desc')->paginate( config('global.PER_PAGE') );
    return view('tasks.index', compact('all'));
  }
}
