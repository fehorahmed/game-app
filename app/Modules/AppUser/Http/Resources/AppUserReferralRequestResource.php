<?php

namespace App\Modules\AppUser\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppUserReferralRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' =>  $this->type ?? 'PENDING',
            'status' =>  $this->status,
            'app_user' => new AppUserResource($this->appUser),

        ];
    }
}
