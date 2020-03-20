<?php
namespace Core\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class PhoneNumber extends Constraint
{
    public $message = '"{{ string }}" is not a valid phone number.';
}
