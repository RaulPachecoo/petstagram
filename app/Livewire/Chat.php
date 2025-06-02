<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Chat extends Component
{
    public $receiver;
    public $messageBody = '';  // Cuerpo del mensaje
    public $chatMessages = []; // Mensajes del chat

    protected $rules = [
        'messageBody' => 'required|string|max:1000',  // Validación de la longitud del mensaje
    ];

    // Actualizamos el método mount para cargar los mensajes según el receptor
    public function mount(User $receiver)
    {
        $this->receiver = $receiver;
        $this->loadMessages();
    }

    // Función para enviar un mensaje
    public function sendMessage()
    {
        try {
            $this->validate();

            Message::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $this->receiver->id,
                'body' => $this->messageBody,
            ]);

            $this->messageBody = '';
            $this->loadMessages();

            // Emitimos el evento en minúscula para que coincida con el JS
            $this->dispatch('message-sent');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al enviar el mensaje.');
        }
    }

    // Función para cargar los mensajes del chat
    public function loadMessages()
    {
        $userId = Auth::id();

        // Marcar como leídos todos los mensajes que ha enviado el receptor al usuario autenticado
        Message::where('sender_id', $this->receiver->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Obtener todos los mensajes del chat
        $this->chatMessages = Message::with('sender')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $this->receiver->id);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $this->receiver->id)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }


    // Registra el listener para escuchar el evento 'changeReceiver'
    protected $listeners = ['changeReceiver', 'mark-as-read-if-active'];
    // Función para cambiar el receptor del chat dinámicamente
    public function changeReceiver($username)
    {
        session()->flash('debug', "Cambiando receptor a: {$username}");

        if (!$username) return;

        $this->receiver = User::where('username', $username)->first();

        if (!$this->receiver) {
            session()->flash('debug', "Usuario no encontrado: {$username}");
            return;
        }

        $this->loadMessages();

        // Emitimos el evento en minúscula para que coincida con el JS
        $this->dispatch('receiver-changed', id: $this->receiver->id);
    }



    public function markAsReadIfActive()
    {
        if (!$this->receiver) return;

        Message::where('sender_id', $this->receiver->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    // Renderizar la vista con los mensajes
    public function render()
    {
        $user = Auth::user();
        $admin = \App\Models\User::where('email', 'raulpachecoropero555@gmail.com')->first();

        if ($user->email === 'raulpachecoropero555@gmail.com') {
            // Admin ve a todos menos a sí mismo
            $followedUsers = \App\Models\User::where('id', '!=', $user->id)->get();
        } else {
            // Usuarios ven a quienes siguen + admin (si no lo siguen ya)
            $followedUsers = $user->following;
            if ($admin && !$followedUsers->contains('id', $admin->id) && $admin->id !== $user->id) {
                $followedUsers = $followedUsers->concat([$admin]);
            }
        }

        // Mensajes no leídos agrupados por usuario
        $unreadMessages = \App\Models\Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->selectRaw('sender_id, COUNT(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id');

        return view('livewire.chat', [
            'chatMessages'   => $this->chatMessages,
            'followedUsers'  => $followedUsers,
            'unreadMessages' => $unreadMessages,
        ]);
    }
}