<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $receiver;
    public $messageBody = '';  // Cuerpo del mensaje
    public $chatMessages = []; // Mensajes del chat

    protected $rules = [
        'messageBody' => 'required|string|max:1000',  // Validación de la longitud del mensaje
    ];

    // Intervalo para polling (cada 3 segundos, ajusta según sea necesario)
    protected $pollingInterval = 3;

    public function mount(User $receiver)
    {
        $this->receiver = $receiver;
        $this->loadMessages();  // Cargar los mensajes cuando se monte el componente
    }

    // Función para enviar un mensaje
    public function sendMessage()
    {
        try {
            $this->validate();

            // Guardar el mensaje
            Message::create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $this->receiver->id,
                'body' => $this->messageBody,
            ]);

            $this->messageBody = '';
            $this->loadMessages();

            // Emitir el evento para desplazamiento del scroll
            $this->emit('messageSent');  // Este es el evento que debe ser escuchado en el frontend

        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al enviar el mensaje.');
        }
    }


    // Función para cargar los mensajes del chat
    public function loadMessages()
    {
        $this->chatMessages = Message::with('sender') // Asegura que podamos acceder a $message->sender->username
            ->where(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $this->receiver->id);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->receiver->id)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar como leídos
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $this->receiver->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }



    // Verificar si hay mensajes no leídos
    public function hasUnreadMessages()
    {
        return Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->exists();
    }

    // Renderizar la vista con los mensajes
    public function render()
    {
        return view('livewire.chat', [
            'chatMessages' => $this->chatMessages,
        ]);
    }
}
