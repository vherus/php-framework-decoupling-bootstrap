<?php

namespace Vherus\Bootstrap;

use Interop\Container\ContainerInterface as IContainer;
use Psr\Container\ContainerExceptionInterface as IContainerException;

class ConfigFactory
{
    /**
     * @param array $overrides
     *  Values to override in from the default values, as dot-notation values.
     *
     * @return Config
     */
    public static function create(array $overrides = []): Config
    {
        return new Config(array_merge([

            'app' => [
                'host' => getenv('APP_HOST'),
            ],

            'database' => [
                'default' => [
                    'pdo' => [
                        'dsn' => self::fromEnv('DB_DSN'),
                        'user' => self::fromEnv('DB_USER'),
                        'pass' => self::fromEnv('DB_PASS'),
                    ]
                ]
            ],

            'auth' => [
                'ignored-uris' => [
                    '/healthcheck'
                ],

                'authorized-keys' => [
                    //
                ],
            ],

            'session' => [
                /**
                 * The encryption key to use when encrypting session data
                 *
                 * This must be overridden in live environments. Run `src/vendor/bin/cryptokey generate` to generate a
                 * new key, or see https://github.com/AndrewCarterUK/CryptoKey#usage
                 */
                'crypt-key' => self::fromEnv('SESSION_CRYPT_KEY') ?: 'mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw',

                /**
                 * Session expiry duration, in seconds
                 */
                'expiry' => 3600
            ],

            'log' => [
                /**
                 * Which psr/log implementation to use. Options: monolog, null
                 */
                'logger' => self::fromEnv('LOG_LOGGER') ?: 'monolog'
            ]
        ], $overrides));
    }

    private static function fromEnv(string $key, $default = null)
    {
        if ($val = getenv($key)) {
            return $val;
        }

        if ($path = getenv("{$key}_FILE")) {
            if (file_exists($path)) {
                return file_get_contents($path);
            }
        }

        return $default;
    }

    /** @throws IContainerException */
    public static function fromContainer(IContainer $container): Config
    {
        return $container->get(Config::class);
    }
}
