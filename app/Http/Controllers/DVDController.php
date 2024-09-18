<?php

namespace App\Http\Controllers;

use Cloudinary;
use App\Models\DVD_list;
use App\Models\Role;
use App\Models\Role_group;
use App\Models\Role_photo;
use App\Models\Location;
use App\Models\Song;
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
        $DVDs = DVD_list::with(['locations','roles','photos','rents'=> function($query) {
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
              ->with(['locations', 'roles', 'roles.role_group:id,name', 'roles.role_photos', 'role_groups', 'songs', 'others', 'photos', 'rents'])->first();
        

        return $DVD ?? abort(404);
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
        $costumers = DVD_list::groupBy('costumer')->get(['costumer']);
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
        }])->get(['id', 'title', 'duration_from']);
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
        $costumer = !empty($request->costumer) ? $request->costumer : null;
        $lyricist = !empty($request->lyricist) ? $request->lyricist : null;
        $choreo = !empty($request->choreo) ? $request->choreo : null;
        $director = !empty($request->director) ? $request->director : null;
        $groups = !empty($request->group) ? $request->group : null;
        $roles = !empty($request->role) ? $request->role : null;
        $history = !empty($request->history) ? $request->history : null;
        $songs = !empty($request->song) ? $request->song : null;
        $others = !empty($request->other) ? $request->other : null;
        $photos = !empty($request->photo) ? $request->photo : null;
        $format = $request->format;
        $official = $request->official;
        $special = $request->special;
        $url_DVD = !empty($request->url_DVD) ? $request->url_DVD : null;
        $url_movie = !empty($request->url_movie) ? $request->url_movie : null;
        $category = !empty($request->category) ? (int)$request->category : null;
        $publics_id = array();

        DB::beginTransaction();

        try {
            $DVD = DVD_list::create(['title' => $request->title, 'kana' => $request->kana, 'duration_from' => $durationFrom, 'duration_to' => $durationTo, 'impression' => $impression, 'story' => $story, 'author' => $author, 'costumer' => $costumer, 'lyricist' => $lyricist, 'choreo' => $choreo, 'direcor' => $director, 'history' => $history, 'format' => $format, 'official' => $official, 'special' => $special, 'url_DVD' => $url_DVD, 'url_movie' => $url_movie, 'category' => $category]);
            if($locations){
                foreach($locations as $location) {
                    Location::create(['DVD_id' => $DVD->id, 'order' => (int)$location['order'], 'prefecture' => (int)$location['prefecture'], 'theater' => !empty($location['theater']) ? $location['theater'] : null]);
                }
            }
            $groups_id = array();
            if($groups){
                foreach($groups as $group) {
                    $data_group = Role_group::create(['DVD_id' => $DVD->id, 'order' => (int)$group['order'], 'name' => $group['name']]);
                    array_push($groups_id, ['group_id' => $data_group->id, 'key' => $group['key']]);
                }
            }
            if($roles){
                foreach($roles as $role) {
                    $group_id = null;
                    if($role['group_key']) {
                        $group_id_index = array_search($role['group_key'], array_column($groups_id, 'key'));
                        $group_id = $groups_id[$group_id_index]['group_id'];
                    }
                    $data_role = Role::create(['DVD_id' => $DVD->id, 'order' => (int)$role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => $role['impression']]);

                    foreach($role['photo'] as $photo) {                    
                        if($photo){
                            // Cloudinaryにファイルを保存する
                            $result = $photo->storeOnCloudinary($folder);
                            $url = $result->getSecurePath(); 
                            $public_id = $result->getPublicId();
                            
                            $publics_id[] = $public_id;
                            $data_role_photo = Role_photo::create(['DVD_id' => $DVD->id, 'role_id' => $data_role->id,  'order' => 1, 'public_id' => $public_id, 'url' => $url]);
                        }
                    }
                }
            }
            if($songs) {
                foreach($songs as $song) {
                    Song::create(['DVD_id' => $DVD->id, 'order' => (int)$song['order'], 'title' => $song['title'], 'impression' => $song['impression']]);
                }
            }
            if($others){
                foreach($others as $other) {
                    $data_other = Other:: create(['DVD_id' => $DVD->id, 'order' => (int)$other['order'], 'title' => $other['title'], 'impression' => $other['impression']]);
                }
            }
            if($photos){
                foreach($photos as $photo) {                    
                    if($photo){
                        // Cloudinaryにファイルを保存する
                        $result = $photo->storeOnCloudinary($folder);
                        $url = $result->getSecurePath(); 
                        $public_id = $result->getPublicId();
                        
                        $publics_id[] = $public_id;
                        $data_photo = Photo::create(['DVD_id' => $DVD->id, 'order' => 1, 'public_id' => $public_id, 'url' => $url]);
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
        $costumer = !empty($request->costumer) ? $request->costumer : null;
        $lyricist = !empty($request->lyricist) ? $request->lyricist : null;
        $choreo = !empty($request->choreo) ? $request->choreo : null;
        $director = !empty($request->director) ? $request->director : null;
        $groups = !empty($request->group) ? $request->group : null;
        $roles = !empty($request->role) ? $request->role : null;
        $history = !empty($request->history) ? $request->history : null;
        $songs = !empty($request->song) ? $request->song : null;
        $others = !empty($request->other) ? $request->other : null;
        $photos = !empty($request->photo) ? $request->photo : null;
        $format = (int)$request->format;
        $official = $request->official;
        $special = $request->special;
        $url_DVD = !empty($request->url_DVD) ? $request->url_DVD : null;
        $url_movie = !empty($request->url_movie) ? $request->url_movie : null;
        $category = !empty($request->category) ? (int)$request->category : null;
        $new_publics_id = array();
        $delete_publics_id = array();

        DB::beginTransaction();

        try {
            $DVD = DVD_list::where('id',$id)->update(['title' => $request->title, 'kana' => $request->kana, 'duration_from' => $durationFrom, 'duration_to' => $durationTo, 'impression' => $impression, 'story' => $story, 'author' => $author, 'costumer' => $costumer, 'lyricist' => $lyricist, 'choreo' => $choreo, 'director' => $director, 'history' => $history, 'format' => $format, 'official' => $official, 'special' => $special, 'url_DVD' => $url_DVD, 'url_movie' => $url_movie, 'category' => $category]);
            
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
                Location::where('id', $delete_locations)->delete();
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

            $delete_roles = Role::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $delete_role_photos = Role_photo::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_roles = array();
            $not_delete_role_photos = array();
            if($roles){
                foreach($roles as $role) {
                    $group_id = null;
                    if($role['group_key']) {
                        $group_id_index = array_search($role['group_key'], array_column($groups_id, 'key'));
                        $group_id = $groups_id[$group_id_index]['group_id'];
                    }
                    if($role['id']) {
                        $data_role = Role::find($role['id'])->fill(['order' => $role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => $role['impression']])->save();
                        $not_delete_roles[] = $role['id'];
                    } else {
                        $data_role = Role::create(['DVD_id' => $id, 'order' => $role['order'], 'role_group_id' => $group_id, 'role' => $role['role'], 'player' => $role['player'], 'member' => $role['member'], 'impression' => $role['impression']]);
                        $role['id'] = $data_role->id;
                    }

                    foreach($role['photo'] as $role_photo) {
                        if($role_photo['public_id']) {
                            // 元々：写真があった
                            if($role_photo['photo']) {
                                // 何もしない or 編集
                                $not_delete_role_photos[] = $role_photo['id'];
                                if(!$role_photo['url']) {
                                    // 編集
                                     // Cloudinaryにファイルを保存する
                                    $result = $role_photo['photo']->storeOnCloudinary($folder);
                                    $url = $result->getSecurePath(); 
                                    $public_id = $result->getPublicId();

                                    $delete_publics_id[] = $role_photo['public_id'];
                                    $new_publics_id[] = $public_id;
                                    Role_photo::find($role_photo['id'])->fill(['public_id' => $public_id, 'url' => $url])->save();
                                }
                            } else {
                                // 削除
                                $delete_publics_id[] = $role_photo['public_id'];
                            }
                        } else {
                            // 元々：写真がなかった
                            if($role_photo['photo']) {
                                // 新規
                                $result = $role_photo['photo']->storeOnCloudinary($folder);
                                $url = $result->getSecurePath(); 
                                $public_id = $result->getPublicId();
                                
                                $new_publics_id[] = $public_id;
                                Role_photo::create(['DVD_id' => $id, 'order' => 1, 'role_id' => $role['id'], 'public_id' => $public_id, 'url' => $url]);
                            }
                        }
                    }
                }
            }
            $delete_role_photos = array_diff($delete_role_photos, $not_delete_role_photos);
            $delete_role_photos = array_values($delete_role_photos);
            if(!empty($delete_role_photos)){
                Role_photo::where('id', $delete_role_photos)->delete();
            }
            $delete_roles = array_diff($delete_roles, $not_delete_roles);
            $delete_roles = array_values($delete_roles);
            if(!empty($delete_roles)) {
                Role::where('id', $delete_roles)->delete();
            }
            $delete_groups = array_diff($delete_groups, $not_delete_groups);
            $delete_groups = array_values($delete_groups);
            if(!empty($delete_groups)) {
                Role_group::where('id', $delete_groups)->delete();
            }

            $delete_songs = Song::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_songs = array();
            if($songs){
                foreach($songs as $song) {
                    if($song['id']) {
                        Song::find($song['id'])->fill(['order' => $song['order'], 'title' => $song['title'], 'impression' => $song['impression']])->save();
                        $not_delete_songs[] = $song['id'];
                    } else {
                        Song::create(['DVD_id' => $id, 'order' => $song['order'], 'title' => $song['title'], 'impression' => $song['impression']]);
                    } 
                }
            }
            $delete_songs = array_diff($delete_songs, $not_delete_songs);
            $delete_songs = array_values($delete_songs);
            if(!empty($delete_songs)) {
                Song::where('id', $delete_songs)->delete();
            }

            $delete_others = Other::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_others = array();
            if($others){
                foreach($others as $other) {
                    if($other['id']) {
                        Other::find($other['id'])->fill(['order' => $other['order'], 'title' => $other['title'], 'impression' => $other['impression']])->save();
                        $not_delete_others[] = $other['id'];
                    } else {
                        Other::create(['DVD_id' => $id, 'order' => $other['order'], 'title' => $other['title'], 'impression' => $other['impression']]);
                    } 
                }
            }
            $delete_others = array_diff($delete_others, $not_delete_others);
            $delete_others = array_values($delete_others);
            if(!empty($delete_others)) {
                Other::where('id', $delete_others)->delete();
            }

            $delete_photos = Photo::where('DVD_id', $id)->get()->pluck('id')->toArray();
            $not_delete_photos = array();
            if($photos){
                foreach($photos as $photo) { 
                    if($photo['public_id']) {
                        // 元々：写真があった
                        if($photo['photo']) {
                            // 何もしない or 編集
                            $not_delete_photos[] = $photo['id'];
                            if(!$photo['url']) {
                                // 編集
                                 // Cloudinaryにファイルを保存する
                                $result = $photo['photo']->storeOnCloudinary($folder);
                                $url = $result->getSecurePath(); 
                                $public_id = $result->getPublicId();

                                $delete_publics_id[] = $photo['public_id'];
                                $new_publics_id[] = $public_id;
                                Photo::find($photo['id'])->fill(['public_id' => $public_id, 'url' => $url])->save();
                            }
                        } else {
                            // 削除
                            $delete_publics_id[] = $photo['public_id'];
                        }
                    } else {
                        // 元々：写真がなかった
                        if($photo['photo']) {
                            // 新規
                            $result = $photo['photo']->storeOnCloudinary($folder);
                            $url = $result->getSecurePath(); 
                            $public_id = $result->getPublicId();
                            
                            $new_publics_id[] = $public_id;
                            Photo::create(['DVD_id' => $id, 'role_id' => $role['id'], 'order' => 1, 'public_id' => $public_id, 'url' => $url]);
                        }
                    }
                }
            }
            $delete_photos = array_diff($delete_photos, $not_delete_photos);
            $delete_photos = array_values($delete_photos);
            if(!empty($delete_photos)) { 
                Photo::where('id', $delete_photos)->delete();
            }

            DB::commit();

            if(!empty($delete_publics_id)) {
                foreach($delete_publics_id as $public_id) {
                    Cloudinary::destroy($public_id);
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