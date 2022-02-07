<?php

namespace App\Validator\Validation;

use App\Service\EventService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EventExistValidator extends ConstraintValidator
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EventExist) {
            throw new UnexpectedTypeException($constraint, EventExist::class);
        }
        if (!empty($this->eventService->findById($value)))
            return;
        $this->context->buildViolation($constraint->message)->addViolation();
    }
}