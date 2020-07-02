<?php


namespace App\Controller;


use App\Request\PostCommentRequest;
use App\Service\PostCommentService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;
use Qbhy\HyperfAuth\AuthManager;
use Qbhy\HyperfAuth\AuthMiddleware;

/**
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * Class PostCommentController
 * @package App\Controller
 */
class PostCommentController extends AbstractController
{
    /**
     * @Inject()
     * @var PostCommentService
     */
    protected $service;

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    public function index(PostCommentRequest $request)
    {
        $postId = $request->input('post_id');
        $columns = ['post_comments.user_id','posts.user_id as author_id','post_comments.content','username'];
        $posts = $this->service->getComments($postId,$columns);
        return $this->buildSuccess([
            'total' => $posts->total(),
            'data' => $posts->items()
        ]);
    }

    public function store(PostCommentRequest $request)
    {
        $user = $this->auth->user();
        $params = $request->all();
        $comment = $this->service->comment($user->id,$params['post_id'],$params['content'],$params['response_user_id'] ?? 0);
        return $this->buildSuccess($comment);
    }
}
