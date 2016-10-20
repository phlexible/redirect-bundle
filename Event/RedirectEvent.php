<?php

/*
 * This file is part of the phlexible redirect package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\RedirectBundle\Event;

use Phlexible\Bundle\RedirectBundle\Entity\Redirect;
use Symfony\Component\EventDispatcher\Event;

/**
 * Redirect event.
 *
 * @author Matthias Harmuth <mharmuth@brainbits.net>
 */
class RedirectEvent extends Event
{
    /**
     * @var Redirect
     */
    private $redirect;

    /**
     * @param Redirect $redirect
     */
    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @return Redirect
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
}
