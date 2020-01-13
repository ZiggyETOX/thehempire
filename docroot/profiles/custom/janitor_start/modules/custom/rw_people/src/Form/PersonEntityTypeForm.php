<?php

namespace Drupal\rw_people\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PersonEntityTypeForm.
 */
class PersonEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $person_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $person_type->label(),
      '#description' => $this->t("Label for the Person type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $person_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\rw_people\Entity\PersonEntityType::load',
      ],
      '#disabled' => !$person_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $person_type = $this->entity;
    $status = $person_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Person type.', [
          '%label' => $person_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Person type.', [
          '%label' => $person_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($person_type->toUrl('collection'));
  }

}
