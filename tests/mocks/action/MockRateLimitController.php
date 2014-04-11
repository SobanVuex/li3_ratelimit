<?php

/**
 * Lithium plugin for rate limiting requests.
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_ratelimit\tests\mocks\action;

/**
 * @package li3_ratelimit
 */
class MockRateLimitController extends \lithium\action\Controller
{

    use \li3_ratelimit\extensions\RateLimit;

    /**
     * @return array
     */
    public function index()
    {
        return array('foo' => 'bar');
    }

    /**
     * @return array
     * @throws Exception
     */
    public function limited()
    {
        if ($this->rateLimit()) {
            throw new \Exception('You are rate limited', 429);
        }

        return array('bar' => 'foo');
    }

}
