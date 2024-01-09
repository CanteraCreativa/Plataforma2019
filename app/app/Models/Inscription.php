<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Inscription.
 *
 * @package namespace App\Models;
 */
class Inscription extends Pivot implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    public $incrementing = true;

    protected $table = 'creative_data_announcement';


    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
        });

    }

    /*
     * RELATIONSHIPS
     */
    public function submissions()
    {
        return $this->hasMany(
            \App\Models\Submission::class,
            'inscription_id'
        );
    }

    public function announcement()
    {
        return $this->belongsTo(\App\Models\Announcement::class);
    }

    public function creativeData()
    {
        return $this->belongsTo(\App\Models\CreativeData::class);
    }
}
