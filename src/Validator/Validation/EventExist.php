<?php

namespace App\Validator\Validation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class EventExist extends Constraint
{
    public string $message = 'Event does not exist.';


}
