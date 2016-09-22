<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\Model;

use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;

/**
 * Redirect manager interface
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface RedirectManagerInterface
{
    /**
     * @param Node   $node
     * @param string $language
     *
     * @return Redirect[]
     */
    public function findByNodeAndLanguage(Node $node, $language);

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
     * @param Redirect $redirect
     */
    public function updateRedirect(Redirect $redirect);

    /**
     * @param Redirect $redirect
     */
    public function deleteRedirect(Redirect $redirect);
}
