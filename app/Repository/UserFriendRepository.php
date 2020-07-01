<?php


namespace App\Repository;


use App\Model\UserFriend;
use Hyperf\Di\Annotation\Inject;

class UserFriendRepository extends BaseRepository
{
    /**
     * @Inject()
     * @var UserFriend
     */
    protected $model;

    public function isFriend($userId,$friendId)
    {
        return $this->model->newQuery()
            ->where([
                ['user_id',$userId],
                ['friend_id',$friendId]
            ])
            ->exists();
    }
}
