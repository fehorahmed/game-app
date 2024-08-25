<?php

namespace App\Modules\AppUserBalance\Models;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositLog extends Model
{
    use HasFactory;
    public function method(){
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
}
