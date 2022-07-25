<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Task;
use App\Models\User;
use App\Providers\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function order_task(Request $request){
      $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'task' => 'required|exists:tasks,id',
        'quantity' => 'required|numeric|min:0',
      ]);

      if ($validator->fails()) return response()->json($validator->errors()->first(), 400);

      $buyer = $request->user_id;
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
          'callback_url'  => 'http://127.0.0.1:3000/order/requirement',
          'currency'      => 'NGN'
        ]);
  
        if ($response->successful())
          $order = Order::create([
            'task_id' => $task,
            'buyer_id' => $buyer,
            'seller_id' => $the_task->user->id,
            'task_title' => $the_task->name,
            'order_price' => $cost,
            'quantity' => $request->quantity,
            'duration' => $the_task->duration,
            'duration_type' => $the_task->duration_type,
          ]);
          return response()->json([
            'url' => $response->json()['data']['authorization_url'],
            'order' => $order->id
          ], 200);
      } catch (\Throwable $th) {
        //throw $th;
        return response()->json('Oops, an error occured, please retry', 402);
      }
    }
  
    public function confirm_order(Request $request) {

      $reference = $request->reference;
      $the_buyer = User::find($request->user_id);
      $the_order = Order::find($request->order);

      if(!$reference) return response()->json('Invalid Transaction', 400);

      $URL = 'https://api.paystack.co/transaction/verify/'.$reference;
      try {
        $response = Http::withToken( config('global.PAYSTACK_SECRET_KEY'), 'Bearer')
        ->withHeaders(['Accept' => 'application/json'])
        ->get($URL);
  
        if ($response->successful() && ($response->json()['data']['status'] == 'success')){
          $the_order->paid = true;
          $the_order->save();
          // TODO: Mail the task owner
          event( new OrderCreated() );
          return  response()->json('Successful', 200);
        }
        else
          return response()->json('Could not verify payment', 400);
      } catch (\Throwable $th) {
        return response()->json('An error occured', 500);;
      }
      // TODO: Add ordered tasks
    }
}
