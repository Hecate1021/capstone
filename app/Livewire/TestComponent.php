<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class TestComponent extends Component
{

    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];

    public function sendMessage()
    {
dd($this->message);
        $message = new Message();
        $message->sender_id = $this->sender_id;
        $message->receiver_id = $this->receiver_id;
        $message->message = $this->message;
        $message->save();

        broadcast(new MessageSendEvent($message))->toOthers();
        $this->chatMessage($message);
        $this->message = '';

    }

    public function render()
    {
        return view('livewire.test-component');
    }

    public function mount($user_id){
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        $messages = Message::where(function($query){
            $query->where('sender_id', $this->sender_id)
            ->where('receiver_id', $this->receiver_id);
        })->orWhere(function($query){
            $query->where('sender_id', $this->receiver_id)
            ->where('receiver_id', $this->sender_id);
        })->with('sender:id,name', 'receiver:id,name')->get();

        foreach($messages as $message){
            $this->chatMessage($message);
        }

        $this->user = User::find($user_id);

    }
    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event){
        $chatMessage = Message::whereId($event['message']['id'])->with('sender:id,name', 'receiver:id,name')->first();
        $this->chatMessage($chatMessage);
    }

    public function chatMessage($message){
        $this->messages[]=[
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name
        ];
    }
}
