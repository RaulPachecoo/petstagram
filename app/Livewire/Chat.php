<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para gestionar un chat entre usuarios.
 *
 * Permite enviar mensajes, cargar mensajes entre el usuario autenticado y un receptor,
 * marcar mensajes como leídos y cambiar dinámicamente el receptor del chat.
 */
class Chat extends Component
{
    /**
     * Usuario receptor de los mensajes.
     *
     * @var User
     */
    public $receiver;

    /**
     * Cuerpo del mensaje que se va a enviar.
     *
     * @var string
     */
    public $messageBody = '';

    /**
     * Colección de mensajes que forman el chat actual.
     *
     * @var array
     */
    public $chatMessages = [];

    /**
     * Reglas de validación para los datos del componente.
     *
     * @var array
     */
    protected $rules = [
        'messageBody' => 'required|string|max:1000',
    ];

    /**
     * Inicializa el componente cargando el receptor y los mensajes del chat.
     *
     * @param User $receiver Usuario receptor del chat
     */
    public function mount(User $receiver)
    {
        $this->receiver = $receiver;
        $this->loadMessages();
    }

    /**
     * Envía un mensaje al receptor actual.
     *
     * Valida el contenido del mensaje, crea el registro en base de datos,
     * limpia el campo de entrada y recarga los mensajes.
     *
     * Emite un evento 'message-sent' para notificaciones en tiempo real.
     *
     * En caso de error, muestra un mensaje flash de error.
     */
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

            // Emitir evento para frontend
            $this->dispatch('message-sent');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al enviar el mensaje.');
        }
    }

    /**
     * Carga todos los mensajes entre el usuario autenticado y el receptor actual.
     *
     * También marca como leídos los mensajes enviados por el receptor al usuario autenticado.
     */
    public function loadMessages()
    {
        $userId = Auth::id();

        // Marcar mensajes como leídos
        Message::where('sender_id', $this->receiver->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Cargar mensajes del chat ordenados cronológicamente
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

    /**
     * Listeners que responden a eventos desde frontend.
     *
     * @var array
     */
    protected $listeners = ['changeReceiver', 'mark-as-read-if-active'];

    /**
     * Cambia dinámicamente el receptor del chat y recarga los mensajes.
     *
     * Emite un evento 'receiver-changed' con el ID del nuevo receptor.
     *
     * @param string $username Nombre de usuario del nuevo receptor
     */
    public function changeReceiver($username)
    {
        session()->flash('debug', "Cambiando receptor a: {$username}");

        if (!$username) {
            return;
        }

        $this->receiver = User::where('username', $username)->first();

        if (!$this->receiver) {
            session()->flash('debug', "Usuario no encontrado: {$username}");
            return;
        }

        $this->loadMessages();

        $this->dispatch('receiver-changed', id: $this->receiver->id);
    }

    /**
     * Marca como leídos los mensajes del receptor si el chat está activo.
     */
    public function markAsReadIfActive()
    {
        if (!$this->receiver) {
            return;
        }

        Message::where('sender_id', $this->receiver->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Renderiza la vista del componente con la información necesaria.
     *
     * - Obtiene los usuarios seguidos por el usuario autenticado,
     *   añadiendo al administrador si no está incluido.
     * - Obtiene el conteo de mensajes no leídos agrupados por usuario remitente.
     *
     * @return \Illuminate\View\View Vista del componente chat con datos para la interfaz
     */
    public function render()
    {
        $user = Auth::user();
        $admin = User::where('email', 'raulpachecoropero555@gmail.com')->first();

        if ($user->email === 'raulpachecoropero555@gmail.com') {
            // Admin ve a todos menos a sí mismo
            $followedUsers = User::where('id', '!=', $user->id)->get();
        } else {
            // Usuarios ven a quienes siguen + admin si no lo siguen ya
            $followedUsers = $user->following;
            if ($admin && !$followedUsers->contains('id', $admin->id) && $admin->id !== $user->id) {
                $followedUsers = $followedUsers->concat([$admin]);
            }
        }

        // Conteo de mensajes no leídos agrupados por remitente
        $unreadMessages = Message::where('receiver_id', $user->id)
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
