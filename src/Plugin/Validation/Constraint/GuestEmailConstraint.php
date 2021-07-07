<?php

namespace Drupal\levchik\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Custom email validation constraint.
 *
 * @Constraint(
 *   id = "GuestEmail",
 *   label = @Translation("Guest email", context = "Validation"),
 * )
 */
class GuestEmailConstraint extends Constraint {

  /**
   * The default violation message.
   *
   * @var string
   */
  public $invalidEmail = '@name field must be a valid email.';

}
