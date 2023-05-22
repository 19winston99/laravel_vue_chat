<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_user_id = $request->currentUser;
        $current_user_id_to_conversate = $request->selectedUser;
        $messages = Message::where(function ($query) use ($current_user_id, $current_user_id_to_conversate) {
            $query->where('sender_id', $current_user_id)
                ->where('recipient_id', $current_user_id_to_conversate);
        })->orWhere(function ($query) use ($current_user_id, $current_user_id_to_conversate) {
            $query->where('sender_id', $current_user_id_to_conversate)
                ->where('recipient_id', $current_user_id);
        })->get();
        return $messages;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_id' => 'required',
            'recipient_id' => 'required',
        ]);

        if ($request->image) {
            $name = uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/messages'), $name);
        } else {
            $name = null;
        }

        $message = Message::create([
            'sender_id' => $request->sender_id,
            'recipient_id' => $request->recipient_id,
            'message' => $request->message,
            'image' => $name
        ]);

        $user = User::find($request->recipient_id);
        event(new NewMessage($message, $user));

        return ['success' => 'Messaggio inviato con successo', 'id' => $message->id, 'image' => $name];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message = Message::find($message->id);
        $message->delete();

        return ['success' => 'Messaggio eliminato con successo'];
    }
}
