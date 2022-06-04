<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
  //

  public function store(Request $request)
  {
    //
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'task_id' => 'required|exists:tasks,id',
      'review' => 'required|string',
      'rating' => 'required|integer|min:1|max:5',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'message' => $validator->errors()->first(),
      ], 400);
    }

    $review = Reviews::create([
      'user_id' => $request->user_id,
      'task_id' => $request->task_id,
      'review' => $request->review,
      'rating' => $request->rating,
    ]);

    if ($review) {
      return response()->json([
        'status' => 'success',
        'message' => 'Review created successfully'
      ], 200);
    }
  }
}
