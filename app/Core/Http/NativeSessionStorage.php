<?php

namespace App\Core\Http;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage as BaseSessionStorage;

class NativeSessionStorage extends BaseSessionStorage {

    public function __construct(array $options = [], $handler = null, MetadataBag $metaBag = null)
    {
        if (!\extension_loaded('session')) {
            throw new \LogicException('PHP extension "session" is required.');
        }

        $options += [
            'cache_limiter' => '',
            'cache_expire' => 0,
            'use_cookies' => true,
            'lazy_write' => true,
            'use_strict_mode' => true,
            'cookie_httponly' => true,
            // 'cookie_secure' => true
        ];

        session_register_shutdown();

        $this->setMetadataBag($metaBag);
        $this->setOptions($options);
        $this->setSaveHandler($handler);
    }


}