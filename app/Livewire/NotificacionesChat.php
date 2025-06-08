<?php

// App\Livewire\NotificacionesChat.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Componente Livewire que gestiona las notificaciones de chat,
 * mostrando si hay mensajes no leídos y los usuarios seguidos.
 */
class NotificacionesChat extends Component
{
    /**
     * Indica si el usuario autenticado tiene mensajes no leídos.
     *
     * @var bool
     */
    public $hasUnread = false;

    /**
     * Usuario remitente del primer mensaje no leído.
     *
     * @var \App\Models\User|null
     */
    public $receiver;

    /**
     * Lista de usuarios que el usuario autenticado sigue.
     *
     * @var \Illuminate\Support\Collection|\App\Models\User[]
     */
    public $followedUsers = [];

    /**
     * Inicializa el componente cargando el estado de mensajes no leídos,
     * el primer remitente con mensaje no leído, y los usuarios seguidos.
     *
     * @return void
     */
    public function mount()
    {
        $this->hasUnread = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->exists();

        // Obtener el primer remitente con mensajes no leídos
        $message = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->first();

        if ($message) {
            $this->receiver = $message->sender;
        }

        // Cargar lista de usuarios seguidos por el usuario autenticado
        $this->followedUsers = Auth::user()->following;
    }

    /**
     * Renderiza la vista con la cantidad de mensajes no leídos.
     *
     * @return \Illuminate\View\View
     */
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
