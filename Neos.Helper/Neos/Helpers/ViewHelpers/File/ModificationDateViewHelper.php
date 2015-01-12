<?php
namespace InduLight\Website\ViewHelpers\File;

/*                                                                                 *
 * This script belongs to the TYPO3 Flow package "Your.Package.                    *
 *                                                                                 *
 *                                                                                 */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\I18n\Service;
use TYPO3\Flow\Resource\Publishing\ResourcePublisher;
use TYPO3\Flow\Resource\Resource;
use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper\Exception\InvalidVariableException;

/**
 * ViewHelper rendering the size of a file
 */
class ModificationDateViewHelper extends AbstractViewHelper {

  /**
   * @Flow\Inject
   * @var ResourcePublisher
   */
  protected $resourcePublisher;

  /**
   * @Flow\Inject
   * @var Service
   */
  protected $i18nService;

  /**
   * Format the filesize
   *
   * @param string $path The location of the resource, a path relative to the Public resource directory
   * @param string $package Target package key. If not set, the current package key will be used
   * @return int The file modification date
   * @throws InvalidVariableException
   */
  public function render($path = NULL, $package = NULL) {
    $base = __DIR__ . '/../../../../../../';

    if ($path === NULL) {
      throw new InvalidVariableException('The ResourceViewHelper did neither contain a valuable "resource" nor "path" argument.', 1353512742);
    }
    if ($package === NULL) {
      $package = $this->controllerContext->getRequest()->getControllerPackageKey();
    }
    if (strpos($path, 'resource://') === 0) {
      $matches = array();
      if (preg_match('#^resource://([^/]+)/Public/(.*)#', $path, $matches) === 1) {
        $package = $matches[1];
        $path = $matches[2];
      } else {
        throw new InvalidVariableException(sprintf('The path "%s" which was given to the ResourceViewHelper must point to a public resource.', $path), 1353512639);
      }
    }

    $uri = $base. 'Packages/<subpath>/' . $package . '/Resources/Public/' . $path;

    $packageFolders = array('Application', 'Framework', 'Sites');

    foreach($packageFolders as $pack) {
      $tmp = str_replace('<subpath>', $pack, $uri);
      if(file_exists($tmp)) {
        return filemtime($tmp);
      }
    }
    return 0;
  }

}
