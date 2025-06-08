<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para gestionar la funcionalidad de "me gusta" en una publicación.
 *
 * Permite a un usuario autenticado dar o quitar "me gusta" a un post,
 * actualizando el estado y el contador de likes en tiempo real.
 */
class LikePost extends Component
{
    /**
     * La publicación (post) sobre la cual se va a realizar la acción de like/unlike.
     *
     * @var \App\Models\Post
     */
    public $post;

    /**
     * Indica si el usuario autenticado ya ha dado "me gusta" a la publicación.
     *
     * @var bool
     */
    public $isLiked;

    /**
     * Cantidad actual de "me gusta" que tiene la publicación.
     *
     * @var int
     */
    public $likes;

    /**
     * Inicializa el componente con el post objetivo, estableciendo
     * si el usuario autenticado ha dado "me gusta" y el conteo de likes.
     *
     * @param \App\Models\Post $post La publicación que se mostrará y se podrá likear.
     * @return void
     */
    public function mount($post)
    {
        $this->post = $post;
        $this->isLiked = $post->checkLike(Auth::user());
        $this->likes = $post->likes->count();
    }

    /**
     * Alterna el estado de "me gusta" para la publicación del usuario autenticado.
     * Actualiza el estado interno y el contador de likes en consecuencia.
     *
     * @return void
     */
    public function like()
    {
        if ($this->post->checkLike(Auth::user())) {
            // Si ya le dio like, eliminarlo
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            // Si no, crear el like
            $this->post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    /**
     * Renderiza la vista correspondiente al botón de like.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.like-post');
    }
}
