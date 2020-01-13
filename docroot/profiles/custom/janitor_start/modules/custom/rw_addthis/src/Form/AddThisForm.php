<?php
/**
 * @file
 * Contains Drupal\rw_addthis\Form\AddThisForm.
 */

namespace Drupal\rw_addthis\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class AddThisForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'rw_addthis.adminsettings',
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rw_addthis_form';
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('rw_addthis.adminsettings');
    
    $form['addthis_public_id'] = [
      '#type'          => 'textfield',
      '#size'          => 60,
      '#maxlength'     => 22,
      '#title'         => $this->t('AddThis.com public ID'),
      '#description'   => $this->t('Provide the ID located on your addthis.com dashboard, "Profile Settings" in the "General" tab. It should look similar to this one: ra-0123456789abcdef'),
      '#default_value' => $config->get('addthis_public_id'),
    ];
    
    return parent::buildForm($form, $form_state);
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    
    $this->config('rw_addthis.adminsettings')
      ->set('addthis_public_id', $form_state->getValue('addthis_public_id'))
      ->save();
  }
}