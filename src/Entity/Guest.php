<?php

namespace Drupal\levchik\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * @ContentEntityType(
 *   id = "guest",
 *   label = @Translation("Guest"),
 *   label_singular = @Translation("Guest item"),
 *   label_plural = @Translation("Guest items"),
 *   label_count = @PluralTranslation(
 *     singular = "@count Guest item",
 *     plural = "@count Guest items"
 *   ),
 *   base_table = "guest",
 *   translatable = TRUE,
 *   data_table = "event_field_data",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "created" = "created",
 *     "langcode" = "langcode",
 *   },
 *   handlers = {
 *     "access" = "Drupal\levchik\GuestAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\levchik\Form\GuestForm",
 *       "default" = "Drupal\levchik\Form\GuestForm",
 *       "edit" = "Drupal\levchik\Form\GuestForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "permission_provider" = "Drupal\Core\Entity\EntityPermissionProvider",
 *     "route_provider" = {
 *       "default" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *     "list_builder" = "Drupal\levchik\Controller\GuestListBuilder",
 *     "local_action_provider" = {
 *       "collection" = "Drupal\Core\Entity\Menu\EntityCollectionLocalActionProvider",
 *     },
 *     "views_data" = "Drupal\views\EntityViewsData",
 *   },
 *   links = {
 *     "canonical" = "/guest/{guest}",
 *     "add-form" = "/admin/content/guests/add",
 *     "edit-form" = "/admin/content/guests/manage/{guest}",
 *     "delete-form" = "/admin/content/guests/manage/{guest}/delete",
 *     "collection" = "/admin/content/guests",
 *   },
 *   admin_permission = "administer guest",
 * )
 */
class Guest extends ContentEntityBase {

  /**
   * Get guest feedback message.
   */
  public function getDefaultAvatar() {
    return '/modules/custom/levchik/img/download.jpeg';
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time the guest item was created.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'datetime_custom',
        'settings' => [
          'date_format' => 'm/j/Y H:i:s',
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('Guest name.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings([
        'max_length' => 100,
        'default_value' => '',
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->addPropertyConstraints('value', [
        'Length' => [
          'max' => 100,
          'min' => 2,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('Guest email.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings([
        'default_value' => '',
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->addConstraint('GuestEmail')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['phone'] = BaseFieldDefinition::create('telephone')
      ->setLabel(t('Phone'))
      ->setDescription((t('Guest phone number.')))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'telephone_default',
        'weight' => 2,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 2,
      ])
      ->addConstraint('GuestPhone')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['message'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Message'))
      ->setDescription(t('Guest feedback message.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 3,
      ])
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'text_textarea',
        'weight' => 3,
        'rows' => 6,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar'))
      ->setDescription(t('Guest avatar.'))
      ->setTranslatable(TRUE)
      ->setSettings([
        'file_directory' => 'public://levchik/avatars/',
        'alt_field_required' => TRUE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 2097152,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 4,
      ])
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'image_image',
        'weight' => 4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['picture'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Picture'))
      ->setDescription(t('Guest message picture.'))
      ->setTranslatable(TRUE)
      ->setSettings([
        'file_directory' => 'public://levchik/pictures/',
        'alt_field_required' => TRUE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 5242880,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 5,
      ])
      ->setDisplayOptions('form', [
        'label' => 'above',
        'type' => 'image_image',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * Get guest created time.
   */
  public function getCreated() {
    return $this->get('created')->value;
  }

  /**
   * Set guest created time.
   */
  public function setCreated($timestamp) {
    return $this->set('created', $timestamp);
  }

  /**
   * Get guest name.
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * Set guest name.
   */
  public function setName($name) {
    return $this->set('name', $name);
  }

  /**
   * Get guest email.
   */
  public function getEmail() {
    return $this->get('email')->value;
  }

  /**
   * Set guest name.
   */
  public function setEmail($email) {
    return $this->set('email', $email);
  }

  /**
   * Get guest phone.
   */
  public function getPhone() {
    return $this->get('phone')->value;
  }

  /**
   * Set guest phone.
   */
  public function setPhone($phone) {
    return $this->set('phone', $phone);
  }

  /**
   * Get guest feedback message.
   */
  public function getMessage() {
    return $this->get('message')->first();
  }

  /**
   * Set guest feedback message.
   */
  public function setMessage($message, $format) {
    return $this->set('message', [
      'value' => $message,
      'format' => $format,
    ]);
  }

  /**
   * Get guest avatar.
   */
  public function getAvatar() {
    return $this->get('avatar')->first();
  }

  /**
   * Get guest feedback picture.
   */
  public function getPicture() {
    return $this->get('picture')->first();
  }

}
