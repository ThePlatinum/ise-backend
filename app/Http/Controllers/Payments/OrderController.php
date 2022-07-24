<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function order_task(Request $request){
      $validator = Validator::make($request->all(), [
        'buyer' => 'required|exists:users,id',
        'task' => 'required|exists:tasks,id',
        'quantity' => 'required|numeric|min:0',
      ]);

      if ($validator->fails()) return response()->json($validator->errors()->first(), 400);

      $buyer = $request->buyer;
      $task = $request->task;
      $the_buyer = User::find($buyer);
      $the_task = Task::find($task);
      
      if(!$the_buyer || !$the_task)
        return response()->json('Invalid Order', 400);
        
      if ($the_task->user->id == $the_buyer->id)
        return response()->json('You can not buy a task you own', 400);

      // TODO: Consider the currency
      $cost = 100 * $the_task->price * $request->quantity;

      // TODO: Use consts
      $URL = 'https://api.paystack.co/transaction/initialize';
  
      try {
        $response = Http::asForm()
        ->withToken( config('global.PAYSTACK_SECRET_KEY'), 'Bearer')
        ->withHeaders([
          'Content-Type' => 'application/x-www-form-urlencoded',
          'Accept' => 'application/json'
        ])
        ->post($URL, [
          'amount'        => $cost,
          'email'         => $the_buyer->email,
          'callback_url'  => 'http://127.0.0.1:8000/api/paymentreturn',
          'currency'      => 'NGN'
        ]);
  
        if ($response->successful())
          Order::create([
            'task_id' => $task,
            'buyer_id' => $buyer,
            'seller_id' => $the_task->user->id,
            'task_title' => $the_task->name,
            'order_price' => $cost,
            'quantity' => $request->quantity,
            'duration' => $the_task->duration,
            'duration_type' => $the_task->duration_type,
          ]);
          return response()->json($response->json()['data']['authorization_url'], 200);
      } catch (\Throwable $th) {
        //throw $th;
        return response()->json('Oops, an error occured, please retry', 402);
      }
    }
  
    public function confirm_payment() {
      $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
      // $trxref = isset($_GET['reference']) ? $_GET['reference'] : '';
      $buyer = Auth()->user()->id;
      $the_buyer = User::find($buyer);
  
      if(!$reference){
        return response()->json([
          'error' => 'Invalid Transaction'
        ], 400);
      }
  
      $URL = 'https://api.paystack.co/transaction/verify/'.$reference;
  
      try {
        $response = Http::withToken( config('global.PAYSTACK_SECRET_KEY'), 'Bearer')
        ->withHeaders(['Accept' => 'application/json'])
        ->get($URL);
  
        if ($response->successful() &&  ($response->json()['data']['status'] == 'success')){
  
          $the_buyer->subscribed_at = now();
          $the_buyer->save();
  
          return  response()->json([
            'stutus' => 'Payment Successful'
          ], 200);
        }
        else
          return response()->json([
          'error' => 'Could not verify payment'
        ], 500);
      } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
          'error' => 'An error occured'
        ], 500);;
      }
      // TODO: Add ordered tasks
    }
}
