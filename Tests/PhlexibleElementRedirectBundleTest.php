<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\ElementRedirectBundle\Tests;

use Phlexible\Bundle\ElementRedirectBundle\PhlexibleElementRedirectBundle;

/**
 * Element redirect bundle test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleElementRedirectBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBundle()
    {
        $bundle = new PhlexibleElementRedirectBundle();

        $this->assertSame('PhlexibleElementRedirectBundle', $bundle->getName());
    }
}
