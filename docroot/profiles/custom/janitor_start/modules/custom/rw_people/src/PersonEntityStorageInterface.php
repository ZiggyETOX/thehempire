<?php

namespace Drupal\rw_people;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface PersonEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Person revision IDs for a specific Person.
   *
   * @param \Drupal\rw_people\Entity\PersonEntityInterface $entity
   *   The Person entity.
   *
   * @return int[]
   *   Person revision IDs (in ascending order).
   */
  public function revisionIds(PersonEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Person author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Person revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\rw_people\Entity\PersonEntityInterface $entity
   *   The Person entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(PersonEntityInterface $entity);

  /**
   * Unsets the language for all Person with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
