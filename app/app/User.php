<?php

namespace App;

use App\Notifications\ReviewSubmission;
use App\Notifications\SubmissionStored;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class User extends Authenticatable implements  MustVerifyEmail
{
    use HasApiTokens,
        Notifiable,
        HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'roles', 'account'
    ];


    /*
     * RELATIONSHIPS
     */

    public function account(){
        return $this->hasOne(\App\Models\Account::class);
    }

    public function logs()
    {
        return $this->hasMany(\App\Models\LogEntry::class);
    }

    // Custom VerifyEmail notification with modified URL for frontend handling via API
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail);
    }

    public function notifySubmissionReview($submission)
    {
        $this->notify(new ReviewSubmission($submission, $this));
    }

    public function notifySubmissionStored($submission)
    {
        $this->notify(new SubmissionStored($submission, $this));
    }
}
