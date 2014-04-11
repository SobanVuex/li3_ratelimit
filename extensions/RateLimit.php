<?php

/**
 * Lithium plugin for rate limiting requests.
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_ratelimit\extensions;

use li3_ratelimit\extensions\RateLimiter;

/**
 * @package li3_ratelimit
 */
trait RateLimit
{

    /**
     * Rate limit the current request to number of `$tries` for period of `$expiry`
     *
     * @param  integer $tries
     * @param  string  $expiry
     * @param  string  $cache
     * @param  string  $log
     * @return boolean
     */
    protected function rateLimit($tries = 5, $expiry = '+5 seconds', $cache = 'rate_limit', $log = 'notice')
    {
        return RateLimiter::check($this->request, compact('tries', 'expiry', 'log', 'cache'));
    }

}
