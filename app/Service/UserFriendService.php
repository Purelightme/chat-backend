<?php


namespace App\Service;


use App\Model\UserFriend;

class UserFriendService extends BaseService
{
    public function getFriends($userId,$columns)
    {
        return UserFriend::query()
            ->leftJoin('users','users.id','=','user_friends.friend_id')
            ->leftJoin('user_infos','user_infos.user_id','=','users.id')
            ->where('user_friends.user_id',$userId)
            ->select($columns)
            ->paginate();
    }
}
