<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EconomicCache extends Model
{
    protected $fillable = [
        'country_id',
        'gdp',
        'inflation',
        'population',
        'exports',
        'imports',
        'fetched_at'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}