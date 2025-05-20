<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class BuscarUsuarios extends Component
{
    public $search = '';

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