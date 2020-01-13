<?php

namespace Drupal\rw_people\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Person type entity.
 *
 * @ConfigEntityType(
 *   id = "person_type",
 *   label = @Translation("Person type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\rw_people\PersonEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\rw_people\Form\PersonEntityTypeForm",
 *       "edit" = "Drupal\rw_people\Form\PersonEntityTypeForm",
 *       "delete" = "Drupal\rw_people\Form\PersonEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\rw_people\PersonEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "person_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "person",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/person_type/{person_type}",
 *     "add-form" = "/admin/structure/person_type/add",
 *     "edit-form" = "/admin/structure/person_type/{person_type}/edit",
 *     "delete-form" = "/admin/structure/person_type/{person_type}/delete",
 *     "collection" = "/admin/structure/person_type"
 *   }
 * )
 */
class PersonEntityType extends ConfigEntityBundleBase implements PersonEntityTypeInterface {

  /**
   * The Person type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Person type label.
   *
   * @var string
   */
  protected $label;

}
