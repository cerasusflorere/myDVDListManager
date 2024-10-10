<?php

namespace App\Http\Controllers;


use App\Models\DVD_list;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

date_default_timezone_set('Asia/Tokyo'); 

class RentController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $start_date = $request->start_date;
        $rents = json_decode($request->rents);

        DB::beginTransaction();

        try {
            foreach($rents as $rent) {
                $Rent = Rent::create(['DVD_id' => $rent, 'name' => $name, 'start_date' => $start_date, 'flag' => 1]);
            }
            
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
        
        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($Rent, 201) ?? abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $return_date = $request->return_date;
        $returns = json_decode($request->returns);

        DB::beginTransaction();

        try {
            foreach($returns as $return) {
                $Return = Rent::where(['DVD_id' => $return])->update(['return_date' => $return_date, 'flag' => 0]);
            }
            
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
        
        // リソースの新規作成なので
        // レスポンスコードは200(OK)を返却する
        return response($Return, 200) ?? abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        $DVD_id = $request->DVD_id;
        $rents = $request->rent;

        DB::beginTransaction();

        try {
            $delete_rents = Rent::where('DVD_id', $DVD_id)->get()->pluck('id')->toArray();
            $not_delete_rents = array();
            if(!empty($rents)) {
                foreach($rents as $rent) {
                    $id = $rent['id'];
                    if(!empty($rent['id'])) {
                        $rent = Rent::find($rent['id'])->fill(['name' => $rent['name'], 'start_date' => $rent['start_date'] ? $rent['start_date'] : null, 'return_date' => $rent['return_date'] ? $rent['return_date'] : null, 'flag' => ($rent['start_date'] && !$rent['return_date']) ? 1 : 0 ])->save();
                        $not_delete_rents[] = $id;
                    } else {
                        $rent = Rent::create(['DVD_id' => $DVD_id, 'name' => $rent['name'], 'start_date' => $rent['start_date'], 'return_date' => $rent['return_date'], 'flag' => $rent['start_date'] && !$rent['return_date'] ? 1 : 0 ]);
                    }                
                }
                $delete_rents = array_diff($delete_rents,$not_delete_rents);
                $delete_rents = array_values($delete_rents);
            }
            
            if(!empty($delete_rents)) {
                $rent = Rent::destroy($delete_rents);
            }
            
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
        
        // リソースの新規作成なので
        // レスポンスコードは200(OK)を返却する
        return response($rent, 200) ?? abort(404);
    }
}
