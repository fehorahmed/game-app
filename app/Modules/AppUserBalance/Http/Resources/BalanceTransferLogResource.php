<?php

namespace App\Modules\AppUserBalance\Http\Resources;

use App\Modules\AppUser\Http\Resources\AppUserResource;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceTransferLogResource extends JsonResource
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
            "give_to"=>new AppUserResource(AppUser::find($this->received_by)),
            "balance"=>$this->balance,

        ];
    }
}
