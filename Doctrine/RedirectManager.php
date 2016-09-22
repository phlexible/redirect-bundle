<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirectBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Phlexible\Bundle\ElementRedirectBundle\Event\RedirectEvent;
use Phlexible\Bundle\ElementRedirectBundle\Model\RedirectManagerInterface;
use Phlexible\Bundle\ElementRedirectBundle\RedirectEvents;
use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;
use Phlexible\Bundle\TreeBundle\Tree\TreeManager;
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
     * @var TreeManager
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
     * @param TreeManager              $treeManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TreeManager $treeManager,
        EventDispatcherInterface $eventDispatcher
    ) {
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
    public function findByNodeAndLanguage(TreeNodeInterface $node, $language)
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
            'url' => $uri,
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

            $tree = $this->treeManager->getByNodeId($nodeId);

            if ($tree->getSiterootId() === $siterootId) {
                return $redirect;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRedirects(array $redirects)
    {
        foreach ($redirects as $redirect) {
            $this->updateRedirect($redirect);
        }
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
    public function deleteRedirects(array $redirects)
    {
        foreach ($redirects as $redirect) {
            $this->deleteRedirect($redirect);
        }
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
