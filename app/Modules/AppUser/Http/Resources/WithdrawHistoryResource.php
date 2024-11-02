<?php

namespace App\Modules\AppUser\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "payment_method_id"=>$this->method->name??'',
            "app_user_id"=>$this->app_user_id,
            "withdraw_date"=>$this->withdraw_date,
            "amount"=>$this->amount,
            "charge"=>$this->charge,
            "total"=>$this->total,
            "transaction_id"=>$this->transaction_id,
            "account_no"=>$this->account_no,
            "creator"=>$this->creator,
            "accept_date"=>$this->accept_date,
            "accept_by"=>$this->accept_by,
            "created_by"=>$this->created_by,
            "status"=>Helper::deposit_withdraw_status($this->status),
            "updated_by"=>$this->updated_by,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
