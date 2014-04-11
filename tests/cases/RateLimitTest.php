<?php

/**
 * Lithium plugin for rate limiting requests.
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_ratelimit\tests\cases;

use li3_ratelimit\tests\mocks\action\MockRateLimitController;

/**
 * @package li3_ratelimit
 */
class RateLimitTest extends \lithium\test\Unit
{

    /**
     * Test that controller has the rateLimit() method
     */
    public function testCallableRateLimit()
    {
        $controller = new MockRateLimitController();
        $this->assertTrue($controller->respondsTo('rateLimit', true));
    }

}
