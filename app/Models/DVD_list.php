<?php

    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Arr;

    class DVD_list extends Model
    {
        protected $table = 'dvd_list';
        
        /** 取得時にJSONに含める属性 */
        protected $visible = [
            'id', 'title', 'kana', 'duration_from', 'duration_to', 'impression', 'story', 'author', 'costumer', 'lyricist', 'choreo', 'director', 
            'history', 'format', 'official', 'special', 'url_DVD', 'url_movie', 'category', 'created_at', 'updated_at',
            'locations', 'roles', 'role_groups', 'songs', 'others', 'photos', 'rents'
        ];
    
        /** 登録時にJSONに含める属性 */
        protected $fillable = [
            'id', 'title', 'kana', 'duration_from', 'duration_to', 'impression', 'story', 'author', 'costumer', 'lyricist', 'choreo', 'director', 
            'history', 'format', 'official', 'special', 'url_DVD', 'url_movie', 'category', 'rent'
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
         * リレーションシップ - locationsテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function locations()
        {
            return $this->hasMany('App\Models\Location', 'DVD_id');
        }

        /**
         * リレーションシップ - rolesテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function roles()
        {
            return $this->hasMany('App\Models\Role', 'DVD_id');
        }

        /**
         * リレーションシップ - role_groupsテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
         */
        public function role_groups()
        {
            return $this->hasMany('App\Models\Role_group', 'DVD_id');
        }

        /**
         * リレーションシップ - songsテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function songs()
        {
            return $this->hasMany('App\Models\Song', 'DVD_id');
        }

        /**
         * リレーションシップ - othersテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function others()
        {
            return $this->hasMany('App\Models\Other', 'DVD_id');
        }

        /**
         * リレーションシップ - photosテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function photos()
        {
            return $this->hasMany('App\Models\Photo', 'DVD_id');
        }

        /**
         * リレーションシップ - rentsテーブル
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function rents()
        {
            return $this->hasMany('App\Models\Rent', 'DVD_id');
        }
    }

?>