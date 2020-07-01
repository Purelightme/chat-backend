<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;
use Qbhy\HyperfAuth\Authenticatable;

/**
 * @property int $id
 * @property string $chat_no
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class User extends Model implements Authenticatable
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
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
    protected $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function getId()
    {
        return $this->id;
    }

    public static function retrieveById($key): ?Authenticatable
    {
        return self::query()->find($key);
    }

    public function user_info()
    {
        return $this->hasOne(UserInfo::class);
    }
}
