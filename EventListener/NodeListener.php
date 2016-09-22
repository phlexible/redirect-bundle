<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirectBundle\EventListener;

use Phlexible\Bundle\ElementBundle\ElementEvents;
use Phlexible\Bundle\ElementBundle\Event\LoadDataEvent;
use Phlexible\Bundle\ElementBundle\Event\SaveNodeDataEvent;
use Phlexible\Bundle\ElementRedirectBundle\Model\RedirectManagerInterface;
use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;
use Phlexible\Bundle\TreeBundle\Event\NodeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Node listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeListener implements EventSubscriberInterface
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

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ElementEvents::LOAD_DATA => 'onLoadElement',
            ElementEvents::SAVE_NODE_DATA => 'onSaveNodeData',
        );
    }

    /**
     * @param LoadDataEvent $event
     */
    public function onLoadElement(LoadDataEvent $event)
    {
        $node = $event->getNode();
        $language = $event->getLanguage();
        $data = $event->getData();

        $redirects = array();
        foreach ($this->redirectManager->findByNodeAndLanguage($node, $language) as $redirect) {
            $redirects[] = array(
                'id'       => $redirect->getId(),
                'nodeId'   => $redirect->getNodeId(),
                'language' => $redirect->getLanguage(),
                'url'      => $redirect->getUrl(),
            );
        }

        $data->redirects = $redirects;
    }

    /**
     * @param SaveNodeDataEvent $event
     */
    public function onSaveNodeData(SaveNodeDataEvent $event)
    {
        $node = $event->getNode();
        $language = $event->getLanguage();
        $request = $event->getRequest();

        $redirects = $this->redirectManager->findByNodeAndLanguage($node, $language);
        $this->redirectManager->deleteRedirects($redirects);

        if ($request->request->has('redirect')) {
            // save redirect data
            $uris = $request->request->get('redirect');
            if ($uris) {
                $uris = json_decode($uris);
                $redirects = array();
                foreach ($uris as $uri) {
                    $redirects[] = new Redirect($node->getId(), $language, $uri);
                }
                $this->redirectManager->updateRedirects($redirects);
            }
        }
    }
}
