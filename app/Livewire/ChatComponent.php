<?php
namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ChatComponent extends Component
{
    public $user;
    public $sender_id;
    public $receiver_id;
    public $messages = [];
    public $message;

    // Refresh the messages every 3 seconds (adjust as needed)
    public $pollInterval = 10;

    public function sendMessage()
    {
        $message = new Message();
        $message->sender_id = $this->sender_id;
        $message->receiver_id = $this->receiver_id;
        $message->message = $this->message;
        $message->save();

        // Refresh the sender's messages list
        $this->loadMessages();

        // Optionally clear the message input field
        $this->message = '';

        $this->dispatch('messageSent', $this->sender_id, $this->receiver_id, [
            'sender_name' => auth()->user()->name,
            'message' => $message->message,
        ]);
    }




    protected $listeners = ['refreshMessages' => 'loadMessages'];

    public function loadMessages($receiver_id = null)
    {
        // If receiver_id is passed, refresh only for that receiver
        if ($receiver_id) {
            $this->receiver_id = $receiver_id;
        }

        // Fetch the latest messages
        $messages = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->receiver_id)
                    ->where('receiver_id', $this->sender_id);
            })
            ->with('sender:id,name', 'receiver:id,name')
            ->get();

        // Update the component's message list
        $this->messages = $messages->map(function ($message) {
            return [
                'id' => $message->id,
                'message' => $message->message,
                'sender' => $message->sender->name,
                'receiver' => $message->receiver->name,
                'time' => Carbon::parse($message->created_at)->diffForHumans(),
            ];
        })->toArray();
    }


    public function render()
    {
        return view('livewire.chat-component');
    }

    public function mount($user_id)
    {
        // Set the sender and receiver ids
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;

        // Load the initial messages
        $this->loadMessages();

        // Fetch user information
        $this->user = User::find($user_id);
    }

    public function pollMessages()
    {
        // Refresh messages from the database on a regular interval
        $this->loadMessages();
    }
}
