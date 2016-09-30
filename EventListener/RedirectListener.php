<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirectBundle\EventListener;

use Phlexible\Bundle\ElementRedirectBundle\Model\RedirectManagerInterface;
use Phlexible\Bundle\SiterootBundle\Siteroot\SiterootRequestMatcher;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * Redirect listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class RedirectListener implements EventSubscriberInterface
{
    /**
     * @var RedirectManagerInterface
     */
    private $redirectManager;

    /**
     * @var ContentTreeManagerInterface
     */
    private $treeManager;

    /**
     * @var SiterootRequestMatcher
     */
    private $requestMatcher;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RedirectManagerInterface    $redirectManager
     * @param ContentTreeManagerInterface $treeManager
     * @param SiterootRequestMatcher      $requestMatcher
     * @param RouterInterface             $router
     */
    public function __construct(
        RedirectManagerInterface $redirectManager,
        ContentTreeManagerInterface $treeManager,
        SiterootRequestMatcher $requestMatcher,
        RouterInterface $router
    ) {
        $this->redirectManager = $redirectManager;
        $this->treeManager = $treeManager;
        $this->requestMatcher = $requestMatcher;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _country
            KernelEvents::REQUEST => array(array('onKernelRequest', 14)),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $uri = $request->getPathInfo();

        if (!$uri || $uri == '/') {
            return;
        }

        $siteroot = $this->requestMatcher->matchRequest($request);

        if (!$siteroot) {
            return;
        }

        $redirect = $this->redirectManager->findByUriAndSiterootId($uri, $siteroot->getId());
        if (!$redirect) {
            return;
        }

        $language = $redirect->getLanguage();
        $tree = $this->treeManager->findByTreeId($redirect->getNodeId());
        $node = $tree->get($redirect->getNodeId());

        if (!$tree->isPublished($node, $language)) {
            return;
        }

        $event->setResponse(new RedirectResponse($this->router->generate($node)));
    }
}
