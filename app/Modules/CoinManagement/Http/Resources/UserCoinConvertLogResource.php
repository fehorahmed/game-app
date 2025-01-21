<?php

namespace App\Modules\CoinManagement\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCoinConvertLogResource extends JsonResource
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
            "app_user_id"=>$this->app_user_id,
            "coin"=>$this->coin,
            "coin_rate"=>$this->coin_rate,
            "balance"=>$this->balance,
            "created_at"=>$this->created_at,

        ];
    }
}
