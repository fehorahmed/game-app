<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "account_no" => $this->account_no,
            "account_type" => $this->account_type,
            "manual_text" => $this->manual_text,
            "limit_start" => $this->limit_start,
            "limit_end" => $this->limit_end,
            "withdraw_limit_start" => $this->withdraw_limit_start,
            "withdraw_limit_end" => $this->withdraw_limit_end,
            "transaction_fee" => $this->transaction_fee,
            "logo" => $this->logo ? asset($this->logo) : null,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
