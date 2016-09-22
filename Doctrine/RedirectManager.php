<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Phlexible\Bundle\ElementRedirect\Event\RedirectEvent;
use Phlexible\Bundle\ElementRedirect\Model\RedirectManagerInterface;
use Phlexible\Bundle\ElementRedirect\RedirectEvents;
use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Redirect manager
 */
class RedirectManager implements RedirectManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TreeManagerInterface
     */
    private $treeManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @return EntityRepository
     */
    private $repository;

    /**
     * @param EntityManagerInterface   $entityManager
     * @param TreeManagerInterface     $treeManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $entityManager, TreeManagerInterface $treeManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->treeManager = $treeManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return EntityRepository
     */
    private function getRedirectRepository()
    {
        if (null === $this->repository) {
            $this->repository = $this->entityManager->getRepository(Redirect::class);
        }

        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function findByNodeAndLanguage(Node $node, $language)
    {
        $redirects = $this->getRedirectRepository()->findBy(array(
            'nodeId' => $node->getId(),
            'language' => $language
        ));

        return $redirects;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByUri($uri)
    {
        $redirect = $this->getRedirectRepository()->findOneBy(array(
            'uri' => $uri,
        ));

        return $redirect;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUri($uri)
    {
        $redirects = $this->getRedirectRepository()->findBy(array(
            'uri' => $uri,
        ));

        return $redirects;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUriAndSiterootId($uri, $siterootId)
    {
        $redirects = $this->findByUri($uri);

        foreach ($redirects as $redirect) {
            $nodeId = $redirect->getNodeId();

            $node = $this->treeManager->getNodeByNodeId($nodeId);

            if ($node->getSiteRootId() === $siterootId) {
                return $redirect;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRedirect(Redirect $redirect)
    {
        $event = new RedirectEvent($redirect);
        if ($this->eventDispatcher->dispatch(RedirectEvents::BEFORE_SAVE, $event)->isPropagationStopped()) {
            return false;
        }

        $this->entityManager->persist($redirect);
        $this->entityManager->flush($redirect);

        $event = new RedirectEvent($redirect);
        $this->eventDispatcher->dispatch(RedirectEvents::SAVE, $event);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRedirect(Redirect $redirect)
    {
        $event = new RedirectEvent($redirect);
        if ($this->eventDispatcher->dispatch(RedirectEvents::BEFORE_DELETE, $event)->isPropagationStopped()) {
            return false;
        }

        $this->entityManager->remove($redirect);
        $this->entityManager->flush($redirect);

        $event = new RedirectEvent($redirect);
        $this->eventDispatcher->dispatch(RedirectEvents::DELETE, $event);
    }
}
