<?php

namespace Drupal\rw_janitor\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
// use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal;

/**
 * Provides a 'MissionBlock' block.
 *
 * @Block(
 *  id = "mission_block",
 *  admin_label = @Translation("Mission"),
 * )
 */
class MissionBlock extends BlockBase {
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        //      'mission_cta_link' => '/about',
      ] + parent::defaultConfiguration();
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['mission'] = [
      '#type'          => 'text_format',
      '#title'         => $this->t('Mission'),
      '#description'   => $this->t('Provide a brief description/overview of what your company does and/or what this website is for'),
      // '#default_value' => $this->configuration['mission'],
      '#default_value' => isset($this->configuration['mission']['value']) ? $this->configuration['mission']['value'] : NULL,
      '#format'        => isset($this->configuration['mission']['format']) ? $this->configuration['mission']['format'] : filter_default_format(),
      '#weight'        => '1',
    ];
    
    //    $form['mission_cta_link'] = [
    //      '#type'          => 'url',
    //      '#title'         => $this->t('URL to more information'),
    //      '#description'   => $this->t('Provide the relative URL to a web page containing the full description/overview of the mission'),
    //      '#attributes'    => [
    //        'placeholder'  => $this->t('E.g. "/about"'),
    //      ],
    //      '#default_value' => $this->configuration['mission_cta_link'],
    //      '#options'       => ['external' => FALSE],
    //      '#weight'        => '3',
    //    ];
    
    
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['mission'] = $form_state->getValue('mission');
    // $this->configuration['mission_cta_link'] = $form_state->getValue('mission_cta_link');
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    
    // Formatted text bit
    $build['mission_block_mission'] = [
      '#markup' => $this->configuration['mission']['value'],
      '#weight' => 1,
    ];
    
    // CTA bit
    // Load the about page node from an alias
    $path = Drupal::service('path.alias_manager')->getPathByAlias('/about');
    if (preg_match('/node\/(\d+)/', $path, $matches)) {
      $node = Node::load($matches[1]);
      
      $url = $node->toUrl('canonical', [
        'attributes' => [
          'class'    => [
            'mission', 'mission--readmore-link',
          ],
        ],
      ]);
      
      $link = Link::fromTextAndUrl($this->t('Find out more'), $url);
      
      $build['mission_cta_link'] = [
        '#markup'    => $link->toString(),
        '#weight'    => 3,
      ];
      
      // kint($node);
    }
    
    return $build;
  }
  
}
