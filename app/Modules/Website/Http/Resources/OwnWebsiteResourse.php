<?php

namespace App\Modules\Website\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnWebsiteResourse extends JsonResource
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
            "name"=>$this->name,
            "url"=>$this->url,
            "visiting_url"=>$this->url.'?other_user='.auth()->id().'&other_visiting_id='.$this->id.'&other_url='.route('user.web_visiting_list'),
            "coin"=>$this->coin,
            "created_by"=>$this->created_by,
            "status"=>$this->status,
        ];
    }
}
