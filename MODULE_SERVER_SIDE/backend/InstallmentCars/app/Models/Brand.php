<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['brand'];

    public function installment()  {
        return $this->hasMany(Installment::class);
    }
}
