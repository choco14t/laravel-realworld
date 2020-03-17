<?php

namespace App\ViewModels;

use App\Eloquents\EloquentComment;
use App\Eloquents\EloquentUser;
use Spatie\ViewModels\ViewModel;

class CommentViewModel extends ViewModel
{
    protected $ignore = ['itemsWithoutKey',];

    /**
     * @var EloquentComment
     */
    private $comment;

    /**
     * @var EloquentUser|null
     */
    private $loggedInUser;

    public function __construct(EloquentComment $comment, ?EloquentUser $loggedInUser)
    {
        $this->comment = $comment;
        $this->loggedInUser = $loggedInUser;
    }

    public function comment()
    {
        return [
            'id' => $this->comment->id,
            'createdAt' => $this->comment->created_at->toAtomString(),
            'updatedAt' => $this->comment->updated_at->toAtomString(),
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
