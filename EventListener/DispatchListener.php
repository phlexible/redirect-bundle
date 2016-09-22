<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\EventListener;

use Phlexible\Bundle\ElementRedirect\Model\RedirectManagerInterface;

/**
 * Dispatch listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class DispatchListener
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

    public function onDispatchTid(BeforeDispatchTid $event)
    {
        $request = $event->getRequest();

        $uri = $request->getUri();

        if (!$uri || $uri == '/') {
            return;
        }

        $redirect = $this->redirectManager->findByUriAndSiterootId($uri, $request->getSiteRootId());
        if (!$redirect) {
            return;
        }

        if ($request->getTid() === null)
        {
            $request->setTid($redirect['tid']);
            $request->setLanguage($redirect['language']);
            $request->setParams(array());
            $request->setNeedRedirect(true);
        }
    }
}
