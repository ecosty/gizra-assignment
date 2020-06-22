<?php

// By convention, classes subscribing to an event live in the
// Drupal/{module_name}/EventSubscriber namespace.
namespace Drupal\custom_group\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \Drupal\custom_group\Event\EntityViewEvent;
use \Drupal\Component\Utility\NestedArray;

/**
 * Subscribe to EntityViewEvent::ENTITY_VIEW events to modify content in entities.
 */
class EntityViewSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    return [
      // Static class constant => method on this class.
      EntityViewEvent::ENTITY_VIEW => 'changeSubscriptionLink',
    ];
  }

  /**
   * Subscribe to the entity view event dispatched.
   * @param \Drupal\custom_group\Event\EntityViewEvent $event
   */
  public function changeSubscriptionLink(EntityViewEvent $event) {
    // Verify if node object exists.
    if(empty($event) || empty($event->build['#node'])) {
      return;
    }

    $node = $event->build['#node'];
    // Verify if node object is a group.
    if($node->getType() !== 'group') {
      return;
    }
    
    // Validate if user has been registered and is not the owner of the group.
    $user = \Drupal::currentUser();
    if (!$user->isAuthenticated() || ($user->id() == $node->getOwnerId())) {
      return;
    }

    // Get the og_group element and validate if link title exists.
    $og_group = &$event->build['og_group'];
    $key_exists = NULL;
    NestedArray::getValue($og_group, [0, '#title'], $key_exists);
    
    if ($key_exists) {
      // Assign the new label to the link.
      $og_group[0]['#title'] = t('Hi @username, click here if you would like to subscribe to this group called @group', ['@username' => $user->getUsername(), '@group' => $node->getTitle()]);
    }
  }
}
