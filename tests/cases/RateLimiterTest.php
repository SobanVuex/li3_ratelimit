<?php

/**
 * Lithium plugin for rate limiting requests.
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_ratelimit\tests\cases;

use lithium\storage\Cache;
use lithium\tests\mocks\core\MockRequest;
use li3_ratelimit\tests\mocks\action\MockRateLimitController;

/**
 * @package li3_ratelimit
 */
class RateLimiterTest extends \lithium\test\Unit
{

    /**
     * Configure a cache for rate limits
     */
    public function setUp()
    {
        if (!Cache::config('rate_limit')) {
            Cache::config(array(
                'rate_limit' => array(
                    'adapter' => 'File',
                    'path' => dirname(__DIR__) . '/cache'
                )
            ));
        }
    }

    /**
     * Test controller regular action
     */
    public function testNotRateLimite()
    {
        $controller = new MockRateLimitController();
        $this->assertEqual($controller->invokeMethod('index'), array('foo' => 'bar'));
    }

    /**
     * Test controller limited action
     */
    public function testRateLimitedOnce()
    {
        $controller = new MockRateLimitController(array('request' => new MockRequest()));
        $this->assertEqual($controller->invokeMethod('limited'), array('bar' => 'foo'));
    }

    /**
     * Test controller limited action that exceeded rate limit
     */
    public function testRateLimitedMultiple()
    {
        $controller = new MockRateLimitController(array('request' => new MockRequest()));
        $callMultiple = function($tries = 6) use ($controller) {
            while ($tries--) {
                $controller->invokeMethod('limited');
            }
        };
        $this->assertException('You are rate limited', $callMultiple);
    }

}
