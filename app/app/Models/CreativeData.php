<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use BenSampo\Enum\Traits\CastsEnums;
use \App\Enums\UserGender;
use \App\Enums\Countries;

/**
 * Class CreativeData.
 *
 * @package namespace App\Models;
 */
class CreativeData extends Model implements Transformable
{
    use TransformableTrait,
        CastsEnums;

    protected $table = 'creative_datas';

    protected $hidden = [
        'user',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'age',
        'birth_date',
        'phone',
        'address',
        'studies',
        'studies_where',
        'country',
        'nationality',
        'mercadopago_account',
        'description',
        'account_id',
        'skills',
        'interests',
        'profile_image',
        'background_image',
        'links',
        'career_id',
        'secondary_career_id',
        'study_level_id',
    ];

    protected $with = [
        'skills',
        'interests',
        'subscriptions',
    ];

    protected $appends = [
        'is_profile_complete',
    ];

    protected $enumCasts = [
        'gender' => UserGender::class,
        'country' => Countries::class,
        'nationality' => Countries::class,
    ];

    protected $casts = [
        'gender' => 'int',
        'country' => 'string',
        'nationality' => 'string',
        'links' => 'array',
    ];


    public function getIsProfileCompleteAttribute()
    {
        return !(
            $this->first_name == null
            || $this->last_name == null
            || $this->gender == null
            || $this->birth_date == null
            || $this->country == null
        );
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmailAttribute()
    {
        return $this->account->user->email;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = (string)\Propaganistas\LaravelPhone\PhoneNumber::make($value, 'AR')->formatE164();
    }

    public function setProfileImageAttribute($file)
    {
        if (is_string($file))
            return $this->attributes['profile_image'] = $file;

        $path = $file->store('images', 'creative_datas');
        $this->attributes['profile_image'] = $path;
    }

    public function getProfileImageAttribute($file_name)
    {
        if(strpos($file_name, 'http') === 0)
            return $file_name;

        if ($file_name != null) {
            return Storage::disk('creative_datas')->url($file_name);
        }
        return null;
    }

    public function setBackgroundImageAttribute($file)
    {
        $path = $file->store('images', 'creative_datas');
        $this->attributes['background_image'] = $path;
    }

    public function getBackgroundImageAttribute($file_name)
    {
        if ($file_name != null) {
            return Storage::disk('creative_datas')->url($file_name);
        }
        return null;
    }

    /*
     * RELATIONSHIPS
     */

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class);
    }

    /*
     * The CreativeData has a User through an Account
     */
    public function user()
    {
        return $this->hasOneThrough(
            \App\User::class,
            \App\Models\Account::class,
            'user_id',
            'id',
            'account_id',
            'id'
        );
    }

    public function skills()
    {
        return $this->belongsToMany(\App\Models\Skill::class)
            ->withPivot('level');
    }

    public function interests()
    {
        return $this->belongsToMany(
            \App\Models\Interest::class,
            'creative_data_interest',
            'creative_data_id',
            'interest_id'
        );
    }

    public function career()
    {
        $this->belongsTo(Career::class);
    }

    public function secondaryCareer()
    {
        $this->belongsTo(Career::class);
    }

    public function studyLevel()
    {
        $this->belongsTo(StudyLevel::class);
    }

    /*
     * A Creative user may be subscribed to many Announcements
     */
    public function subscriptions()
    {
        return $this->belongsToMany(
            \App\Models\Announcement::class,
            'creative_data_announcement',
            'creative_data_id',
            'announcement_id'
        )->using(\App\Models\Inscription::class)
            ->as('inscription')
            ->withPivot([ 'id' ]);
    }

    public function inscriptions()
    {
        return $this->subscriptions->map(function($sub) { return $sub->inscription; });
    }
}
