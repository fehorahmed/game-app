<?php

namespace App\Modules\AppUserBalance\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\AppUserBalance\Models\AppUserBalance;
use App\Modules\AppUserBalance\Models\AppUserBalanceDetail;
use App\Modules\AppUserBalance\Models\StarLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StarLogController extends Controller
{

    public function userStarBuy()
    {
        $star = auth()->user()->balance->star;

        $amount = Helper::get_star_price($star + 1);

        if (auth()->user()->balance->balance < $amount) {
            return response([
                'status' => false,
                'message' => 'You do not have enough balance.'
            ]);
        }


        $transactionFail = false;

        DB::beginTransaction();

        try {
            $star_log = new StarLog();
            $star_log->app_user_id = auth()->id();
            $star_log->date = now();
            $star_log->price = $amount;
            $star_log->star_amount = 1;
            $star_log->creator = 'user';
            $star_log->created_by = auth()->id();
            if ($star_log->save()) {
                $app_u_b = AppUserBalance::where('app_user_id', auth()->id())->first();
                $app_u_b->balance -= $amount;
                $app_u_b->star = $app_u_b->star + 1;
                if ($app_u_b->update()) {
                    $b_log = new AppUserBalanceDetail();
                    $b_log->app_user_balance_id = $app_u_b->id;
                    $b_log->source = 'STAR';
                    $b_log->balance_type = 'SUB';
                    $b_log->balance = $amount;
                    $b_log->star_log_id = $star_log->id;
                    if (!$b_log->save()) {
                        $transactionFail = true;
                    }
                } else {
                    $transactionFail = true;
                }
            } else {
                $transactionFail = true;
            }

            if ($transactionFail) {
                DB::rollBack();
                return response([
                    'status' => false,
                    'message' => 'Something went wrong'
                ]);
            } else {
                DB::commit();
                return response([
                    'status' => true,
                    'message' => 'Star claim successfully.'
                ]);
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StarLog $starLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StarLog $starLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StarLog $starLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StarLog $starLog)
    {
        //
    }
}
