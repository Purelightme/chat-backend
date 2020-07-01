<?php


namespace App\Repository;


use App\Model\UserInfo;
use Hyperf\Di\Annotation\Inject;

class UserInfoRepository extends BaseRepository
{
    /**
     * @Inject()
     * @var UserInfo
     */
    protected $model;

    public function getByUsername($username)
    {
        return $this->model->newQuery()->where('username',$username)->first();
    }
}
