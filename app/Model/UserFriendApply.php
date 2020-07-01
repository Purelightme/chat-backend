<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property string $remark
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class UserFriendApply extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_friend_applies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'friend_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    const STATUS_MAP = [
        self::STATUS_CREATED => '等待处理',
        self::STATUS_REFUSE => '已拒绝',
        self::STATUS_PASS => '已同意'
    ];
    const STATUS_CREATED = 1;
    const STATUS_REFUSE = 2;
    const STATUS_PASS = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class,'friend_id');
    }
}
