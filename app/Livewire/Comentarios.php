<?php

namespace App\Livewire;

use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comentarios extends Component
{
    public $post;
    public $comentario;

    protected $rules = [
        'comentario' => 'required|max:255',
    ];

    public function comentar()
    {
        $this->validate();

        Comentario::create([
            'comentario' => $this->comentario,
            'user_id' => Auth::user()->id,
            'post_id' => $this->post->id,
        ]);

        $this->comentario = ''; // Limpiar textarea

        session()->flash('mensaje', 'Comentario agregado correctamente ✅');
    }

    public function render()
    {
        return view('livewire.comentarios', [
            'comentarios' => $this->post->comentarios()->latest()->get(),
        ]);
    }
}
