<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Accepted()
 * @method static static Rejected()
 */
final class SubmissionState extends Enum
{
    const Pending  = 0;
    const Accepted = 1;
    const Rejected = 2;
}
