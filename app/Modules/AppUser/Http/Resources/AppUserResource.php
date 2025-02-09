<?php

namespace App\Modules\AppUser\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppUserResource extends JsonResource
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
            "email" => $this->email,
            "mobile" => $this->mobile,
            "user_id" => $this->user_id,
            "email_verified_at" => $this->email_verified_at,
            "mobile_verified_at" => $this->mobile_verified_at,
            "photo" => $this->photo ?  asset('storage/' . $this->photo) : asset('assets/images/users/user-4.jpg'),
            // "images/profile/1717179327-5.jpg",
            "referral_id" => $this->referral_id,
            "status" => 1,
            "star" => $this->balance->star ?? 0,
            "total_members" => count(Helper::get_all_referral_user_ids($this->user_id)),
            "total_star_income" => $this->totalStarIncome->sum('amount'),

        ];
    }
}
