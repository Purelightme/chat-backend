<?php


namespace App\Service;


use App\Model\PostComment;

class PostCommentService extends BaseService
{
    public function getComments($postId,$columns = ['*'])
    {
        return PostComment::query()
            ->leftJoin('posts','posts.id','=','post_comments.post_id')
            ->leftJoin('user_infos','user_infos.user_id','=','post_comments.user_id')
            ->with('response_user')
            ->where('post_id',$postId)
            ->orderByDesc('post_comments.created_at')
            ->select($columns)
            ->paginate();
    }

    public function comment($userId,$postId,$content,$responseUserId = 0)
    {
        $comment = new PostComment();
        $comment->user_id = $userId;
        $comment->post_id = $postId;
        $comment->content = $content;
        if (!empty($responseUserId)){
            $comment->response_user_id = $responseUserId;
        }
        $comment->saveOrFail();
        return $comment;
    }
}
