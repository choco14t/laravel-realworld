<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'email' => $this->email,
                'token' => $this->token,
                'username' => $this->user_name,
                'bio' => $this->bio,
                'image' => $this->image,
            ],
        ];
    }
}
