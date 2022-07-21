<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
  //

  public function show_all($user_id)
  {
    $task = Task::with('files')
      ->where('user_id', $user_id)
      ->paginate(config('global.PER_PAGE'));
    if (!$task) {
      return response()->json([
        'status' => 'error',
        'message' => 'Task could not be found for selected user'
      ], 400);
    }
    return response()->json($task, 200);
  }

  public function show_approved($user_id)
  {
    $task = Task::with('files')
      ->where('status', 'approved')
      ->where('user_id', $user_id)
      ->paginate(config('global.PER_PAGE'));
    if (!$task) {
      return response()->json([
        'status' => 'error',
        'message' => 'Task could not be found for selected user'
      ], 400);
    }
    return response()->json($task, 200);
  }

  public function show_not_approved($user_id)
  {
    $task = Task::with('files')
      ->where('status', '!=', 'approved')
      ->where('user_id', $user_id)
      ->paginate(config('global.PER_PAGE'));
    if (!$task) {
      return response()->json([
        'status' => 'error',
        'message' => 'Task could not be found for selected user'
      ], 400);
    }
    return response()->json($task, 200);
  }
}
