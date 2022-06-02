<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {
    //
    $portfolios = $this->show($id)->portfolios;
    // return view('account.portfolio.index', compact('portfolios'));
  }

  /*
   * Create a new portfolio entry for a user
   */
  public function create(Request $request)
  {
    //
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'title' => 'required|string|max:255',
      'description' => 'required|string|max:255',
      'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc|max:2048',
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date',
      'external_link' => 'nullable|url',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
      ], 400);
    }

    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $fileName = $request->user_id . '_' . str_replace(' ', '', $request->title) . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/uploads/portfolios', $fileName);
    } else {
      $fileName = null;
    }
    // TODO: Consider using as updateOrCreate
    $port = Portfolio::create([
      'user_id' => $request->user_id,
      'title' => $request->title,
      'description' => $request->description,
      'file' => $fileName,
      'external_link' => $request->external_link,
      'start_date' => $request->start_date,
      'end_date' => $request->end_date,
    ]);

    if ($port) {
      return response()->json([
        'status' => 'success',
        'message' => 'Portfolio entry created successfully'
      ], 200);
    } else {
      return response()->json([
        'status' => 'error',
        'message' => 'Portfolio entry could not be created'
      ], 400);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($user_id)
  {
    //
    $portfolios = Portfolio::where('user_id', $user_id)->get();

    if ($portfolios) {
      return response()->json([
        'status' => 'success',
        'portfolios' => $portfolios
      ], 200);
    } else {
      return response()->json([
        'status' => 'error',
        'message' => 'Portfolios could not be retrieved'
      ], 400);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'portfolio_id' => 'required|exists:portfolios,id',
      'title' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:255',
      'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc|max:2048',
      'start_date' => 'nullable|date',
      'end_date' => 'nullable|date',
      'external_link' => 'nullable|url',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors()
      ], 400);
    }

    $portfolio = Portfolio::where('id', $request->portfolio_id)->where('user_id', $request->user_id)->first();
    if (!$portfolio) {
      return response()->json([
        'status' => 'error',
        'message' => 'Portfolio entry could not be found for selected user'
      ], 400);
    }

    if ($request->hasFile('file')) {
      if ($portfolio->file != null)
        unlink(storage_path('app/public/uploads/portfolios/' . $portfolio->file)); //Should  be delete
      $file = $request->file('file');
      $fileName = $request->user_id . '_' . str_replace(' ', '', $request->title) . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/uploads/portfolios', $fileName);
    } else {
      $fileName = null;
    }
    if ($portfolio->title)
      $portfolio->title = $request->title;
    if ($portfolio->description)
      $portfolio->description = $request->description;
    if ($portfolio->file)
      $portfolio->file = $fileName;
    if ($portfolio->external_link)
      $portfolio->external_link = $request->external_link;
    if ($portfolio->start_date)
      $portfolio->start_date = $request->start_date;
    if ($portfolio->end_date)
      $portfolio->end_date = $request->end_date;
    $portfolio->save();

    return response()->json([
      'status' => 'success',
      'message' => 'Portfolio entry updated successfully'
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function delete($user_id, $portfolio_id)
  {
    //
    $portfolio = Portfolio::find($portfolio_id);
    if (!$portfolio) {
      return response()->json([
        'status' => 'error',
        'message' => 'Portfolio entry could not be found for selected user'
      ], 400);
    }

    if ($portfolio->file)
      unlink(storage_path('app/public/uploads/portfolios/' . $portfolio->file)); //Should  be delete

    if ($portfolio->delete()) {
      return response()->json([
        'status' => 'success',
        'message' => 'Portfolio entry deleted successfully'
      ], 200);
    } else {
      return response()->json([
        'status' => 'error',
        'message' => 'Portfolio entry could not be deleted'
      ], 400);
    }
  }
}