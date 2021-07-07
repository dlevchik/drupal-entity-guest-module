<?php

namespace Drupal\levchik\Plugin\Validation\Constraint;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Custom phone constraint validator.
 */
class GuestPhoneConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    if (!isset($value) || $value == '') {
      return NULL;
    }
    if (!preg_match('/^\+?3?8?(0\d{9})$/i', $value->getValue()[0]['value'])) {
      $this->context->addViolation($constraint->invalidPhone, ['@name' => $value->getFieldDefinition()->getLabel()]);
    }
  }

}
