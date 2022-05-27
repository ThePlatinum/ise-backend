<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
  //

  public function index()
  {
    $all = Task::with('user')->paginate( config('global.PER_PAGE') );
    return view('tasks.index', compact('all'));
  }

  //  All tasks
  public function alltasks()
  {
    $all = Task::with('user')->paginate( config('global.PER_PAGE') );
    return response()->json($all, 200);
  }

  // Tasks by category
  public function tasks($categoty_id)
  {
    $taskbycategories = Task::with('user')->where('category_id', $categoty_id)->paginate( config('global.PER_PAGE') );
    return response()->json($taskbycategories, 200);
  }

  // Search
  public function search(Request $request)
  {
    $search = $request->q;

    // TODO: use Laravel Scout

    $searchresult = Task::with('user')->where('name', 'like', '%' . $search . '%')
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
}
