<?php


namespace App\Service;


use App\Exception\ApiException;
use App\Model\Post;
use App\Model\User;
use App\Model\UserFriend;

class PostService extends BaseService
{
    /**
     * 我的动态|所有动态
     *
     * @param int $userId
     * @param array $columns
     * @return \Hyperf\Contract\LengthAwarePaginatorInterface|\Hyperf\Contract\PaginatorInterface
     */
    public function getPosts($userId = 0,$columns = ['*'])
    {
        $query = Post::query()
            ->leftJoin('user_infos','user_infos.user_id','=','posts.user_id');
        if (!empty($userId)){
            $query = $query->where('posts.user_id',$userId);
        }
        return $query->latest()->select($columns)->paginate();
    }

    public function getUserPosts($userId,$columns = ['*'])
    {
        $friends = UserFriend::query()->where('user_id',$userId)
            ->select(['friend_id'])->get();
        $userIds = $friends->pluck('friend_id')->push($userId)->toArray();
        $posts = Post::query()
            ->leftJoin('user_infos','user_infos.user_id','=','posts.user_id')
            ->whereIn('posts.user_id',$userIds)
            ->latest()
            ->select($columns)
            ->paginate();
        return $posts;
    }

    public function publish($userId,$content)
    {
        $post = new Post();
        $post->user_id = $userId;
        $post->content = $content;
        $post->saveOrFail();
        return $post;
    }

    public function modify($userId,$id,$content)
    {
        $post = $this->checkPermission($userId,$id);
        $post->content = $content;
        $post->saveOrFail();
        return $post;
    }

    public function checkPermission($userId,$id)
    {
        $post = Post::query()->findOrFail($id);
        if ($post->user_id != $userId)
            throw new ApiException('暂无权限');
        return $post;
    }

    public function delete($userId,$id)
    {
        $post = $this->checkPermission($userId,$id);
        return $post->delete();
    }
}
