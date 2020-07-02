<?php


namespace App\Controller;


use App\Service\PostService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\AuthMiddleware;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * Class PostViewController
 * @package App\Controller
 */
class PostViewController extends AbstractController
{
    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    /**
     * @Inject()
     * @var PostService
     */
    protected $service;

    public function index()
    {
        $user = $this->auth->user();
        $columns = ['posts.id','posts.user_id','content','username','avatar','posts.created_at'];
        $posts = $this->service->getUserPosts($user->id,$columns);
        return $this->buildSuccess([
            'total' => $posts->total(),
            'data' => $posts->items()
        ]);
    }
}
