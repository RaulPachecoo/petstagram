<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador encargado de gestionar las relaciones de seguimiento entre usuarios.
 * Permite que un usuario siga o deje de seguir a otro.
 */
class FollowerController extends Controller
{
    /**
     * Almacena una nueva relación de seguimiento.
     * El usuario autenticado empieza a seguir al usuario recibido por parámetro.
     *
     * @param \App\Models\User $user El usuario que va a ser seguido.
     * @return \Illuminate\Http\RedirectResponse Redirige de vuelta a la página anterior.
     */
    public function store(User $user)
    {
        // El usuario autenticado sigue al usuario recibido
        $user->followers()->attach(Auth::user()->id); 

        return back(); 
    }

    /**
     * Elimina una relación de seguimiento.
     * El usuario autenticado deja de seguir al usuario recibido por parámetro.
     *
     * @param \App\Models\User $user El usuario al que se deja de seguir.
     * @return \Illuminate\Http\RedirectResponse Redirige de vuelta a la página anterior.
     */
    public function destroy(User $user)
    {
        // El usuario autenticado deja de seguir al usuario recibido
        $user->followers()->detach(Auth::user()->id); 

        return back(); 
    }
}
