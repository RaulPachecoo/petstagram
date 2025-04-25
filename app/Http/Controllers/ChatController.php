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
        // Asegúrate de que el $user esté siendo pasado correctamente
        $receiver = $user; // Este es el usuario con el que el usuario actual quiere chatear

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

        // Pasamos el receptor y los mensajes a la vista
        return view('messages.chat', [
            'receiver' => $receiver,
            'chatMessages' => $chatMessages,
        ]);
    }
}
