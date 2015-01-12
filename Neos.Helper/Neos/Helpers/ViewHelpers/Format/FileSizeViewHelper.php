<?php
namespace Neos\Helpers\ViewHelpers\Format;

/*                                                                                 *
 * This script belongs to the TYPO3 Flow package "Your.Package.                    *
 *                                                                                 *
 *                                                                                 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper rendering the size of a file
 */
class FileSizeViewHelper extends AbstractViewHelper {

  /**
   * @var array
   */
  protected $units = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');

  /**
   * Format the filesize
   *
   * @param mixed $size The file's size in bytes or an instance of \TYPO3\Flow\Resource\Resource. If NULL the child nodes are used as size
   * @param integer $precision The optional number of decimal digits to round to
   * @return string The filesize with SI unit appended
   */
  public function render($size = NULL, $precision = 2) {
    if ($size === NULL) {
      $size = $this->renderChildren();
    }
    if ($size instanceof \TYPO3\Flow\Resource\Resource || $size instanceof \TYPO3\Media\Domain\Model\ImageInterface) {
      $size = @filesize('resource://' . $size->getResourcePointer()->getHash());
    } elseif (!is_int($size)) {
      $size = @filesize('resource://'. $size);
    }

    # determine the unit
    $unit = reset($this->units);
    while($size > 1024) {
      $size /= 1024;
      $unit = next($this->units);
    }

    return sprintf('%s %s', round($size, $precision), $unit);
  }

}
