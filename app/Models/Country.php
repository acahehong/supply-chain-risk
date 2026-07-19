<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'iso2',
        'capital',
        'region',
        'languages',
        'currency_code',
        'currency_name',
        'flag',
        'latitude',
        'longitude',
    ];
    public function currencyCache()
    {
        return $this->hasOne(CurrencyCache::class);
    }

    public function economicCache()
    {
        return $this->hasOne(EconomicCache::class);
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}