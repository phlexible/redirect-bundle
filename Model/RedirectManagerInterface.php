<?php

/*
 * This file is part of the phlexible redirect package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\RedirectBundle\Model;

use Phlexible\Bundle\RedirectBundle\Entity\Redirect;
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
