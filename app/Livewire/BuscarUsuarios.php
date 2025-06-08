<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

/**
 * Componente Livewire para buscar usuarios por nombre de usuario.
 *
 * Permite realizar búsquedas en tiempo real con un mínimo de 2 caracteres,
 * filtrando usuarios que tengan el rol "user" y limitando los resultados a 5 usuarios.
 */
class BuscarUsuarios extends Component
{
    /**
     * Texto de búsqueda ingresado por el usuario.
     *
     * @var string
     */
    public $search = '';

    /**
     * Renderiza la vista del componente con los usuarios filtrados según el texto de búsqueda.
     *
     * - Si la búsqueda tiene menos de 2 caracteres, no retorna usuarios.
     * - Busca usuarios cuyo username contenga el texto de búsqueda.
     * - Solo incluye usuarios con rol "user".
     * - Limita el resultado a máximo 5 usuarios.
     *
     * @return \Illuminate\View\View Vista del componente con el array de usuarios encontrados
     */
    public function render()
    {
        $usuarios = [];

        if (strlen($this->search) >= 2) {
            $usuarios = User::where('username', 'like', '%' . $this->search . '%')
                ->where('rol', 'user')
                ->limit(5)
                ->get();
        }

        return view('livewire.buscar-usuarios', [
            'usuarios' => $usuarios
        ]);
    }
}
