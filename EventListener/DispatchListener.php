<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\EventListener;

/**
 * Dispatch listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class Makeweb_Redirects_Callback
{
    public function callDispatchTid(Makeweb_Frontend_Event_BeforeDispatchTid $event, array $params)
    {
        $request = $event->getRequest();

        $uri = $_SERVER['REQUEST_URI'];

        if (!$uri || $uri == '/')
        {
            return;
        }

        $container        = $params['container'];
        $redirectsManager = $container->redirectsManager;

        $redirect = $redirectsManager->getForUriAndSiterootId($uri, $request->getSiteRootId());
        if ($redirect == null)
        {
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
