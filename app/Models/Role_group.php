<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Role_group extends Model
{
    protected $table = 'role_group';
    
    /** 取得時にJSONに含める属性 */
    protected $visible = [
        'id', 'DVD_id', 'order', 'name', 'created_at', 'updated_at',
    ];
 
    /** 登録時にJSONに含める属性 */
    protected $fillable = [
        'id', 'DVD_id', 'order', 'name'
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
     * リレーションシップ - roleテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->hasMany('App\Models\Role');
    }

    /**
     * リレーションシップ - singerテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function singer()
    {
        return $this->hasMany('App\Models\Singer');
    }
}