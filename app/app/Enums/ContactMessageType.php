<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Brands()
 * @method static static Creatives()
 */
final class ContactMessageType extends Enum
{
    const Brands    = 0;
    const Creatives = 1;
}
