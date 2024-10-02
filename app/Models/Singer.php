<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Singer extends Model
{
    protected $table = 'singer';
    
    /** 取得時にJSONに含める属性 */
    protected $visible = [
        'id', 'DVD_id', 'song_id', 'order', 'role_id', 'role_group_id', 'name', 'created_at', 'updated_at',
        'role', 'role_group'
    ];

    /** 登録時にJSONに含める属性 */
    protected $fillable = [
        'id', 'DVD_id', 'song_id', 'order', 'role_id', 'role_group_id', 'name'
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y/m/d H:i:s');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('Y/m/d H:i:s');
    }

    /**
     * リレーションシップ - DVD_listテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function DVD_list()
    {
        return $this->belongsTo('App\Models\DVD_list', 'DVD_id');
    }

    /**
     * リレーションシップ - songテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function song()
    {
        return $this->belongsTo('App\Models\song', 'song_id');
    }

    /**
     * リレーションシップ - role_groupテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }

    /**
     * リレーションシップ - role_groupテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role_group()
    {
        return $this->belongsTo('App\Models\Role_group','role_group_id');
    }
}

?>