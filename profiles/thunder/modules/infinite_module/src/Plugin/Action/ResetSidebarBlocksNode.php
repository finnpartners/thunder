<?php

/**
 * @file
 * Contains \Drupal\infinite_article\Plugin\Action\PromoteHomePresenterNode.
 */

namespace Drupal\infinite_base\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Reset sidebar blocks of a node.
 *
 * @Action(
 *   id = "node_reset_sidebar_blocks_action",
 *   label = @Translation("Reset sidebar blocks"),
 *   type = "node"
 * )
 */
class ResetSidebarBlocksNode extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    if ($entity->hasField('field_sidebar_blocks')) {
      /** @var \Drupal\node\NodeInterface $entity */
      $field_definitions = $entity->getFieldDefinitions();
      $default = $field_definitions['field_sidebar_blocks']->getDefaultValue($entity);
      $entity->set('field_sidebar_blocks', $default);
      $entity->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\node\NodeInterface $object */
    $access = $object->access('update', $account, TRUE)
      ->andif($object->promote->access('edit', $account, TRUE));
    return $return_as_object ? $access : $access->isAllowed();
  }

}
