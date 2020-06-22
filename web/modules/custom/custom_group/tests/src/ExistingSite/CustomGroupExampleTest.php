<?php

namespace Drupal\Tests\custom_group\ExistingSite;

use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use weitzman\DrupalTestTraits\ExistingSiteBase;


/**
 * A CustomGroup test suitable to verify if subscribe links have changed.
 */
class CustomGroupExampleTest extends ExistingSiteBase {

  /**
   * Test subscription linked has changed for registered user.
   * Very basic test in which we validate if the grup membership has changed
   * for ecosty user in /first-group page.
   *
   * @return void
   */
  public function testContentCreation() {
    // Set up credentials for ecosty. User ID: 5.
    $user = User::load(5);
    $user->passRaw = '12345';
    
    $this->drupalLogin($user);
    $this->visit('/first-group');

    // First Group node ID: 26
    $node = Node::load('26');

    $web_assert = $this->assertSession();
    $web_assert->statusCodeEquals(200);
    $web_assert->pageTextContains('Hi ' . $user->getUsername() . ', click here if you would like to subscribe to this group called ' . $node->getTitle());
  }
}
