<?php

namespace Drupal\levchik\Plugin\Validation\Constraint;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Custom email constraint validator.
 */
class GuestEmailConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    if (!isset($value) || $value == '') {
      return NULL;
    }
    $test = $value->getValue()[0]['value'];
    if (!filter_var($value->getValue()[0]['value'], FILTER_VALIDATE_EMAIL)) {
      $this->context->addViolation($constraint->invalidEmail, ['@name' => $value->getFieldDefinition()->getLabel()]);
    }
  }

}
