<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador responsable de mostrar la interfaz de chat entre usuarios.
 * Muestra el historial de mensajes, usuarios seguidos y mensajes no leídos.
 */
class ChatController extends Controller
{
    /**
     * Muestra la vista de chat entre el usuario autenticado y otro usuario.
     *
     * @param \App\Models\User $user El usuario con el que se quiere chatear.
     * @return \Illuminate\View\View Vista del chat con el historial de mensajes.
     */
    public function index(User $user)
    {
        $receiver = $user; // Usuario receptor con el que se entabla el chat

        // Recupera todos los mensajes entre el usuario actual y el receptor
        $chatMessages = Message::where(function ($query) use ($receiver) {
            $query->where('sender_id', Auth::user()->id)
                  ->where('receiver_id', $receiver->id);
        })
        ->orWhere(function ($query) use ($receiver) {
            $query->where('sender_id', $receiver->id)
                  ->where('receiver_id', Auth::user()->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Obtiene todos los usuarios que el usuario actual sigue
        $followedUsers = Auth::user()->following;

        // Calcula cuántos mensajes no leídos hay de cada usuario seguido
        $unreadMessages = [];
        foreach ($followedUsers as $followedUser) {
            $unreadMessages[$followedUser->id] = Message::where('receiver_id', Auth::id())
                ->where('sender_id', $followedUser->id)
                ->where('is_read', false)
                ->count();
        }

        // Retorna la vista del chat con los datos necesarios
        return view('messages.chat', [
            'receiver' => $receiver,
            'chatMessages' => $chatMessages,
            'followedUsers' => $followedUsers,
            'unreadMessages' => $unreadMessages,
        ]);
    }
}
