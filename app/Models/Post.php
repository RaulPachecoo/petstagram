<?php

namespace App\Models;

use App\Models\PostView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory; 

    protected $fillable = [
        'titulo',
        'descripcion', 
        'imagen', 
        'user_id'
    ]; 

    public function user(){
        return $this->belongsTo(User::class)->select([
            'name', 
            'username', 
            'imagen'
        ]); 
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class); 
    }
    
    public function likes(){
        return $this->hasMany(Like::class); 
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function checkLike(User $user){
        return $this->likes->contains('user_id', $user->id); 
    }
}
