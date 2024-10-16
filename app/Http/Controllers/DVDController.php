<?php

namespace App\Http\Controllers;

use Cloudinary;
use App\Models\DVD_list;
use App\Models\Role;
use App\Models\Role_group;
use App\Models\Role_photo;
use App\Models\Location;
use App\Models\Costumer;
use App\Models\History;
use App\Models\Song;
use App\Models\Singer;
use App\Models\Other;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\StorePhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

date_default_timezone_set('Asia/Tokyo'); 

class DVDController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DVDs = DVD_list::with(['locations','costumers', 'roles','photos','rents'=> function($query) {
            $query->where('flag', 1);
        }])->orderByRaw('duration_from is null asc')->orderBy('duration_from')->get();
        return $DVDs;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $DVD = DVD_list::where('id', $id)
              ->with(['locations', 'costumers', 'roles', 'roles.role_group:id,name', 'roles.role_photos', 'role_groups', 'histories', 'songs', 'songs.singers', 'songs.singers.role', 'songs.singers.role_group', 'others', 'photos', 'rents'])->first();
        

        return $DVD ?? abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function theater()
    {
        $locations = Location::groupBy('theater')->get(['theater']);
        return $locations;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function author()
    {
        $authors = DVD_list::groupBy('author')->get(['author']);
        return $authors;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function costumer()
    {
        $costumers = Costumer::groupBy('name')->get(['name']);
        return $costumers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lyricist()
    {
        $lyricists = DVD_list::groupBy('lyricist')->get(['lyricist']);
        return $lyricists;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choreo()
    {
        $choreos = DVD_list::groupBy('choreo')->get(['choreo']);
        return $choreos;
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function director()
    {
        $choreos = DVD_list::groupBy('director')->get(['director']);
        return $choreos;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rent()
    {
        $DVD = DVD_list::with(['rents' => function($query) {
            $query->where('flag', 1)->max('start_date');
        }])->get(['id', 'title', 'duration_from', 'adaptation', 'own']);
        // $DVD = DVD_list::with(['rents:name,flag,start_date' => function($query) {
        //     $query->where('flag', 1);
        // }])->get();
        //->orderByRaw('duration_from is null asc')->orderBy('duration_from')->get('id', 'title', 'duration_from');

        return $DVD ?? abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePhoto $request_photo
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folder = 'DVD_manager_local';
        
        $durationFrom = !empty($request->durationFrom) ? $request->durationFrom : null;
        $durationTo = !empty($request->durationTo) ? $request->durationTo : null;
        $locations = !empty($request->location) ? $request->location : null;
        $impression = !empty($request->impression) ? $request->impression : null;
        $story = !empty($request->story) ? $request->story : null;
        $author = !empty($request->author) ? $request->author : null;
        $costumers = !empty($request->costumer) ? $request->costumer : null;
        $lyricist = !empty($request->lyricist) ? $request->lyricist : null;
        $choreo = !empty($request->choreo) ? $request->choreo : null;
        $director = !empty($request->director) ? $request->director : null;
        $groups = !empty($request->group) ? $request->group : null;
        $roles = !empty($request->role) ? $request->role : null;
        $histories = !empty($request->history) ? $request->history : null;
        $songs = !empty($request->song) ? $request->song : null;
        $others = !empty($request->other) ? $request->other : null;
        $photos = !empty($request->photo) ? $request->photo : null;
        $adaptation = $request->adaptation;
        $own = $request->own;
        $official = $request->official;
        $format = $request->format;
        $special = $request->special;
        $url_DVD = !empty($request->url_DVD) ? $request->url_DVD : null;
        $url_movie = !empty($request->url_movie) ? $request->url_movie : null;
        $url_youtube = !empty($request->url_youtube) ? $request->url_youtube : null;
        $category = !empty($request->category) ? (int)$request->category : null;
        $publics_id = array();

        DB::beginTransaction();

        try {
            $DVD = DVD_list::create(['title' => $request->title, 'kana' => $request->kana, 'duration_from' => $durationFrom, 'duration_to' => $durationTo, 'impression' => $impression, 'story' => $story, 'author' => $author, 'lyricist' => $lyricist, 'choreo' => $choreo, 'direcor' => $director, 'adaptation' => $adaptation, 'own' => $own, 'official' => $official, 'format' => $format, 'special' => $special, 'url_DVD' => $url_DVD, 'url_movie' => $url_movie, 'url_youtube' => $url_youtube, 'category' => $category]);
            
            if($locations){
                foreach($locations as $location) {
                    Location::create(['DVD_id' => $DVD->id, 'order' => (int)$location['order'], 'prefecture' => (int)$location['prefecture'], 'theater' => !empty($location['theater']) ? $location['theater'] : null]);
                }
            }
            
            if($costumers){
                foreach($costumers as $costumer) {
                    Costumer::create(['DVD_id' => $DVD->id, 'order' => (int)$costumer['order'], 'name' => $costumer['name']]);
                }
            }
            
            $groups_id = array();
            if($groups){
                foreach($groups as $group) {
                    $data_group = Role_group::create(['DVD_id' => $DVD->id, 'order' => (int)$group['order'], 'name' => $group['name']]);
                    array_push($groups_id, ['group_id' => $data_group->id, 'key' => $group['key']]);
                }
            }

            $roles_id = array();
            if($roles){
                foreach($roles as $role) {
                    $group_id = null;
                    if($role['group_key']) {
                        $group_id_index = array_search($role['group_key'], array_column($groups_id, 'key'));
                        $group_id = $groups_id[$group_id_index]['group_id'];
                    }
                    $data_role = Role::create(['DVD_id' => $DVD->id, 'order' => (int)$role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => $role['impression']]);
                    array_push($roles_id, ['role_id' => $data_role->id, 'key' => $role['key']]);

                    foreach($role['photo'] as $photo) {                    
                        if($photo){
                            // Cloudinaryにファイルを保存する
                            $result = $photo['photo']->storeOnCloudinary($folder);
                            $url = $result->getSecurePath(); 
                            $public_id = $result->getPublicId();
                            
                            $publics_id[] = $public_id;
                            Role_photo::create(['DVD_id' => $DVD->id, 'role_id' => $data_role->id,  'order' => $photo['order'], 'public_id' => $public_id, 'url' => $url]);
                        }
                    }
                }
            }
            
            if($histories) {
                foreach($histories as $history) {
                    History::create(['DVD_id' => $DVD->id, 'order' => (int)$history['order'], 'title' => !empty($history['title']) ? $history['title'] : null, 'impression' => $history['history']]);
                }
            }
            
            if($songs) {
                foreach($songs as $song) {
                    $data_song = Song::create(['DVD_id' => $DVD->id, 'order' => (int)$song['order'], 'title' => $song['title'], 'impression' => !empty($song['impression']) ? $song['impression'] : null]);
                    
                    if(!empty($song['singer'])) {
                        foreach($song['singer'] as $singer) {
                            var_dump($singer);
                            if($singer['type'] === 'role') {
                                $role_id_index = array_search($singer['name'], array_column($roles_id, 'key'));
                                $role_id = $roles_id[$role_id_index]['role_id'];
                                Singer::create(['DVD_id' => $DVD->id, 'song_id' => $data_song->id, 'order' => (int)$singer['order'], 'role_id' => $role_id]);
                            } else if($singer['type'] === 'group') {
                                $group_id_index = array_search($singer['name'], array_column($groups_id, 'key'));
                                $group_id = $groups_id[$group_id_index]['group_id'];
                                Singer::create(['DVD_id' => $DVD->id, 'song_id' => $data_song->id, 'order' => (int)$singer['order'], 'role_group_id' => $group_id]);
                            } else if($singer['type'] === 'name') {
                                Singer::create(['DVD_id' => $DVD->id, 'song_id' => $data_song->id, 'order' => (int)$singer['order'], 'name' => $singer['name']]);
                            }
                        }
                    }
                }
            }

            if($others){
                foreach($others as $other) {
                    $data_other = Other:: create(['DVD_id' => $DVD->id, 'order' => (int)$other['order'], 'title' => !empty($other['title']) ? $other['title'] : null, 'impression' => !empty($other['impression']) ? $other['impression'] : null ]);
                }
            }
            
            if($photos){
                foreach($photos as $photo) {                    
                    if($photo['photo']){
                        // Cloudinaryにファイルを保存する
                        $result = $photo['photo']->storeOnCloudinary($folder);
                        $url = $result->getSecurePath(); 
                        $public_id = $result->getPublicId();
                        
                        $publics_id[] = $public_id;
                        $data_photo = Photo::create(['DVD_id' => $DVD->id, 'order' => (int)$photo['order'], 'public_id' => $public_id, 'url' => $url]);
                    }
                }
            }

            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();

            if(count($publics_id) != 0) {
                foreach($publics_id as $public_id) {
                    Cloudinary::destroy($public_id);
                }
            }
            
            throw $exception;
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($DVD, 201) ?? abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePhoto $request_photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $folder = 'DVD_manager_local';

        $durationFrom = !empty($request->duration_from) ? $request->duration_from : null;
        $durationTo = !empty($request->duration_to) ? $request->duration_to : null;
        $locations = !empty($request->location) ? $request->location : null;
        $impression = !empty($request->impression) ? $request->impression : null;
        $story = !empty($request->story) ? $request->story : null;
        $author = !empty($request->author) ? $request->author : null;
        $costumers = !empty($request->costumer) ? $request->costumer : null;
        $lyricist = !empty($request->lyricist) ? $request->lyricist : null;
        $choreo = !empty($request->choreo) ? $request->choreo : null;
        $director = !empty($request->director) ? $request->director : null;
        $groups = !empty($request->group) ? $request->group : null;
        $roles = !empty($request->role) ? $request->role : null;
        $histories = !empty($request->history) ? $request->history : null;
        $songs = !empty($request->song) ? $request->song : null;
        $others = !empty($request->other) ? $request->other : null;
        $photos = !empty($request->photo) ? $request->photo : null;
        $adaptation = $request->adaptation;
        $own = $request->own;
        $official = $request->official;
        $format = (int)$request->format;
        $special = $request->special;
        $url_DVD = !empty($request->url_DVD) ? $request->url_DVD : null;
        $url_movie = !empty($request->url_movie) ? $request->url_movie : null;
        $url_youtube = !empty($request->url_youtube) ? $request->url_youtube : null;
        $category = !empty($request->category) ? (int)$request->category : null;
        $new_publics_id = array();
        $delete_public_ids = array();

        DB::beginTransaction();

        try {
            DVD_list::where('id',$id)->update(['title' => $request->title, 'kana' => $request->kana, 'duration_from' => $durationFrom, 'duration_to' => $durationTo, 'impression' => $impression, 'story' => $story, 'author' => $author, 'lyricist' => $lyricist, 'choreo' => $choreo, 'director' => $director, 'adaptation' => $adaptation, 'own' => $own, 'official' => $official, 'format' => $format, 'special' => $special, 'url_DVD' => $url_DVD, 'url_movie' => $url_movie, 'url_youtube' => $url_youtube, 'category' => $category]);
            
            $delete_locations = Location::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_locations = array();
            if($locations){
                foreach($locations as $location) {
                    if(!empty($location['id'])) {
                        Location::find($location['id'])->fill(['order' => (int)$location['order'], 'prefecture' => !empty($location['prefecture']) ? (int)$location['prefecture'] : null, 'theater' => !empty($location['theater']) ? $location['theater'] : null])->save();
                        $not_delete_locations[] = $location['id'];
                    } else {
                        Location::create(['DVD_id' => $id, 'order' => (int)$location['order'], 'prefecture' => !empty($location['prefecture']) ? (int)$location['prefecture'] : null, 'theater' => !empty($location['theater']) ? $location['theater'] : null]);
                    }                    
                }
            }
            $delete_locations = array_diff($delete_locations,$not_delete_locations);
            $delete_locations = array_values($delete_locations);
            if(!empty($delete_locations)) {
                Location::destroy($delete_locations);
            }

            $delete_costumers = Costumer::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_costumers = array();
            if($costumers){
                foreach($costumers as $costumer) {
                    if(!empty($costumer['id'])) {
                        Costumer::find($costumer['id'])->fill(['order' => (int)$costumer['order'], 'name' => $costumer['name']])->save();
                        $not_delete_costumers[] = $costumer['id'];
                    } else {
                        Costumer::create(['DVD_id' => $id, 'order' => (int)$costumer['order'], 'name' => $costumer['name']]);
                    }                    
                }
            }
            $delete_costumers = array_diff($delete_costumers,$not_delete_costumers);
            $delete_costumers = array_values($delete_costumers);
            if(!empty($delete_costumers)) {
                Costumer::destroy($delete_costumers);
            }

            $groups_id = array();
            $delete_groups = Role_group::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_groups = array();
            if($groups){
                foreach($groups as $group) {
                    if(!empty($group['id'])) {
                        $data_group = Role_group::find($group['id'])->fill(['order' => $group['order'], 'name' => $group['name']])->save();
                        $not_delete_groups[] = $group['id'];
                    } else {
                        $data_group = Role_group::create(['DVD_id' => $id, 'order' => $group['order'], 'name' => $group['name']]);
                    }
                    array_push($groups_id, ['group_id' => $group['id'] ? $group['id'] : $data_group->id, 'key' => $group['key']]);
                }
            }

            $roles_id = array();
            $delete_roles = Role::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $delete_role_photos = Role_photo::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $delete_public_ids = array_merge($delete_public_ids, Role_photo::where('DVD_id', $id)->get()->pluck('public_id')->toArray());
            $not_delete_roles = array();
            $not_delete_role_photos = array();
            $not_delete_public_ids = array();
            if($roles){
                foreach($roles as $role) {
                    $group_id = null;
                    if($role['group_key']) {
                        $group_id_index = array_search($role['group_key'], array_column($groups_id, 'key'));
                        $group_id = $groups_id[$group_id_index]['group_id'];
                    }
                    if($role['id']) {
                        $data_role = Role::find($role['id'])->fill(['order' => $role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => !empty($role['impression']) ? $role['impression'] : null ])->save();
                        $not_delete_roles[] = $role['id'];
                    } else {
                        $data_role = Role::create(['DVD_id' => $id, 'order' => $role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => !empty($role['impression']) ? $role['impression'] : null ]);
                        $role['id'] = $data_role->id;
                    }
                    array_push($roles_id, ['role_id' => $role['id'] ? $role['id'] : $data_role->id, 'key' => $role['key']]);

                    if(!empty($role['photo'])) {
                        foreach($role['photo'] as $role_photo) {
                            if($role_photo['public_id']) {
                                if($role_photo['photo']) {
                                    // 編集
                                    $not_delete_role_photos[] = $role_photo['id'];
                                    if(!$role_photo['url']) {
                                        // 写真変更
                                        // Cloudinaryにファイルを保存する
                                        $result = $role_photo['photo']->storeOnCloudinary($folder);
                                        $url = $result->getSecurePath(); 
                                        $public_id = $result->getPublicId();
    
                                        $new_publics_id[] = $public_id;
                                        Role_photo::find($role_photo['id'])->fill(['order' => $role_photo['order'], 'public_id' => $public_id, 'url' => $url])->save();
                                    } else {
                                        // 順番変更（変更がある場合のみ編集がかかるようにしてある）
                                        Role_photo::find($role_photo['id'])->fill(['order' => $role_photo['order']])->save();
                                        $not_delete_public_ids[] = $role_photo['public_id'];
                                    }
                                }
                            } else {
                                if($role_photo['photo']) {
                                    // 新規
                                    $result = $role_photo['photo']->storeOnCloudinary($folder);
                                    $url = $result->getSecurePath(); 
                                    $public_id = $result->getPublicId();
                                    
                                    $new_publics_id[] = $public_id;
                                    Role_photo::create(['DVD_id' => $id, 'order' => $role_photo['order'], 'role_id' => $role['id'], 'public_id' => $public_id, 'url' => $url]);
                                }
                            }
                        }
                    }
                    
                }
            }
            $delete_role_photos = array_diff($delete_role_photos, $not_delete_role_photos);
            $delete_role_photos = array_values($delete_role_photos);
            if(!empty($delete_role_photos)){
                Role_photo::destroy($delete_role_photos);
            }            
            $delete_public_ids = array_diff($delete_public_ids, $not_delete_public_ids);
            $delete_public_ids = array_values($delete_public_ids);

            $delete_roles = array_diff($delete_roles, $not_delete_roles);
            $delete_roles = array_values($delete_roles);
            if(!empty($delete_roles)) {
                Role::destroy($delete_roles);
            }
            $delete_groups = array_diff($delete_groups, $not_delete_groups);
            $delete_groups = array_values($delete_groups);
            if(!empty($delete_groups)) {
                Role_group::destroy($delete_groups);
            }

            $delete_histories = History::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_histories = array();
            if($histories){
                foreach($histories as $history) {
                    if($history['id']) {
                        History::find($history['id'])->fill(['order' => $history['order'], 'title' => !empty($history['title']) ? $history['title'] : null, 'history' => $history['history']])->save();
                        $not_delete_histories[] = $history['id'];
                    } else {
                        History::create(['DVD_id' => $id, 'order' => $history['order'], 'title' => !empty($history['title']) ? $history['title'] : null, 'history' => $history['history']]);
                    } 
                }
            }
            $delete_histories = array_diff($delete_histories, $not_delete_histories);
            $delete_histories = array_values($delete_histories);
            if(!empty($delete_histories)) {
                History::destroy($delete_histories);
            }

            $delete_songs = Song::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_songs = array();
            $delete_singers = Singer::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_singers = array();
            if($songs){
                foreach($songs as $song) {
                    if($song['id']) {
                        Song::find($song['id'])->fill(['order' => $song['order'], 'title' => $song['title'], 'impression' => $song['impression']])->save();
                        $not_delete_songs[] = $song['id'];
                    } else {
                        $data_song = Song::create(['DVD_id' => $id, 'order' => $song['order'], 'title' => $song['title'], 'impression' => $song['impression']]);
                        $song['id'] = $data_song->id;
                    }
                    
                    if(!empty($song['singer'])) {
                        foreach($song['singer'] as $singer) {
                            if($singer['id']) {
                                if($singer['type'] === 'role') {
                                    $role_id_index = array_search($singer['name'], array_column($roles_id, 'key'));
                                    $role_id = $roles_id[$role_id_index]['role_id'];

                                    Singer::find($singer['id'])->fill(['song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => $role_id, 'role_group_id' => null, 'name' => null])->save();
                                } else if($singer['type'] === 'group') {
                                    $group_id_index = array_search($singer['name'], array_column($groups_id, 'key'));
                                    $group_id = $groups_id[$group_id_index]['group_id'];

                                    Singer::find($singer['id'])->fill(['song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => null, 'role_group_id' => $group_id, 'name' => null])->save();
                                } else if($singer['type'] === 'name') {
                                    var_dump($singer);
                                    Singer::find($singer['id'])->fill(['song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => null, 'role_group_id' => null, 'name' => $singer['name']])->save();
                                }
                                $not_delete_singers[] = $singer['id'];
                            } else {
                                if($singer['type'] === 'role') {
                                    $role_id_index = array_search($singer['name'], array_column($roles_id, 'key'));
                                    $role_id = $roles_id[$role_id_index]['role_id'];

                                    Singer::create(['DVD_id' => $id, 'song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => $role_id, 'role_group_id' => null, 'name' => null]);
                                } else if($singer['type'] === 'group') {
                                    $group_id_index = array_search($singer['name'], array_column($groups_id, 'key'));
                                    $group_id = $groups_id[$group_id_index]['group_id'];

                                    Singer::create(['DVD_id' => $id, 'song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => null, 'role_group_id' => $group_id, 'name' => null]);
                                } else if($singer['type'] === 'name') {
                                    Singer::create(['DVD_id' => $id, 'song_id' => $song['id'], 'order' => $singer['order'], 'role_id' => null, 'role_group_id' => null, 'name' => $singer['name']]);
                                }
                            }
                        }
                    }                    
                }
            }
            $delete_songs = array_diff($delete_songs, $not_delete_songs);
            $delete_songs = array_values($delete_songs);
            if(!empty($delete_songs)) {
                Song::destroy($delete_songs);
            }
            $delete_singers = array_diff($delete_singers, $not_delete_singers);
            $delete_singers = array_values($delete_singers);
            if(!empty($delete_singers)) {
                Singer::destroy($delete_singers);
            }

            $delete_others = Other::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_others = array();
            if($others){
                foreach($others as $other) {
                    if($other['id']) {
                        Other::find($other['id'])->fill(['order' => $other['order'], 'title' => !empty($other['title']) ? $other['title'] : null, 'impression' => !empty($other['impression']) ? $other['impression'] : null])->save();
                        $not_delete_others[] = $other['id'];
                    } else {
                        Other::create(['DVD_id' => $id, 'order' => $other['order'], 'title' => !empty($other['title']) ? $other['title'] : null, 'impression' => !empty($other['impression']) ? $other['impression'] : null]);
                    } 
                }
            }
            $delete_others = array_diff($delete_others, $not_delete_others);
            $delete_others = array_values($delete_others);
            if(!empty($delete_others)) {
                Other::destroy($delete_others);
            }

            $delete_photos = Photo::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $delete_public_ids = array_merge($delete_public_ids, Photo::where('DVD_id', $id)->get()->pluck('public_id')->toArray());
            $not_delete_photos = array();
            $not_delete_public_ids = array();
            if($photos){
                foreach($photos as $photo) { 
                    if($photo['public_id']) {
                        // 編集
                        $not_delete_photos[] = $photo['id'];
                        if(!$photo['url']) {
                            // 写真変更
                            // Cloudinaryにファイルを保存する
                            $result = $photo['photo']->storeOnCloudinary($folder);
                            $url = $result->getSecurePath(); 
                            $public_id = $result->getPublicId();

                            $new_publics_id[] = $public_id;
                            Photo::find($photo['id'])->fill(['order' => $photo['order'], 'public_id' => $public_id, 'url' => $url])->save();
                        } else {
                            // 順番変更（変更がある場合のみ編集がかかるようにしてある）
                            Photo::find($photo['id'])->fill(['order' => $photo['order']])->save();
                            $not_delete_public_ids[] = $photo['public_id'];
                        }
                    } else {
                        // 新規
                        $result = $photo['photo']->storeOnCloudinary($folder);
                        $url = $result->getSecurePath(); 
                        $public_id = $result->getPublicId();
                        
                        $new_publics_id[] = $public_id;
                        Photo::create(['DVD_id' => $id, 'order' => $photo['order'], 'public_id' => $public_id, 'url' => $url]);
                    }
                }
            }
            $delete_photos = array_diff($delete_photos, $not_delete_photos);
            $delete_photos = array_values($delete_photos);
            if(!empty($delete_photos)) { 
                Photo::destroy($delete_photos);
            }
            $delete_public_ids = array_diff($delete_public_ids, $not_delete_public_ids);
            $delete_public_ids = array_values($delete_public_ids);

            DB::commit();

            if(!empty($delete_public_ids)) {
                foreach($delete_public_ids as $delete_public_id) {
                    Cloudinary::destroy($delete_public_id);
                }
            }
        }catch (\Exception $exception) {
            DB::rollBack();

            if(!empty($new_publics_id)) {
                foreach($new_publics_id as $public_id) {
                    Cloudinary::destroy($public_id);
                }
            }
            
            throw $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $role_photo_public_id = Role_photo::where('DVD_id', $id)->get('public_id')->toArray();
            
            $photo_public_id = Photo::where('DVD_id', $id)->get('public_id')->toArray();

            $DVD = DVD_list::where('id', $id)->delete();      

            DB::commit();

            if(!$DVD){
                throw new Exception('意図されない処理が実行されました。');
            }

            if(!empty($role_photo_public_id)){
                foreach($role_photo_public_id as $public_id) {
                    if($public_id['public_id']) {
                        Cloudinary::destroy($public_id['public_id']);
                    }
                }
            }

            if(!empty($photo_public_id)){
                foreach($photo_public_id as $public_id) {
                    if($public_id['public_id']) {
                        Cloudinary::destroy($public_id['public_id']);
                    }
                }                
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            
            throw $exception;
        }

        return response($DVD, 204) ?? abort(404);
    }
}
