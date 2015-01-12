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
class FileTypeViewHelper extends AbstractViewHelper {

  /**
   * Format the filesize
   *
   * @param mixed $file The file / an instance of \TYPO3\Flow\Resource\Resource. If NULL the child nodes are used as size
   * @param string $default The default extension to be returned
   * @return string The extension of the file
   */
  public function render($file = NULL, $default = 'NONE') {
    if ($file === NULL) {
      $file = $this->renderChildren();
    }
    if ($file instanceof \TYPO3\Media\Domain\Model\ImageInterface) {
      return $file->getFileExtension();
    }
    if ($file instanceof \TYPO3\Media\Domain\Model\AssetInterface) {
      $file = $file->getResource();
    }
    if ($file instanceof \TYPO3\Flow\Resource\Resource) {
      $info = @pathinfo($file->getFilename(), PATHINFO_EXTENSION);
    }

    if(isset($info) && $info) {
      return $info;
    }
    return $default;
  }

}
