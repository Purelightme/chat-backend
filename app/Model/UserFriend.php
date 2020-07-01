<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class UserFriend extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_friends';
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'friend_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class,'friend_id');
    }
}
