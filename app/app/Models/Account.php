<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id'
    ];

    protected $with = [
        /* 'adminData', */
        'creativeData',
        /* 'brandData' */
    ];

    public static function getFromUser(\App\User $user)
    {
        return SELF::where('user_id', $user->id)->firstOrFail();
    }


    /*
     * RELATIONSHIPS
     */

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /* public function adminData() */
    /* { */
    /*     return $this->hasOne(\App\Models\AdminData::class); */
    /* } */

    public function creativeData()
    {
        return $this->hasOne(\App\Models\CreativeData::class);
    }

    /* public function brandData() */
    /* { */
    /*     return $this->hasOne(\App\Models\BrandData::class); */
    /* } */
}
