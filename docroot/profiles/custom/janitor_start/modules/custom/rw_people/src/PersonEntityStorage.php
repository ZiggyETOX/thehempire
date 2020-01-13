<?php

namespace Drupal\rw_people;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\rw_people\Entity\PersonEntityInterface;

/**
 * Defines the storage handler class for Person entities.
 *
 * This extends the base storage class, adding required special handling for
 * Person entities.
 *
 * @ingroup rw_people
 */
class PersonEntityStorage extends SqlContentEntityStorage implements PersonEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(PersonEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {person_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {person_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(PersonEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {person_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('person_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
