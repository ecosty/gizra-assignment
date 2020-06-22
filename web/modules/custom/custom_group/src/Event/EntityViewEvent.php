<?php

namespace Drupal\custom_group\Event;

use Symfony\Component\EventDispatcher\Event;
use \Drupal\Core\Entity\EntityInterface;
use \Drupal\Core\Entity\Display\EntityViewDisplayInterface;

/**
 * Event that is fired for an entity before rendering.
 */
class EntityViewEvent extends Event {
  
  const ENTITY_VIEW = 'custom_events_entity_view';

  /**
   * The build array.
   */
  public $build;

  /**
   * The entity object.
   * 
   * @var \Drupal\Core\Entity
   */
  public $entity;

  /**
   * The display.
   * 
   * @var \Drupal\Core\Entity\Display\EntityViewDisplayInterface
   */
  public $display;

  /**
   * The view mode.
   */
  public $view_mode;

  /**
   * Constructs the object.
   * $build element is passsed by reference to alter the content.
   * 
   * @param $build
   * @param \Drupal\Core\Entity $entity
   * @param \Drupal\Display\EntityViewDisplayInterface $display
   * @param $view_mode
   * 
   */
  public function __construct(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
    $this->build = &$build;
    $this->entity = $entity;
    $this->display = $display;
    $this->view_mode = $view_mode;
  }
}
