<?php

namespace App\ViewModels;

use App\Models\Comment;
use App\Models\User;
use Spatie\ViewModels\ViewModel;

class CommentViewModel extends ViewModel
{
    use FormattableTimestamps;

    protected $ignore = ['itemsWithoutKey',];

    /**
     * @var Comment
     */
    private $comment;

    /**
     * @var User|null
     */
    private $loggedInUser;

    public function __construct(Comment $comment, ?User $loggedInUser)
    {
        $this->comment = $comment;
        $this->loggedInUser = $loggedInUser;
    }

    public function comment()
    {
        return [
            'id' => $this->comment->id,
            'createdAt' => $this->formatFrom($this->comment->created_at),
            'updatedAt' => $this->formatFrom($this->comment->updated_at),
            'body' => $this->comment->body,
            'author' => [
                'username' => $this->comment->user->user_name,
                'bio' => $this->comment->user->bio,
                'image' => $this->comment->user->image,
                'following' => $this->comment->user->followers->contains(
                    'id',
                    $this->loggedInUser->id ?? null
                )
            ]
        ];
    }

    public function itemsWithoutKey(): ?array
    {
        return $this->items()->get('comment');
    }
}
