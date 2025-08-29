<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    protected $table = 'utilities';
    protected $fillable = [
        'name',
        'image_url',
        'state',
        'city',
        'country',
    ];

    public function rateRanges()
    {
        return $this->hasMany(\Modules\Estimation\Http\Models\UtilityRateRange::class, 'utility_id');
    }
}