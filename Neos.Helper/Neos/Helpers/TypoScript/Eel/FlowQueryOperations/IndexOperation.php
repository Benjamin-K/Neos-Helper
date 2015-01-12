<?php
namespace Neos\Helpers\TypoScript\Eel\FlowQueryOperations;

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Eel\FlowQuery\Operations\AbstractOperation;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * "index" operation working on TYPO3CR nodes. It returns
 * the index of the first contextNode of the flowQuery
 */
class IndexOperation extends AbstractOperation {

  /**
   * {@inheritdoc}
   *
   * @var string
   */
  static protected $shortName = 'index';

  /**
   * {@inheritdoc}
   *
   * @var integer
   */
  static protected $priority = 100;

  /**
   * {@inheritdoc}
   *
   * @param array (or array-like object) $context onto which this operation should be applied
   * @return boolean TRUE if the operation can be applied onto the $context, FALSE otherwise
   */
  public function canEvaluate($context) {
    return count($context) === 0 || (isset($context[0]) && ($context[0] instanceof NodeInterface));
  }

  /**
   * {@inheritdoc}
   *
   * @param FlowQuery $flowQuery the FlowQuery object
   * @return void
   */
  public function evaluate(FlowQuery $flowQuery) {
    $contextNode = $flowQuery->getContext();

    $nodesInContext = $contextNode->getParent()->getChildNodes();
    for ($i = 0; $i < count($nodesInContext); $i++) {
      if ($nodesInContext[$i] === $contextNode) {
        return $i;
      }
    }
    return 0;
  }
}
