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
        $startdate = $request->startdate;
        $rents = json_decode($request->rents);

        DB::beginTransaction();

        try {
            foreach($rents as $rent) {
                $Rent = Rent::create(['DVD_id' => $rent, 'name' => $name, 'start_date' => $startdate, 'flag' => 1]);
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
        $returns = json_decode($request->returns);

        DB::beginTransaction();

        try {
            foreach($returns as $return) {
                $Return = Rent::where(['DVD_id' => $return])->update(['flag' => 0]);
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
}
