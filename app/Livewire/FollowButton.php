<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public $user;
    public $isFollowing;
    public $followersCount;

    public function mount($user)
    {
        $this->user = $user;
        $this->isFollowing = $user->siguiendo(Auth::user());
        $this->followersCount = $user->followers->count();
    }

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

    public function render()
    {
        return view('livewire.follow-button');
    }
}