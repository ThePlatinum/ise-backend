<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Task;
use Illuminate\Support\Str;
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
  public function tasks($category_slug)
  {
    $category_id = Categories::where('slug', $category_slug)->first()->id;
    $taskbycategories = Task::with('user', 'files')
      ->where('status', 'approved')
      ->where('category_id', $category_id)
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
    $task->slug = Str::slug($task->id.$task->name, '_');
    $task->save();
    return response()->json(['Task Added'], 200);
  }

  public function update(Request $request, $task_id)
  {
    // TODO: Fix with slug
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

  public function get_task($task_slug){
    $task = Task::where('slug', $task_slug)->first();
    if (!$task) {
      return response()->json(['Task Not Found'], 404);
    }
    return response()->json($task, 200);
  }
}
