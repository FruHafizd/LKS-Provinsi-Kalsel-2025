<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = ['brand_id','cars','description','price'];

    public function brand()  {
        return $this->belongsTo(Brand::class);
    }

    public function avaibleMonth()  {
        return $this->hasMany(AvaibleMonth::class);
    }

    public function applications()
    {
        return $this->hasMany(InstallmentApplySocities::class, 'installment_id');
    }
}
