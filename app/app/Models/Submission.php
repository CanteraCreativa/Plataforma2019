<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Facades\Storage;

use BenSampo\Enum\Traits\CastsEnums;
use \App\Enums\SubmissionState;


/**
 * Class Submission.
 *
 * @package namespace App\Models;
 */
class Submission extends Model implements Transformable
{
    use CastsEnums,
        TransformableTrait;

    protected $fillable = [
        'name',
        'image_file',
        'description',
        'legal_external',
        'legal_external_details',
        'legal_author',
        'legal_human_figures',
        'inscription_id',
        'answer_question_1',
        'answer_question_2',
        'answer_question_3',
        'state',
        'review_observation',
    ];

    protected $appends = [
        'is_winner',
    ];

    protected $with = [
        'announcement',
        'skills',
        'creativeData',
    ];

    protected $enumCasts = [
        'state' => SubmissionState::class,
    ];

    protected $casts = [
        'state' => 'int',
    ];


    /**
     * ACCESSORS & MUTATORS
     **/

    public function setImageFileAttribute($file)
    {
        $path = $file->store('images', 'submissions');
        $this->attributes['image_file'] = $path;
    }

    public function getImageFileAttribute($file_name)
    {
        return Storage::disk('submissions')->url($file_name);
    }

    /*
     * RELATIONSHIPS
     */
    public function inscription()
    {
        return $this->belongsTo(
            \App\Models\Inscription::class,
            'inscription_id',
            'id'
        );
    }

    public function announcement()
    {
        return $this->hasOneThrough(
            \App\Models\Announcement::class,
            \App\Models\Inscription::class,
            'id',
            'id',
            'inscription_id',
            'announcement_id'
        );
    }

    public function creativeData()
    {
        return $this->hasOneThrough(
            \App\Models\CreativeData::class,
            \App\Models\Inscription::class,
            'id',
            'id',
            'inscription_id',
            'creative_data_id'
        );
    }

    public function skills()
    {
        return $this->belongsToMany(
            \App\Models\Skill::class,
            'skill_submission',
            'submission_id',
            'skill_id'
        );
    }

    public function getIsWinnerAttribute()
    {
        if ($this->announcement->results_date <= \Carbon\Carbon::today()) {
            return $this->announcement->winners->contains($this->id);
        }

        return false;
    }


    /**
     * SCOPES
     **/

    public function scopeAccepted($query)
    {
        return $query->where('state', SubmissionState::Accepted);
    }

}
