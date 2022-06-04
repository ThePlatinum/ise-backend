<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller

{
  //  All tasks
  public function alltasks()
  {
    $all = Task::with('user')
      ->where('status', 'approved')
      ->paginate( config('global.PER_PAGE') );
    return response()->json($all, 200);
  }

  // Tasks by category
  public function tasks($categoty_id)
  {
    $taskbycategories = Task::with('user', 'files')
      ->where('status', 'approved')
      ->where('category_id', $categoty_id)
      ->paginate( config('global.PER_PAGE') );
    return response()->json($taskbycategories, 200);
  }

  // Search
  public function search(Request $request)
  {
    $search = $request->q;

    // TODO: use Laravel Scout

    $searchresult = Task::with('user', 'files')
      ->where('status', 'approved')
      ->where('name', 'like', '%' . $search . '%')
      ->orWhere('description', 'like', '%' . $search . '%')
      ->paginate( config('global.PER_PAGE') );
    return response()->json($searchresult, 200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'duration' => 'required',
      'duration_type' => 'required',
      'price' => 'required',
      'currency' => 'required',
      'category_id' => 'required|integer',
      'user_id' => 'required|integer'
    ]);
    if ($validator->fails()) {
      $response = ['status' => false, 'message' => $validator->errors()->all()];
      return response($response, 200);
    }
    $task = Task::create($request->all());
    return response()->json(['Task Added'], 200);
  }

  public function update(Request $request, $task_id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'duration' => 'required',
      'duration_type' => 'required',
      'price' => 'required',
      'currency' => 'required',
      'category_id' => 'required|integer',
      'user_id' => 'required|integer'
    ]);
    if ($validator->fails()) {
      $response = ['status' => false, 'message' => $validator->errors()->all()];
      return response($response, 200);
    }
    $task = Task::find($task_id);
    if ($task->user_id != $request->user_id) {
      return response()->json(['You are not allowed to update this task'], 200);
    }
    $task->update($request->all());
    return response()->json(['Task Updated'], 200);
  }

  public function delete(Request $request){
    $task = Task::find($request->task_id);
    if ($task->user_id != $request->user_id) {
      return response()->json(['You are not allowed to delete this task'], 200);
    }
    $task->delete();
    return response()->json(['Task Deleted'], 200);
  }

  public function show($user_id)
  {
    $task = Task::with('files', 'files')
      ->where('status', 'approved')
      ->where('user_id', $user_id)
      ->paginate( config('global.PER_PAGE') );
    if (!$task) {
      return response()->json([
        'status' => 'error',
        'message' => 'Task could not be found for selected user'
      ], 400);
    }
    return response()->json($task, 200);
  }
}