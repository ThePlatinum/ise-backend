<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    //
    public function to_pay($task, $buyer){
      $the_buyer = User::find($buyer);
      $the_task = Task::find($task);
      
      if(!$the_buyer)
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid User'
        ], 402);

      if(!$the_task)
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid Task'
        ], 402);
      
      if($the_task->user->id == $the_buyer->id)
        return response()->json([
          'status' => 'error',
          'message' => 'You can not buy your tasks'
        ], 402);

      // TODO: Consider the currency
      $cost = 100*$the_task->price;

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
          return response()->json([
            'pay_route' => $response->json()['data']['authorization_url']
          ], 200);
      } catch (\Throwable $th) {
        //throw $th;
        return response()->json([
          'error' => 'An error occured'
        ], 500);
      }
    }
  
    public function paymentreturn() {
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
