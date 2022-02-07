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

////            throw new UnexpectedValueException($value, 'string');


//    public function validate($value, Constraint $constraint)
//    {
//        $this->context->buildViolation($constraint->message)
//            ->setParameter('{{ value }}', $this->formatValue($value))
//            ->setCode(NotBlank::IS_BLANK_ERROR)
//            ->addViolation();
//
////        if (!$constraint instanceof ContainsAlphanumeric) {
////            throw new UnexpectedTypeException($constraint, EventExist::class);
//////        }
////
////        // custom constraints should ignore null and empty values to allow
////        // other constraints (NotBlank, NotNull, etc.) to take care of that
////        if (null === $value || '' === $value) {
////            return;
////        }
////
////        if (!is_string($value)) {
////            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
////            throw new UnexpectedValueException($value, 'string');
////
////            // separate multiple types using pipes
////            // throw new UnexpectedValueException($value, 'string|int');
////        }
//
////        // access your configuration options like this:
//////        if ('strict' === $constraint->mode) {
//////            // ...
//////        }
////
////        if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
////            // the argument must be a string or an object implementing __toString()
////            $this->context->buildViolation($constraint->message)
////                ->setParameter('{{ string }}', $value)
////                ->addViolation();
////        }
//    }
//}
