<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Skill.
 *
 * @package namespace App\Models;
 */
class Skill extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];


    /*
     * RELATIONSHIPS
     */
    public function creativeDatas()
    {
        return $this->belongsToMany(
            \App\Models\CreativeData::class,
            'creative_data_skill',
            'skill_id',
            'creative_data_id'
        );
    }
}
