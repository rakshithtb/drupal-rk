<?php

/**
 * @file
 * Contains \Drupal\axelerant_test\Controller\PermissionController.
 */
namespace Drupal\axelerant_test\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;

/**
 * Checks Access for a page.
 */
class PermissionController {

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   * @param bool $siteapikey
   *  Site Api Key from URL
   * @param bool $nodeid
   *  Node ID being passed from URL
   */
  public function custom_access(AccountInterface $account, $siteapikey, $nodeid) {
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    return AccessResult::allowedIf($this->customaccessCheck($siteapikey, $nodeid));
  }
  
  /*
   * @param bool $siteapikey
   *  Site Api Key from URL
   * @param bool $nodeid
   *  Node ID being passed from URL
   */
  public function customaccessCheck($siteapikey, $nodeid) {
    $access_flag = FALSE;
    $node_exist = \Drupal::entityQuery('node')->condition('nid', $nodeid)->execute();
    
    if(!empty($node_exist)) {
      $serializer = \Drupal::service('serializer');
      $node = Node::load($nodeid);
      //Get the content type
      $bundle = $node->getType();
      
      //Get the Site Api Key
      $saved_siteApiKey = \Drupal::config('axelerant_test.site')->get('siteapikey');
      switch ($saved_siteApiKey) {
        case $siteapikey:
          $siteapikey_match = TRUE;
          break;
        default:
          $siteapikey_match = FALSE;
          break;
      }
      //Provide access only if content type is PAGE and if siteapikey matches
      $access_flag = ($siteapikey_match && ($bundle == 'page')) ? TRUE : FALSE;
    }
    return $access_flag;
  }
}
