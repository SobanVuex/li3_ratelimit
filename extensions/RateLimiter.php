<?php

/**
 * Lithium plugin for rate limiting requests.
 *
 * @copyright 2014 Alex Soban. See LICENSE for information.
 * @license   http://opensource.org/licenses/MIT
 * @author    Alex Soban <me@soban.co>
 */

namespace li3_ratelimit\extensions;

use lithium\analysis\Logger;
use lithium\storage\Cache;

/**
 * @package li3_ratelimit
 */
class RateLimiter extends \lithium\core\StaticObject
{

    /**
     * Store the access attempts during this check
     *
     * @var integer
     */
    protected static $tries;

    /**
     * 
     * @param  \lithium\action\Request $request
     * @param  array                   $options
     * @return boolean
     */
    public static function check($request, array $options = array())
    {
        $key = static::key($request);

        return static::limit($key, $options) ? : static::increment($key, $options);
    }

    /**
     * Generate a key for this request
     *
     * @param  \lithium\action\Request $request
     * @return string
     */
    protected static function key($request)
    {
        $controller = $request->get('params:controller');
        $action = $request->get('params:action');
        $client = $request->env('REMOTE_ADDR');

        return sprintf('app.ratelimit.%s.%s.%s', $client, $controller, $action);
    }

    /**
     * Check the number of tries for this request
     *
     * @param  string $key
     * @param  array  $options
     * @return boolean
     */
    protected static function limit($key, $options)
    {
        static::$tries = Cache::read($options['cache'], $key) ? : 0;

        return static::$tries > $options['tries'] && static::log($key, $options) ? true : false;
    }

    /**
     * Increment the number tries for this request
     *
     * @param  string $key
     * @param  array  $options
     * @return boolean
     */
    protected static function increment($key, $options)
    {
        Cache::write($options['cache'], $key, static::$tries + 1, $options['expiry']);

        return false;
    }

    /**
     * Write to log
     *
     * @param  string $key
     * @param  type $options
     * @return boolean
     */
    protected static function log($key, $options)
    {
        if ($options['log']) {
            Logger::write($options['log'], sprintf('Rate Limit reached: %s', $key));
        }

        return true;
    }

}
