<?php


namespace App\Controller;


use App\Service\UserFriendService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\AuthMiddleware;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * Class UserFriendController
 * @package App\Controller
 */
class UserFriendController extends AbstractController
{
    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @Inject()
     * @var UserFriendService
     */
    protected $service;

    public function index()
    {
        $user = $this->auth->user();
        $columns = ['friend_id','chat_no','username','avatar','brief_desc','user_friends.created_at'];
        $friends = $this->service->getFriends($user->id,$columns);
        return $this->buildSuccess([
            'total' => $friends->total(),
            'data' => $friends->items()
        ]);
    }
}
