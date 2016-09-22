<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirectBundle\Model;

use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Redirect manager interface
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface RedirectManagerInterface
{
    /**
     * @param TreeNodeInterface $node
     * @param string            $language
     *
     * @return Redirect[]
     */
    public function findByNodeAndLanguage(TreeNodeInterface $node, $language);

    /**
     * @param string $uri
     *
     * @return Redirect[]
     */
    public function findByUri($uri);

    /**
     * @param string $uri
     *
     * @return Redirect
     */
    public function findOneByUri($uri);

    /**
     * @param string $uri
     * @param string $siterootId
     *
     * @return Redirect
     */
    public function findByUriAndSiterootId($uri, $siterootId);

    /**
     * @param Redirect[] $redirects
     */
    public function updateRedirects(array $redirects);

    /**
     * @param Redirect $redirect
     */
    public function updateRedirect(Redirect $redirect);

    /**
     * @param Redirect[] $redirects
     */
    public function deleteRedirects(array $redirects);

    /**
     * @param Redirect $redirect
     */
    public function deleteRedirect(Redirect $redirect);
}
