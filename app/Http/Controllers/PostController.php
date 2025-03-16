<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller; // Add this line

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); 
    }

    public function index(User $user){
        return view('dashboard', [
            'user' => $user
        ]); 
    }

    public function create(){
        return view('posts.create');
    }
}
