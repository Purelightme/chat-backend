<?php


namespace App\Service;


use App\Exception\ApiException;
use App\Model\User;

class UserSearchService extends BaseService
{
    public function searchByChatNo($chatNo,$columns)
    {
        $user = User::query()
            ->leftJoin('user_infos','user_infos.user_id','=','users.id')
            ->where('chat_no',$chatNo)
            ->select($columns)
            ->first();
        if (!$user)
            throw new ApiException('无效账号');
        return $user;
    }
}
