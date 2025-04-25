<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(User $user)
    {
        $receiver = $user; // Usuario con el que el usuario actual quiere chatear

        // Recuperamos los mensajes entre el usuario actual y el receptor
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

        // Obtener usuarios seguidos
        $followedUsers = Auth::user()->following;

        // Verificar si hay mensajes no leídos de cada usuario
        $unreadMessages = [];
        foreach ($followedUsers as $followedUser) {
            $unreadMessages[$followedUser->id] = Message::where('receiver_id', Auth::id())
                ->where('sender_id', $followedUser->id)
                ->where('is_read', false)
                ->count();
        }

        // Pasamos los datos a la vista
        return view('messages.chat', [
            'receiver' => $receiver,
            'chatMessages' => $chatMessages,
            'followedUsers' => $followedUsers,
            'unreadMessages' => $unreadMessages, // Pasamos el conteo de mensajes no leídos
        ]);
    }
}
