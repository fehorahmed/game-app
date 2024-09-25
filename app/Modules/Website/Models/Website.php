<?php

namespace App\Modules\Website\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;



    public function websiteList(){
        return $this->hasMany(WebsiteList::class,'website_id','id');
    }
}
