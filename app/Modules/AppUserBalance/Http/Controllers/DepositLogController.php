<?php

namespace App\Modules\AppUserBalance\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\DataTable\DepositLogDataTable;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\AppUserBalance\Models\DepositLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepositLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function depositRequest(DepositLogDataTable $dataTable)
    {

        return $dataTable->render("AppUserBalance::deposit.request");
    }
    public function updateDepositStatus(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'status' => 'required|string'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response([
                'status' => false,
                'message' => $validation->errors()->first()
            ]);
        }

        DB::beginTransaction();
        $transactionFail =false;

        try {
            $data = DepositLog::find($request->id);
            if ($request->status == 'accept') {
                $data->status = 2;
                $data->accept_by = auth()->id();
                $data->updated_by = auth()->id();
                $data->accept_date = Carbon::now();
                if ($data->save()) {
                    $app_user_balance = AppUserBalance::where('app_user_id', $data->app_user_id)->first();
                    if (!$app_user_balance) {
                        $app_user_balance = new AppUserBalance();
                        $app_user_balance->app_user_id = $data->app_user_id;
                        $app_user_balance->balance = $data->amount;
                        if(!$app_user_balance->save()){
                            $transactionFail =true;
                        }
                    } else {
                        $app_user_balance->balance += $data->amount;
                        if(!$app_user_balance->update()){
                            $transactionFail =true;
                        }
                    }

                    $app_user_b_d = new AppUserBalanceDetail();
                    $app_user_b_d->app_user_balance_id = $app_user_balance->id;
                    $app_user_b_d->source = 'DEPOSIT';
                    $app_user_b_d->balance_type = 'ADD';
                    $app_user_b_d->balance = $data->amount;
                    $app_user_b_d->deposit_log_id = $data->id;
                    if(!$app_user_b_d->save()){
                        $transactionFail =true;
                    }


                }else{
                    $transactionFail =true;
                }


                if($transactionFail){
                    DB::rollBack();
                    return response([
                        'status' => false,
                        'message' => 'Something went wrong.'
                    ]);
                }else{
                    DB::commit();
                    return response([
                        'status' => true,
                        'message' => 'Deposit accepted successfully'
                    ]);
                }
            }
            if ($request->status == 'cancel') {
                $data->status = 0;
                $data->updated_by = auth()->id();
                if ($data->save()) {

                    DB::commit();
                    return response([
                        'status' => true,
                        'message' => 'Deposit canceled !'
                    ]);

                }else{
                    DB::rollBack();
                    return response([
                        'status' => false,
                        'message' => 'Something went wrong.'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }


    }
}
