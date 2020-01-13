<?php

namespace Drupal\rw_people\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Url;
use Drupal\rw_people\Entity\PersonEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PersonEntityController.
 *
 *  Returns responses for Person routes.
 */
class PersonEntityController extends ControllerBase implements ContainerInjectionInterface {


  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructs a new PersonEntityController.
   *
   * @param \Drupal\Core\Datetime\DateFormatter $date_formatter
   *   The date formatter.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   */
  public function __construct(DateFormatter $date_formatter, Renderer $renderer) {
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * Displays a Person revision.
   *
   * @param int $person_revision
   *   The Person revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($person_revision) {
    $person = $this->entityTypeManager()->getStorage('person')
      ->loadRevision($person_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('person');

    return $view_builder->view($person);
  }

  /**
   * Page title callback for a Person revision.
   *
   * @param int $person_revision
   *   The Person revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($person_revision) {
    $person = $this->entityTypeManager()->getStorage('person')
      ->loadRevision($person_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $person->label(),
      '%date' => $this->dateFormatter->format($person->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Person.
   *
   * @param \Drupal\rw_people\Entity\PersonEntityInterface $person
   *   A Person object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(PersonEntityInterface $person) {
    $account = $this->currentUser();
    $person_storage = $this->entityTypeManager()->getStorage('person');

    $langcode = $person->language()->getId();
    $langname = $person->language()->getName();
    $languages = $person->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $person->label()]) : $this->t('Revisions for %title', ['%title' => $person->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all person revisions") || $account->hasPermission('administer person entities')));
    $delete_permission = (($account->hasPermission("delete all person revisions") || $account->hasPermission('administer person entities')));

    $rows = [];

    $vids = $person_storage->revisionIds($person);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\rw_people\PersonEntityInterface $revision */
      $revision = $person_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $person->getRevisionId()) {
          $link = $this->l($date, new Url('entity.person.revision', [
            'person' => $person->id(),
            'person_revision' => $vid,
          ]));
        }
        else {
          $link = $person->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.person.translation_revert', [
                'person' => $person->id(),
                'person_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.person.revision_revert', [
                'person' => $person->id(),
                'person_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.person.revision_delete', [
                'person' => $person->id(),
                'person_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['person_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
