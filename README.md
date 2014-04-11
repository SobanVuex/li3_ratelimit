li3_ratelimit
=============

| Quality / Metrics | Releases | Downloads | Licence |
| ----------------- | -------- | --------- | ------- |
[![Build Status](https://travis-ci.org/SobanVuex/li3_ratelimit.png?branch=master)](https://travis-ci.org/SobanVuex/li3_ratelimit) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SobanVuex/li3_ratelimit/badges/quality-score.png?s=fa9835cad5937551780734cf55fb83e56de8cfbf)](https://scrutinizer-ci.com/g/SobanVuex/li3_ratelimit/) | [![Latest Stable Version](https://poser.pugx.org/sobanvuex/li3_ratelimit/version.png)](https://packagist.org/packages/sobanvuex/li3_ratelimit) [![Latest Unstable Version](https://poser.pugx.org/sobanvuex/li3_ratelimit/v/unstable.png)](https://packagist.org/packages/sobanvuex/li3_ratelimit) | [![Composer Downloads](https://poser.pugx.org/sobanvuex/li3_ratelimit/d/total.png)](https://packagist.org/packages/sobanvuex/li3_ratelimit) | [![License](https://poser.pugx.org/sobanvuex/li3_ratelimit/license.png)](https://packagist.org/packages/sobanvuex/li3_ratelimit)

Requirements
------------

- PHP >=5.4 - The RateLimit is available via PHP's traits

Installation
------------

Using Composer's command line interface:

```bash
php composer.phar require sobanvuex/li3_ratelimit:~0.1
```

- - -

Manually adding the requirements to `composer.json`:

```js
"require": {
    "sobanvuex/li3_ratelimit": "~0.1"
}
```

Usage
-----

Add a cache configuration for the rate limit counters

```php
<?php

// app/bootstrap/cache.php

use lithium\storage\Cache;

Cache::config(array(
    // other cache configurations
    'rate_limit' => array(
        'adapter' => 'File' // Or any other cache configuration.
        // There is no need for strategy as this cache will store only integers
    )
));
```

To add it to your lithium controller add it as a trait

```php
<?php

// app/controllers/MyController.php

namespace app\controllers;

class MyController extends \lithium\action\Controller
{

    use \li3_ratelimit\extensions\RateLimit;

}

```

- - -

To rate limit an action

```php
<?php

// app/controllers/MyController.php

namespace app\controllers;

class MyController extends \lithium\action\Controller
{

    use \li3_ratelimit\extensions\RateLimit;

    public function index()
    {
        if ($this->rateLimit()) {
            // Code which will handle requests exceeding the rate limit
        }

        // continue as usual
    }
}

```

- - -


Parameters

- `$tries` - Number of tries. Default is `5`.
- `$expiry` - How long it takes to expire tries. Default is `+5 seconds`.
- `$cache` - The cache configuration to use. Default is `rate_limit`.
- `$log` - The logger priority to use. Default is `notice`. Use `false` to disable
