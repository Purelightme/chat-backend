<?php


namespace App\Controller;


use App\Request\UserFriendApplyRequest;
use App\Service\UserFriendApplyService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\AuthMiddleware;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * Class UserFriendApplyController
 * @package App\Controller
 */
class UserFriendApplyController extends AbstractController
{
    /**
     * @Inject()
     * @var UserFriendApplyService
     */
    protected $service;

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    public function index(UserFriendApplyRequest $request)
    {
        $user = $this->auth->user();
        $columns = ['user_friend_applies.id','chat_no','username','avatar','brief_desc','remark','status'];
        $applies = $this->service->getApplies($user->id,$columns);
        return $this->buildSuccess([
            'total' => $applies->total(),
            'data' => $applies->items()
        ]);
    }

    public function store(UserFriendApplyRequest $request)
    {
        $params = $request->all();
        $user = $this->auth->user();
        $this->service->apply($user->id,$params);
        return $this->buildSuccess();
    }

    public function handle(UserFriendApplyRequest $request)
    {
        $params = $request->all();
        $user = $this->auth->user();
        $this->service->handle($params['id'],$user->id,$params['status']);
        return $this->buildSuccess();
    }
}
