<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaibleMonth extends Model
{
    protected $fillable = ['installment_id','month','description','nominal'];

    public function installment()  {
        return $this->belongsTo(Installment::class);
    }

    public function installmentApplySocieties()
    {
        return $this->hasMany(InstallmentApplySocities::class, 'available_month_id');
    }
}
