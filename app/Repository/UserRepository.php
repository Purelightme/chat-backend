<?php


namespace App\Repository;


use App\Model\User;
use Hyperf\Di\Annotation\Inject;

class UserRepository extends BaseRepository
{
    /**
     * @Inject()
     * @var User
     */
    protected $model;

    public function getByChatNo($chatNo)
    {
        return $this->model->newQuery()->where('chat_no',$chatNo)->first();
    }

    public function generateChatNo()
    {
        $chatNo = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).
            rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        if ($this->getByChatNo($chatNo)){
            return $this->generateChatNo();
        }else{
            return $chatNo;
        }
    }
}
