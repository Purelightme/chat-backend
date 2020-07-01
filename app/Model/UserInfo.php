<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;
use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $avatar
 * @property string $brief_desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class UserInfo extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_infos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username','avatar','brief_desc'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
