<?php

namespace App\ViewModels;

use App\Models\User;
use Spatie\ViewModels\ViewModel;

class UserViewModel extends ViewModel
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user()
    {
        return [
            'email' => $this->user->email,
            'token' => $this->user->token,
            'username' => $this->user->user_name,
            'bio' => $this->user->bio,
            'image' => $this->user->image
        ];
    }
}
