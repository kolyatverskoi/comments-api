<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;

class RemoveCommentTest extends TestCase
{
    /**
     * @var Comment
     */
    private $comment;

    public function testRemoveComment()
    {
        $this->comment = factory(Comment::class)->create();

        $this
            ->postJson("/api/comments/{$this->comment->id}/remove")
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->comment->id,
                'message' => $this->comment->message,
            ]);
    }
}
