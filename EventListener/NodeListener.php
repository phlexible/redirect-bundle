<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\EventListener;

use Phlexible\Bundle\ElementRedirect\Model\RedirectManagerInterface;
use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;

/**
 * Node listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeListener
{
    /**
     * @var RedirectManagerInterface
     */
    private $redirectManager;

    /**
     * @param RedirectManagerInterface $redirectManager
     */
    public function __construct(RedirectManagerInterface $redirectManager)
    {
        $this->redirectManager = $redirectManager;
    }

    public function onUpdateNode(NodeEvent $event)
    {
        $node     = $event->getNode();
        $language = $event->getLanguage();
        $data     = $event->getData();

        $redirects = $this->redirectManager->findForNodeAndLanguage($node, $language);
        foreach ($redirects as $redirect) {
            $this->redirectManager->removeRedirect($redirect);
        }

        if (!empty($data['redirect'])) {
            // save redirect data
            foreach ($data['redirects'] as $uri) {
                $redirect = new Redirect($node->getId(), $language, $uri);
                $this->redirectManager->updateRedirect($redirect);
            }
        }
    }
}
