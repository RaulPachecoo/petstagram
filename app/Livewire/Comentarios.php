<?php

namespace App\Livewire;

use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Componente Livewire para gestionar los comentarios de un post.
 *
 * Permite a los usuarios autenticados agregar comentarios a un post específico,
 * validando el contenido y mostrando los comentarios existentes.
 */
class Comentarios extends Component
{
    /**
     * El post al que se están agregando comentarios.
     *
     * @var Post
     */
    public $post;

    /**
     * Contenido del comentario que se está escribiendo.
     *
     * @var string
     */
    public $comentario;

    /**
     * Reglas de validación para el comentario.
     *
     * @var array
     */
    protected $rules = [
        'comentario' => 'required|max:255',
    ];

    /**
     * Valida y crea un nuevo comentario asociado al post y usuario autenticado.
     *
     * Luego limpia el campo de texto y muestra un mensaje flash de confirmación.
     */
    public function comentar()
    {
        $this->validate();

        Comentario::create([
            'comentario' => $this->comentario,
            'user_id' => Auth::user()->id,
            'post_id' => $this->post->id,
        ]);

        // Limpiar textarea después de enviar el comentario
        $this->comentario = '';

        session()->flash('mensaje', 'Comentario agregado correctamente ✅');
    }

    /**
     * Renderiza la vista con los comentarios más recientes del post.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.comentarios', [
            'comentarios' => $this->post->comentarios()->latest()->get(),
        ]);
    }
}
