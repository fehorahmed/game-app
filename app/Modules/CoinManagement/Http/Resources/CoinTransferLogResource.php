<?php

namespace App\Modules\CoinManagement\Http\Resources;

use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoinTransferLogResource extends JsonResource
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
            "given_by" => new AppUserResource(AppUser::find($this->given_by)),
            "received_by" => new AppUserResource(AppUser::find($this->received_by)),
            "coin" => $this->coin,
            "created_at" => $this->created_at,
        ];
    }
}
