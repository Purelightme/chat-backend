<?php


namespace App\Controller;


use App\Request\PostRequest;
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
 * Class PostController
 * @package App\Controller
 */
class PostController extends AbstractController
{
    /**
     * @Inject()
     * @var PostService
     */
    protected $service;

    /**
     * @Inject()
     * @var AuthManager
     */
    protected $auth;

    public function index(PostRequest $request)
    {
        $user = $this->auth->user();
        $columns = ['posts.id','content','username','avatar','posts.created_at'];
        $posts = $this->service->getPosts($user->id,$columns);
        return $this->buildSuccess([
            'total' => $posts->total(),
            'data' => $posts->items()
        ]);
    }

    public function store(PostRequest $request)
    {
        $user = $this->auth->user();
        $content = $request->input('content');
        $post = $this->service->publish($user->id,$content);
        return $this->buildSuccess($post);
    }

    public function update(PostRequest $request)
    {
        $user = $this->auth->user();
        $params = $request->all();
        $post = $this->service->modify($user->id,$params['id'],$params['content']);
        return $this->buildSuccess($post);
    }

    public function destroy(PostRequest $request)
    {
        $user = $this->auth->user();
        $this->service->delete($user->id,$request->input('id'));
        return $this->buildSuccess();
    }
}
