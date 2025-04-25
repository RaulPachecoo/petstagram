<?php

// App\Livewire\NotificacionesChat.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NotificacionesChat extends Component
{
    public $hasUnread = false;
    public $receiver;
    public $followedUsers = []; // Lista de usuarios seguidos

    public function mount()
    {
        $this->hasUnread = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->exists();

        // Obtener el primer receptor con mensajes no leídos
        $message = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->first();

        if ($message) {
            $this->receiver = $message->sender;
        }

        // Obtener la lista de usuarios seguidos
        $this->followedUsers = Auth::user()->following;
    }

    public function render()
    {
        $unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('livewire.notificaciones-chat', [
            'unreadCount' => $unreadCount,
        ]);
    }
}
