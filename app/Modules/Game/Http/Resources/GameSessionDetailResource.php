<?php

namespace App\Modules\Game\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameSessionDetailResource extends JsonResource
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
            'coin_type' => $this->coin_type,
            'game_session' => $this->gameSession->game_session ?? '',
            'game_name' => $this->gameSession->game->name ?? '',
            'coin' => $this->coin,
            'game_fee' => $this->game_fee,
            'game_fee_percentage' => $this->game_fee_percentage,
            'remark' => $this->remark,
        ];
    }
}
