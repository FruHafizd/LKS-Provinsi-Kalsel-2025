<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Societies extends Model
{
    use HasApiTokens;
    protected $fillable = ['id_card_number','password','name','born_date','gender','regional_id','regional_id'];


    public function regional()  {
        return $this->belongsTo(Regional::class,'regional_id');
    }

    public function validation()  {
        return $this->hasMany(Validation::class, 'society_id');
    }
}
