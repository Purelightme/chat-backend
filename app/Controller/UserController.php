<?php


namespace App\Controller;


use App\Request\UserRequest;
use App\Service\UserService;
use Carbon\Carbon;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Qbhy\HyperfAuth\AuthManager;

/**
 * @AutoController()
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @Inject()
     * @var UserService
     */
    protected $service;

    public function register(UserRequest $request)
    {
        $params = $request->all();
        $user = $this->service->register($params['username'],$params['password'],$params);
        return $this->buildSuccess($user);
    }

    public function login(UserRequest $request)
    {
        $params = $request->validated();
        $user = $this->service->login($params['chat_no'],$params['password']);
        $token = $this->auth->login($user);
        return $this->buildSuccess(['token' => $token,'user' => [
            'id' => $user->id,
            'username' => $user->user_info->username,
            'avatar' => $user->user_info->avatar,
            'brief_desc' => $user->user_info->brief_desc,
            'live_time' => Carbon::now()->diffForHumans($user->created_at),
        ]]);
    }

    public function info(RequestInterface $request)
    {
        $user = $this->auth->user();
        return $this->buildSuccess([
            'id' => $user->id,
            'username' => $user->user_info->username,
            'avatar' => $user->user_info->avatar,
            'brief_desc' => $user->user_info->brief_desc,
            'live_time' => Carbon::now()->diffForHumans($user->created_at),
        ]);
    }
}
