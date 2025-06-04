<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentApplySocities extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'notes',
        'available_month_id',
        'date',
        'society_id',
        'installment_id',
    ];

     // Relasi ke society
    public function society()
    {
        return $this->belongsTo(Societies::class);
    }

    // Relasi ke installment
    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    // Relasi ke statuses
    public function statuses()
    {
        return $this->hasMany(InstallmentApplyStatus::class, 'installment_apply_societies_id');
    }

    public function availableMonth()
    {
        return $this->belongsTo(AvaibleMonth::class, 'available_month_id');
    }


}
