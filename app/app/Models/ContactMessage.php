<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use BenSampo\Enum\Traits\CastsEnums;

/**
 * Class ContactMessage.
 *
 * @package namespace App\Models;
 */
class ContactMessage extends Model implements Transformable
{
    use TransformableTrait,
        CastsEnums;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'brand',
        'message',
        'receive_updates',
        'type',
        'read'
    ];

    protected $enumCasts = [
        'type' => \App\Enums\ContactMessageType::class,
    ];

    protected $casts = [
        'type' => 'int',
    ];

}
