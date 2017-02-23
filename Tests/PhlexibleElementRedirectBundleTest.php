<?php

/*
 * This file is part of the phlexible redirect package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\RedirectBundle\Tests;

use Phlexible\Bundle\RedirectBundle\PhlexibleRedirectBundle;
use PHPUnit\Framework\TestCase;

/**
 * Element redirect bundle test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\RedirectBundle\PhlexibleRedirectBundle
 */
class PhlexibleElementRedirectBundleTest extends TestCase
{
    public function testBundle()
    {
        $bundle = new PhlexibleRedirectBundle();

        $this->assertSame('PhlexibleRedirectBundle', $bundle->getName());
    }
}
