<?php

namespace App\Validator\Validation;

use App\Service\LectureService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class LectureExistValidator extends ConstraintValidator
{
    private LectureService $lectureService;

    public function __construct(LectureService $lectureService)
    {
        $this->lectureService = $lectureService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof LectureExist) {
            throw new UnexpectedTypeException($constraint, LectureExist::class);
        }
        if (!empty($this->lectureService->findById($value)))
        return;

            $this->context->buildViolation($constraint->message)->addViolation();
    }
}
