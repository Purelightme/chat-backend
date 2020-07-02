<?php


namespace App\Controller;


use App\Request\PostLikeRequest;
use App\Service\PostLikeService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\AuthMiddleware;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * Class PostLikeController
 * @package App\Controller
 */
class PostLikeController extends AbstractController
{
    /**
     * @Inject()
     * @var PostLikeService
     */
    protected $service;

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    public function like(PostLikeRequest $request)
    {
        $user = $this->auth->user();
        $this->service->like($user->id,$request->input('post_id'));
        return $this->buildSuccess();
    }

    public function unLike(PostLikeRequest $request)
    {
        $user = $this->auth->user();
        $this->service->unLike($user->id,$request->input('post_id'));
        return $this->buildSuccess();
    }
}
