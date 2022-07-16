<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //

  public function sendmessage(Request $request)
  { 
    $message = new Message;
    $message->sender = $request->sender;
    $message->receiver =  $request->receiver; // $request(['receiver']);
    $message->body =  $request->body; //$request(['body']);
    $message->save();
    return response(['status' => true], 200);
  }
  public function getmessage(Request $request)
  {
    $receiver = $request->receiver;
    $sender = $request->sender;
    $messages = Message::where('receiver',$receiver)->where('sender', $sender)
    ->orWhere(function($query) use( $receiver, $sender){
      $query->where('receiver', $sender)
            ->where('sender', $receiver);
    })->orderBy("id", "asc")->take(30)->get();

    $messages->flatMap(
      function($message){
        return [
          $message->read = 1,
          $message->save()
        ];
      }
    );

    return response(['status' => true, 'messages' => $messages], 200);
  }

  public function getunread(Request $request)
  {
    $receiver = $request->receiver;
    $sender = $request->sender;
    $messages = Message::where('sender', $receiver)
      ->where('receiver',$sender)
      ->where('read', 0)->orderBy("id", "asc")->get();

    $messages->flatMap(
      function($message){
        return [
          $message->read = 1,
          $message->save()
        ];
      }
    );

    return response(['status' => true, 'messages' => $messages], 200);
  }

  public function chattingWith($id)
  {
    $receivers = Message::where('sender', $id)->orderBy("id", "desc")->pluck('receiver');
    $sender = Message::where('receiver', $id)->orderBy("id", "desc")->pluck('sender');
    // $unread = Message::where('receiver', $id)->where('read', 0)->count();
    $all = array_merge($receivers->toArray(), $sender->toArray());
    $chatWith = User::whereIn('id', $all)
    ->withCount([
      'senderMessages' => function($query) use($id){
        $query->where('receiver', $id)->where('read', 0);
      }
    ])->get();
    return response(['status' => true, 'chatWith' => $chatWith], 200);
  }
}
