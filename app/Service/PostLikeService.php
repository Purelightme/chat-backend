<?php


namespace App\Service;


use App\Exception\ApiException;
use App\Model\PostLike;

class PostLikeService extends BaseService
{
    public function like($userId,$postId)
    {
        if ($this->hasLiked($userId,$postId))
            throw new ApiException('您已点过赞啦');
        $postLike = new PostLike();
        $postLike->user_id = $userId;
        $postLike->post_id = $postId;
        $postLike->saveOrFail();
    }

    public function unLike($userId,$postId)
    {
        if (!$this->hasLiked($userId,$postId))
            throw new ApiException('您未点过赞');
        $postLike = PostLike::query()->where([
            ['user_id',$userId],
            ['post_id',$postId]
        ])->firstOrFail();
        $postLike->delete();
    }

    public function hasLiked($userId,$postId)
    {
        return PostLike::query()->where([
            ['user_id',$userId],
            ['post_id',$postId]
        ])->exists();
    }
}
