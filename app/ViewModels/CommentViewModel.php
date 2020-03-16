<?php

namespace App\ViewModels;

use App\Eloquents\EloquentComment;
use Spatie\ViewModels\ViewModel;

class CommentViewModel extends ViewModel
{
    protected $ignore = ['itemsWithoutKey',];

    /**
     * @var EloquentComment
     */
    private $comment;

    public function __construct(EloquentComment $comment)
    {
        $this->comment = $comment;
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
                'following' => false
            ]
        ];
    }

    public function itemsWithoutKey(): ?array
    {
        return $this->items()->get('comment');
    }
}
