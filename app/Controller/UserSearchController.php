<?php


namespace App\Controller;


use App\Exception\ApiException;
use App\Service\UserSearchService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 * Class UserSearchController
 * @package App\Controller
 */
class UserSearchController extends AbstractController
{
    /**
     * @Inject()
     * @var UserSearchService
     */
    protected $service;

    public function index()
    {
        $chatNo = $this->request->input('chat_no','');
        if (empty($chatNo))
            throw new ApiException('无效的chat_no');
        $columns = ['users.id','chat_no','username','avatar','brief_desc'];
        $user = $this->service->searchByChatNo($chatNo,$columns);
        return $this->buildSuccess($user);
    }
}
