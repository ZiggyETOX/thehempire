<?php
/**
 * @file
 * Enables module and site configuration for a Rogerwilco Webstart installation
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form. Find the default
 * form in SiteConfigureForm.php
 */
function janitor_start_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['site_information']['site_name']['#default_value'] = 'Webstart';
  $form['admin_account']['account']['name']['#default_value'] = 'RW-Admin';
  $form['admin_account']['account']['mail']['#default_value'] = 'siteadmins@rogerwilco.co.za';
  $form['regional_settings']['site_default_country']['#default_value'] = 'ZA';
}

/**
 * Implements hook_install_tasks().
 *
 * Add extra form elements/steps after installation
 */
function janitor_start_install_tasks(&$install_state) {
//  return [
//    'janitor_start_components' => [
//      'display_name' => t('Extra components'),
//      'display'      => TRUE,
//      'type'         => 'form',
//      'function'     => JanitorComponentsForm::class,
//    ],
//  ];
  $tasks = [
    '\Drupal\janitor_start\Form\JanitorComponentsForm' => [
      'display_name' => t('Extra components'),
      'type'         => 'form',
    ],
//    'janitor_start_install_components' => [
//      'display_name' => t('Install extra components'),
//      'display'      => TRUE,
//      'type'         => 'batch',
//    ],
  ];
  
  return $tasks;
}

/**
 * Batch function to assemble and install needed extra components.
 *
 * @param array $install_state
 *   The current install_state
 *
 * @return array $batch
 *   Batch API definition suitable for batch_set
 */
function janitor_start_install_components(&$install_state) {
  // kint($install_state);
  
  // \Drupal::service('module_installer')->install((array) $extra_component, TRUE);
}

