<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Componente Livewire para gestionar el botón de seguir/dejar de seguir a un usuario.
 *
 * Permite a un usuario autenticado seguir o dejar de seguir a otro usuario,
 * actualizando el estado y el contador de seguidores en tiempo real.
 */
class FollowButton extends Component
{
    /**
     * Usuario que se va a seguir o dejar de seguir.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Indica si el usuario autenticado ya sigue al usuario objetivo.
     *
     * @var bool
     */
    public $isFollowing;

    /**
     * Cantidad actual de seguidores del usuario objetivo.
     *
     * @var int
     */
    public $followersCount;

    /**
     * Inicializa el componente con el usuario objetivo y establece
     * el estado inicial de seguimiento y el conteo de seguidores.
     *
     * @param \App\Models\User $user Usuario objetivo a seguir/dejar de seguir.
     * @return void
     */
    public function mount($user)
    {
        $this->user = $user;
        $this->isFollowing = $user->siguiendo(Auth::user());
        $this->followersCount = $user->followers->count();
    }

    /**
     * Alterna el estado de seguimiento del usuario autenticado sobre el usuario objetivo.
     * Actualiza el estado interno y el conteo de seguidores.
     *
     * @return void
     */
    public function toggleFollow()
    {
        if ($this->isFollowing) {
            $this->user->followers()->detach(Auth::user());
            $this->isFollowing = false;
            $this->followersCount--;
        } else {
            $this->user->followers()->attach(Auth::user());
            $this->isFollowing = true;
            $this->followersCount++;
        }
    }

    /**
     * Renderiza la vista correspondiente al botón de seguir.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.follow-button');
    }
}
