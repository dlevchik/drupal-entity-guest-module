<?php

namespace Drupal\levchik\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Controller for guest lists building.
 */
class GuestListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('<p>Here you can see all your guests feedback.</p>'),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'name' => [
        'data' => $this->t('Name'),
      ],
      'avatar' => [
        'data' => $this->t('Avatar'),
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'email' => [
        'data' => $this->t('Email'),
        'class' => [RESPONSIVE_PRIORITY_LOW],
      ],
      'phone' => [
        'data' => $this->t('Phone'),
        'class' => [RESPONSIVE_PRIORITY_LOW],
      ],
      'message' => [
        'data' => $this->t('Feedback'),
        'class' => [RESPONSIVE_PRIORITY_MEDIUM],
      ],
      'picture' => [
        'data' => $this->t('Picture'),
        'class' => [RESPONSIVE_PRIORITY_LOW],
      ],
      'created' => [
        'data' => $this->t('Created'),
        'sort' => 'desc',
      ],
    ];
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $guest) {
    /** @var Drupal\levchik\Entity\Guest $guest */
    $avatar = $guest->getAvatar();
    $picture = $guest->getPicture();
    $row = [];
    $row['name']['data'] = $guest->toLink()->setText($guest->getName())->toString();
    $row['avatar']['data'] = !$avatar->isEmpty() ? $avatar
      ->view([
        'label' => 'hidden',
        'settings' => [
          'image_style' => 'thumbnail',
        ],
      ]) : "default avatar";
    $row['email']['data'] = $guest->getEmail();
    $row['phone']['data'] = $guest->getPhone();
    $row['message']['data'] = $guest->getMessage()->view([
      'label' => 'hidden',
      'type' => 'text_trimmed',
      'settings' => [
        'trim_length' => 300,
      ],
    ]);
    $row['picture']['data'] = !$picture->isEmpty() ? $picture
      ->view([
        'label' => 'hidden',
        'settings' => [
          'image_style' => 'thumbnail',
        ],
      ]) : "no image";
    $row['created']['data'] = date('m/j/Y H:i:s', $guest->getCreated());
    return $row + parent::buildRow($guest);
  }

}
