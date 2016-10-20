<?php

namespace Phlexible\Bundle\RedirectBundle;

/**
 * Redirect events
 *
 * @author Matthias Harmuth <mharmuth@brainbits.net>
 */
interface RedirectEvents
{
    /**
     * Fired before redirects will be saved
     */
    const BEFORE_SAVE = 'phlexible_redirect.before_save';

    /**
     * Fired after redirects have been saved
     */
    const SAVE = 'phlexible_redirect.save';

    /**
     * Fired before redirects will be deleted
     */
    const BEFORE_DELETE = 'phlexible_redirect.before_delete';

    /**
     * Fired after redirects have been deleted
     */
    const DELETE = 'phlexible_redirect.delete';
}
