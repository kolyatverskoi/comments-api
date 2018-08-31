<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\AddCommentRequest;
use App\Http\Requests\EditCommentRequest;
use Illuminate\Http\Resources\Json\Resource;

/**
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    /**
     * @param $postId
     * @param AddCommentRequest $request
     * @param Comment $commentSource
     * @return Resource
     */
    public function add(int $postId, AddCommentRequest $request, Comment $commentSource) : Resource
    {
        $comment = $commentSource->newInstance([
            'post_id' => $postId,
            'message' => $request->input('message'),
            'parent_id' => $request->input('parent_id'),
        ]);
        $comment->save();

        return new Resource($comment);
    }

    /**
     * @param Comment $comment
     * @param EditCommentRequest $request
     * @return Resource
     */
    public function edit(Comment $comment, EditCommentRequest $request) : Resource
    {
        $comment->setAttribute('message', $request->input('message'));

        !$comment->isDirty() ?: $comment->save();

        return new Resource($comment);
    }

    /**
     * @param Comment $comment
     * @return Resource
     * @throws \Exception
     */
    public function remove(Comment $comment) : Resource
    {
        $comment->delete();

        return new Resource($comment);
    }
}
