<?php

namespace Drupal\levchik\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Custom phone validation constraint.
 *
 * @Constraint(
 *   id = "GuestPhone",
 *   label = @Translation("Guest phone", context = "Validation"),
 * )
 */
class GuestPhoneConstraint extends Constraint {

  /**
   * The default violation message.
   *
   * @var string
   */
  public $invalidPhone = '@name field must be a valid phone number.';

}
