<?php

namespace App\Validator\Validation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class LectureExist extends Constraint
{
    public string $message = 'Lecture does not exist.';


}
