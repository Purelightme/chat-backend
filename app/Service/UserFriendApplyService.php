<?php


namespace App\Service;


use App\Exception\ApiException;
use App\Model\UserFriend;
use App\Model\UserFriendApply;
use App\Repository\UserFriendApplyRepository;
use App\Repository\UserFriendRepository;
use App\Repository\UserRepository;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class UserFriendApplyService
{
    /**
     * @Inject()
     * @var UserFriendApplyRepository
     */
    protected $repository;

    /**
     * @Inject()
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @Inject()
     * @var UserFriendRepository
     */
    protected $userFriendRepo;

    public function getApplies($userId,$columns)
    {
        return UserFriendApply::query()
            ->leftJoin('users','users.id','=','user_friend_appliers.user_id')
            ->leftJoin('user_infos','user_infos.user_id','=','users.id')
            ->where('user_friend_appliers.user_id',$userId)
            ->select($columns)
            ->paginate();
    }

    public function apply($userId,$params)
    {
        $friend = $this->userRepo->getByChatNo($params['chat_no']);
        if (!$friend)
            throw new ApiException('账号有误');
        if ($friend->user_id == $userId)
            throw new ApiException('不能添加自己为好友哦~');
        if ($this->userFriendRepo->isFriend($userId,$friend->id))
            throw new ApiException('对方已经是您的好友');
        if ($this->repository->existsInHandle($userId,$friend->id))
            throw new ApiException('不要重复申请哦~');
        $apply = new UserFriendApply();
        $apply->user_id = $userId;
        $apply->friend_id = $friend->id;
        $apply->remark = $params['remark'] ?? '';
        $apply->status = UserFriendApply::STATUS_CREATED;
        $apply->saveOrFail();
        return $apply;
    }

    public function handle($id,$userId,$status)
    {
        $apply = UserFriendApply::query()->findOrFail($id);
        if ($apply->friend_id != $userId)
            throw new ApiException('暂无权限');
        if ($apply->status != UserFriendApply::STATUS_CREATED)
            throw new ApiException('该条申请已处理过了');
        Db::transaction(function ()use ($apply,$status){
            $apply->status = $status;
            $apply->saveOrFail();
            if ($status == UserFriendApply::STATUS_PASS){
                //处理好友关系
                $user = new UserFriend();
                $user->user_id = $apply->user_id;
                $user->friend_id = $apply->friend_id;
                $user->saveOrFail();
                $friend = new UserFriend();
                $friend->user_id = $apply->friend_id;
                $friend->friend_id = $apply->user_id;
                $friend->saveOrFail();
            }
        });
        return $apply;
    }
}
