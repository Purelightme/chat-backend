<?php


namespace App\Repository;


use App\Exception\ApiException;
use App\Model\UserFriendApply;
use Hyperf\Di\Annotation\Inject;

class UserFriendApplyRepository extends BaseRepository
{
    /**
     * @Inject()
     * @var UserFriendApply
     */
    protected $model;

    public function existsInHandle($userId,$friendId)
    {
        return $this->model->newQuery()
            ->where([
                ['user_id',$userId],
                ['friend_id',$friendId],
                ['status',UserFriendApply::STATUS_CREATED]
            ])->exists();
    }
}
