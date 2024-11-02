<?php

namespace App\Modules\AppUser\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'payment_method_id'=>$this->method->name??'',
            'payment_method_name'=>$this->method->name??'',
            'app_user_id'=>$this->app_user_id,
            'deposit_date'=>$this->deposit_date,
            'amount'=>$this->amount,
            'charge'=>$this->charge,
            'total'=>$this->total,
            'transaction_id'=>$this->transaction_id,
            'accept_date'=>$this->accept_date,
            'accept_by'=>$this->accept_by,
            'created_by'=>$this->created_by,
            'status'=>Helper::deposit_withdraw_status($this->status),
            'updated_by'=>$this->updated_by,
        ];
    }
}
