<?php

namespace Drupal\janitor_start\Form;

use Drupal\Core\Extension\InfoParserInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Language\LanguageManager;

/**
 * Defines form for selecting Varbase's Multiligual configuration options form.
 */
class JanitorComponentsForm extends FormBase {
  
  /**
   * The Drupal application root.
   *
   * @var string
   */
  protected $root;
  
  /**
   * The info parser service.
   *
   * @var \Drupal\Core\Extension\InfoParserInterface
   */
  protected $infoParser;
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('app.root'),
      $container->get('info_parser')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'janitor_start_components';
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, array &$install_state = NULL) {
    
    $standard_languages = LanguageManager::getStandardLanguageList();
    $select_options = array();
    $browser_options = array();
    
    $form = [
      '#title' => $this->t('Components'),
      '#tree'  => FALSE,
    ];
  
//    $form['janitor_start_components_extrastuff'] = array(
//      '#type'        => 'checkbox',
//      '#title'       => $this->t('Enable extra stuff'),
//      '#description' => $this->t('Check this box. Nothing extra will happen yet, but nifty, innit?'),
//    );
  
    $form['janitor_start_components_introduction'] = array(
      '#weight' => -1,
      '#prefix' => '<p>',
      '#markup' => $this->t('Select additional Janitor components to enable after installation'),
      '#suffix' => '</p>',
    );
    
    $form['pagebuilder'] = [
      '#type'   => 'fieldset',
      '#title'  => $this->t('Page builder'),
    ];
    
    $form['pagebuilder']['intro'] = [
      '#type'   => 'markup',
      '#weight' => -5,
      '#markup' => '<p class="intro">' . $this->t('This section allows you to pick additional row types for the page builder to be enabled by default.') . '</p>',
    ];
    
    $form['pagebuilder']['wysiwyg'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('WYSIWYG row'),
      '#default_value' => TRUE,
      '#description'   => $this->t('Check this box to enable the WYSIWYG row by default'),
      '#attributes'    => [
        'readonly'     => 'readonly',
      ],
    ];
  
    $form['pagebuilder']['image'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Image row'),
      '#default_value' => FALSE,
      '#description'   => $this->t('Check this box to enable the Image row by default.'),
    ];
  
    $form['pagebuilder']['accordion'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Accordion row'),
      '#default_value' => FALSE,
      '#description'   => $this->t('Check this box to enable the Accordion row by default.'),
    ];
    
    $form['pagebuilder']['microviews'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Micro views'),
      '#default_value' => FALSE,
      '#description'   => $this->t('Check this box to enable the micro query writer.'),
    ];
  
    $form['pagebuilder']['mosaic'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Mosaic'),
      '#default_value' => FALSE,
      '#description'   => $this->t('Check this box to enable the arbitrary reference creator.'),
    ];
    
    $form['actions'] = [
      'continue' => [
        '#type' => 'submit',
        '#value' => $this->t('Save and continue'),
        '#button_type' => 'primary',
      ],
      '#type' => 'actions',
      '#weight' => 5,
    ];
    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // drupal_set_message('The components form was submitted', 'warning');
    $modules = [];
    
    // Testing post installation module enable-ations
    // From https://www.droptica.com/blog/how-enable-install-module-programmatically-drupal-8/
    // This works!
    // @TODO: Create a new batch thingy? Research how to actually use the submitted values
    if ($form_state->getValue('wysiwyg')) {
      // \Drupal::service('module_installer')->install(['rw_wysiwyg']);
      $modules[] = 'rw_wysiwyg';
    }
  
    if ($form_state->getValue('image')) {
      // \Drupal::service('module_installer')->install(['rw_image']);
      $modules[] = 'rw_image';
    }
  
    if ($form_state->getValue('accordion')) {
      // \Drupal::service('module_installer')->install(['rw_accordion']);
      $modules[] = 'rw_accordion';
    }
  
    if ($form_state->getValue('microviews')) {
      // \Drupal::service('module_installer')->install(['rw_microviews']);
      $modules[] = 'rw_microviews';
    }
  
    if ($form_state->getValue('mosaic')) {
      // \Drupal::service('module_installer')->install(['rw_microviews']);
      $modules[] = 'rw_mosaic';
    }
    
    \Drupal::service('module_installer')->install($modules, TRUE);
  
  } //endmeth submit
  
}
