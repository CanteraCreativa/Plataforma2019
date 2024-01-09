<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Announcement.
 *
 * @package namespace App\Models;
 */
class Announcement extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'company',
        'total_prize',
        'start_date',
        'end_date',
        'results_date',
        'short_description',
        'brief_file',
        'context',
        'challenge',
        'tips',
        'first_prize',
        'second_prize',
        'third_prize',
        'format',
        'criteria',
        'alignments',
        'rules_file',
        'rules_summary',
        'image_thumbnail',
        'image_banner',
        'winner_first',
        'winner_second',
        'winner_third',
        'winners',
    ];

    protected $appends = [
        'winner_creative_first',
        'winner_creative_second',
        'winner_creative_third',
        'state',
        'days_remaning',
    ];


    protected $with = [
        'skills',
        'guidelines',
        'interests',
    ];


    /*
     * GETTERS & MUTATORS
     */
    public function setBriefFileAttribute($file)
    {
        $path = $file->store('briefs', 'announcements');
        $this->attributes['brief_file'] = $path;
    }

    public function getBriefFileAttribute($file_name)
    {
        if(empty($file_name)) return null;
        return Storage::disk('announcements')->url($file_name);
    }

    public function setRulesFileAttribute($file)
    {
        $path = $file->store('rules', 'announcements');
        $this->attributes['rules_file'] = $path;
    }

    public function getRulesFileAttribute($file_name)
    {
        return Storage::disk('announcements')->url($file_name);
    }

    public function setImageThumbnailAttribute($file)
    {
        $path = $file->store('thumbs', 'announcements');
        $this->attributes['image_thumbnail'] = $path;
    }

    public function getImageThumbnailAttribute($file_name)
    {
        return Storage::disk('announcements')->url($file_name);
    }

    public function setImageBannerAttribute($file)
    {
        if($file == '')
            return $this->attributes['image_banner'] = $file;
        $path = $file->store('banners', 'announcements');
        $this->attributes['image_banner'] = $path;
    }

    public function getImageBannerAttribute($file_name)
    {
        return Storage::disk('announcements')->url($file_name);
    }

    public function getPickWinnersPeriodAttribute()
    {
        $end_date = $this->end_date;
        $results_date = $this->results_date;
        $today = \Carbon\Carbon::today();

        return ($today < $results_date) && ($today > $end_date);
    }


    public function getWinnerCreativeFirstAttribute()
    {
        $id = ($this->winnerFirst) ? $this->winnerFirst->creativeData->id : null;
        $this->unsetRelation('winnerFirst');
        return $id;
    }
    public function getWinnerCreativeSecondAttribute()
    {
        $id = ($this->winnerSecond) ? $this->winnerSecond->creativeData->id : null;
        $this->unsetRelation('winnerSecond');
        return $id;
    }
    public function getWinnerCreativeThirdAttribute()
    {
        $id = ($this->winnerThird) ? $this->winnerThird->creativeData->id : null;
        $this->unsetRelation('winnerThird');
        return $id;
    }

    public function getCanParticipateAttribute()
    {
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $start = Carbon::createFromFormat('Y-m-d', $this->start_date);
        $end = Carbon::createFromFormat('Y-m-d', $this->end_date);
        return $today->between($start,$end);
    }

    public function getStateAttribute()
    {
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $start = Carbon::createFromFormat('Y-m-d', $this->start_date);
        $end = Carbon::createFromFormat('Y-m-d', $this->end_date);

        if($today->isBefore($start))
            return 'proximamente';

        if($today->isAfter($end))
            return 'finalizada';

        if($end->isToday())
            return 'cierra-hoy';

        if($today->diff($end)->days <= 3)
            return 'ultimos-dias';

        return 'abierta';
    }

    public function getDaysRemaningAttribute()
    {
        $today = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $end = Carbon::createFromFormat('Y-m-d', $this->end_date);
        return $today->diff($end)->days;
    }

    public function getFormatedDate($column)
    {
        return Carbon::createFromFormat('Y-m-d', $this->$column)->format('d-m-Y');
    }


    /*
     * RELATIONSHIPS
     */

    /*
     * An Announcement may have many subscribed users (through the CreativeData model)
     */
    public function subscribers()
    {
        return $this->belongsToMany(
            \App\Models\CreativeData::class,
            'creative_data_announcement',
            'announcement_id',
            'creative_data_id'
        );
    }

    public function skills()
    {
        return $this->belongsToMany(
            \App\Models\Skill::class,
            'announcement_skill',
            'announcement_id',
            'skill_id'
        );
    }

    public function interests()
    {
        return $this->belongsToMany(
            \App\Models\Interest::class,
            'announcement_interest',
            'announcement_id',
            'interest_id'
        );
    }

    public function guidelines()
    {
        return $this->belongsToMany(
            \App\Models\Guideline::class,
            'announcement_guideline',
            'announcement_id',
            'guideline_id'
        );
    }

    public function winnerFirst()
    {
        return $this->belongsTo(\App\Models\Submission::class, 'winner_first', 'id');
    }
    public function winnerSecond()
    {
        return $this->belongsTo(\App\Models\Submission::class, 'winner_second', 'id');
    }
    public function winnerThird()
    {
        return $this->belongsTo(\App\Models\Submission::class, 'winner_third', 'id');
    }

    public function submissions()
    {
        return $this->hasManyThrough(
            \App\Models\Submission::class,
            \App\Models\Inscription::class,
            'announcement_id',
            'inscription_id',
            'id',
            'id'
        );
    }

}
