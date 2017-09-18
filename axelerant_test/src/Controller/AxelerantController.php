<?php

/**
 * @file
 * Contains \Drupal\example\Controller\MainPageController.
 */
namespace Drupal\axelerant_test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class AxelerantController extends ControllerBase {
  /*
   * @param bool $siteapikey
   *  Site Api Key from URL
   * @param bool $nodeid
   *  Node ID being passed from URL
   */
  public function getJson($siteapikey, $nodeid) {
    $serializer = \Drupal::service('serializer');
    $node = Node::load(1);
    $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
    return array(
      '#markup' => $data
    );
  }
}
