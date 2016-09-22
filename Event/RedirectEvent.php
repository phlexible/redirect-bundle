<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirect\Event;

use Phlexible\Bundle\ElementRedirectBundle\Entity\Redirect;
use Symfony\Component\EventDispatcher\Event;

/**
 * Redirect event
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
