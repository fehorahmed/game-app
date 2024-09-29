<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\DataTable\WithdrawLogDataTable;
use App\Modules\AppUserBalance\Models\WithdrawLog;
use Illuminate\Http\Request;

class WithdrawLogController extends Controller
{
    public function withdrawRequest(WithdrawLogDataTable $dataTable)
    {

        return $dataTable->render("AppUserBalance::withdraw.request");
    }
    public function updateWithdrawStatus(Request $request)
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
                    $app_user_balance->save();
                } else {
                    $app_user_balance->balance += $data->amount;
                    $app_user_balance->update();
                }

                $app_user_b_d = new AppUserBalanceDetail();
                $app_user_b_d->app_user_balance_id = $app_user_balance->id;
                $app_user_b_d->source = 'DEPOSIT';
                $app_user_b_d->balance_type = 'ADD';
                $app_user_b_d->balance = $data->amount;
                $app_user_b_d->deposit_log_id = $data->id;
                $app_user_b_d->save();

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
                return response([
                    'status' => true,
                    'message' => 'Deposit canceled !'
                ]);
            }
        }
    }
}
