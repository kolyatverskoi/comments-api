<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testAddComment()
    {
        $testPostId = 1;
        $testCommentMessage = 'Test message';

        $this
            ->postJson("/api/posts/$testPostId/comments", ['message' => $testCommentMessage])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'message' => $testCommentMessage,
                    'parent_id' => 0,
                    'post_id' => $testPostId,
                ]
            ])
        ;
    }

    public function testAddCommentOnComment()
    {
        $parentComment = factory(Comment::class)->create();
        $testPostId = 1;
        $testCommentMessage = 'Test message';

        $this
            ->postJson(
                "/api/posts/$testPostId/comments",
                ['message' => $testCommentMessage, 'parent_id' => $parentComment->id]
            )
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'post_id' => $testPostId,
                    'message' => $testCommentMessage,
                    'parent_id' => $parentComment->id,
                ]
            ])
        ;
    }

    public function testAddCommentOnNonExistentComment()
    {
        $nonExistentComment = 8;

        $this
            ->postJson(
                '/api/posts/1/comments',
                ['message' => 'Test', 'parent_id' => $nonExistentComment]
            )
            ->assertStatus(422)
            ->assertJsonFragment(
                ['parent_id' => ['The selected parent id is invalid.']]
            )
        ;
    }
}
