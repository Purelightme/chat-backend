<?php


namespace App\Service;


use App\Exception\ApiException;
use App\Model\User;
use App\Repository\UserInfoRepository;
use App\Repository\UserRepository;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class UserService extends BaseService
{
    /**
     * @Inject()
     * @var UserRepository
     */
    protected $repository;

    /**
     * @Inject()
     * @var UserInfoRepository
     */
    protected $userInfoRepo;

    public function register($username,$password,array $extra = [])
    {
        if ($this->userInfoRepo->getByUsername($username))
            throw new ApiException('改用户名已被占用');
        return Db::transaction(function ()use ($username,$password,$extra){
            //新建user
            $user = new User();
            $user->chat_no = $this->repository->generateChatNo();
            $user->password = md5($password);
            $user->saveOrFail();
            //关联user_info
            if (!$user->user_info()->create([
                'username' => $username,
                'avatar' => $extra['avatar'] ?? '',
                'brief_desc' => '这个人还没有个性，所以木有签名~'
            ]))
                throw new \Exception('user_info关联失败');
            return $user;
        });
    }

    public function login($chatNo,$password)
    {
        if (!$user = $this->repository->getByChatNo($chatNo))
            throw new ApiException('该账号不存在');
        if ($user->password != md5($password))
            throw new ApiException('密码有误');
        return $user;
    }
}
