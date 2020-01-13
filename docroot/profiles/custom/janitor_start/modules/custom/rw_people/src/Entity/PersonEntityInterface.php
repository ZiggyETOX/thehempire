<?php

namespace Drupal\rw_people\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Person entities.
 *
 * @ingroup rw_people
 */
interface PersonEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Person name.
   *
   * @return string
   *   Name of the Person.
   */
  public function getName();

  /**
   * Sets the Person name.
   *
   * @param string $name
   *   The Person name.
   *
   * @return \Drupal\rw_people\Entity\PersonEntityInterface
   *   The called Person entity.
   */
  public function setName($name);

  /**
   * Gets the Person creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Person.
   */
  public function getCreatedTime();

  /**
   * Sets the Person creation timestamp.
   *
   * @param int $timestamp
   *   The Person creation timestamp.
   *
   * @return \Drupal\rw_people\Entity\PersonEntityInterface
   *   The called Person entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Person revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Person revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\rw_people\Entity\PersonEntityInterface
   *   The called Person entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Person revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Person revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\rw_people\Entity\PersonEntityInterface
   *   The called Person entity.
   */
  public function setRevisionUserId($uid);

}
