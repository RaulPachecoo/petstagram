<?php

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/', HomeController::class)->name('home');

// Auth
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// Follow
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

// Posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

// Imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Likes
Route::post('/posts/{post}likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Contraseñas
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Ruta para redirigir al primer chat disponible (con un usuario con mensajes)
Route::get('/chat', function () {
    $userId = Auth::user()->id;

    // Buscar el primer usuario con quien tenga mensajes
    $message = Message::where('sender_id', $userId)
        ->orWhere('receiver_id', $userId)
        ->orderBy('created_at', 'desc')
        ->first();

    if ($message) {
        $otherUser = $message->sender_id === $userId ? $message->receiver : $message->sender;
        return redirect()->route('chat', ['user' => $otherUser->username]);
    }

    // Si no tiene chats aún, puedes redirigir al home o a una página vacía
    return redirect()->route('home')->with('info', 'Aún no tienes conversaciones.');
})->name('chat.default')->middleware('auth');

// Ruta para acceder al chat de un usuario específico
Route::get('/chat/{user:username}', [ChatController::class, 'index'])->name('chat')->middleware('auth');

// Ruta para posts del usuario
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');