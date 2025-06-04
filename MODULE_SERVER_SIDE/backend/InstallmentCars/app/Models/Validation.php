<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    protected $fillable = ['society_id','validator_id','status','job','job_description','income','reason_accepted','validator_notes'];

    public $timestamps = false;

    public function socities()  {
        return $this->belongsTo(Societies::class);
    }

    public function validator()  {
        return $this->belongsTo(Validator::class);
    }
}
