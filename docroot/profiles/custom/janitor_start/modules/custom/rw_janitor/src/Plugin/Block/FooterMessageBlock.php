<?php

namespace Drupal\rw_janitor\Plugin\Block;

use Drupal;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'FooterMessageBlock' block.
 *
 * @Block(
 *  id = "rw_footermsg",
 *  admin_label = @Translation("Footer message (legacy)"),
 * )
 */
class FooterMessageBlock extends BlockBase {
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $config = Drupal::config('system.site');
    return [
        'copyright_copy' => $config->get('name') . ' - Some rights reserved.',
      
      ] + parent::defaultConfiguration();
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['copyright_copy'] = [
      '#type'          => 'textarea',
      '#title'         => 'Copyright &copy; ' . date('Y') . ' - ',
      '#description'   => $this->t('Provide a custom copyright footer message to display in this block'),
      '#default_value' => $this->configuration['copyright_copy'],
      '#weight'        => '0',
    ];
    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['copyright_copy'] = $form_state->getValue('copyright_copy');
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['footer_message_block_copyright_copy']['#markup'] = '<p class="meta tiny">Copyright &copy; ' . date('Y') . ' - ' . $this->configuration['copyright_copy'] . '</p>';
    
    return $build;
  }
  
}
