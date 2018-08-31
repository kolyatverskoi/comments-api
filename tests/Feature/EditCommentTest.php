<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validEditCommentCases
     */
    public function testEditComment($oldMessage, $newMessage)
    {
        $comment = factory(Comment::class)->create(['message' => $oldMessage]);

        $this
            ->postJson("/api/comments/{$comment->id}/edit", ['message' => $newMessage])
            ->assertStatus(200)
            ->assertJsonFragment([
                'post_id' => $comment->post_id,
                'message' => $newMessage,
                'parent_id' => $comment->parent_id,
            ]);
    }

    public function validEditCommentCases()
    {
        return [
            ['Old', 'New'],
            ['Text', 'Text'],
        ];
    }
}
