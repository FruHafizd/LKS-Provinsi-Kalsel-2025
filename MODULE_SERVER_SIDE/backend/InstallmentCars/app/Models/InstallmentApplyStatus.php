<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentApplyStatus extends Model
{   
    public $timestamps = false;

    protected $fillable = [
        'date',
        'society_id',
        'installment_id',
        'available_month_id',
        'installment_apply_societies_id',
        'status',
    ];

    public function society()
    {
        return $this->belongsTo(Societies::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function availableMonth()
    {
        return $this->belongsTo(AvaibleMonth::class, 'available_month_id');
    }

    public function applySociety()
    {
        return $this->belongsTo(InstallmentApplySocities::class, 'installment_apply_societies_id');
    }
}
