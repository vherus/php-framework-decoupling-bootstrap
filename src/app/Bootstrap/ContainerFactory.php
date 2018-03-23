<?php

namespace Vherus\Bootstrap;

use Depot\Bus\NativeCommandBus;
use Depot\CommandBus;
use Depot\Resolution\NativeNamespaceResolver;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Vherus\Application\Http\ApiV1\RouteMapper as ApiRouteMapper;
use Vherus\Application\Http\App\RouteMapper as HttpRouteMapper;
use Vherus\Application\Http\Healthcheck\RouteMapper as HealthcheckRouteMapper;
use Vherus\Framework\Depot\Container as DepotContainer;
use Vherus\Framework\Middleware\Auth\ArrayAuthoriser;
use Vherus\Framework\Middleware\Auth\Authoriser;
use Vherus\Framework\Middleware\Auth\Stratigility\SessionStore;
use Vherus\Framework\Middleware\Auth\Stratigility\StoragelessSession;
use Vherus\Framework\Http\Router\Router;
use Vherus\Framework\Time\Clock;
use Vherus\Framework\Time\SystemClock;
use DI\ContainerBuilder;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Database\Connection;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\SQLiteConnection;
use Interop\Container\ContainerInterface as IContainer;
use Psr\Log\LoggerInterface as ILogger;
use Psr\Log\NullLogger;
use PSR7Sessions\Storageless\Http\SessionMiddleware;

class ContainerFactory
{
    private $config;

    public function create(Config $config = null): IContainer
    {
        $this->config = $config;

        return (new ContainerBuilder)
            ->useAutowiring(true)
            ->ignorePhpDocErrors(true)
            ->useAnnotations(false)
            ->writeProxiesToFile(false)
            ->addDefinitions($this->getDefinitions())
            ->build();
    }

    protected function getDefinitions(): array
    {
        return array_merge(
            $this->defineConfig(),
            $this->defineFramework(),
            $this->defineDomain(),
            $this->defineApplications()
        );
    }

    protected function defineConfig(): array
    {
        return [
            Config::class => \DI\factory(function () {
                return $this->config;
            }),
        ];
    }

    private function defineFramework(): array
    {
        return array_merge($this->defineDatabase(), [

            Clock::class => \DI\object(SystemClock::class),

            IContainer::class => \DI\factory(function (IContainer $container) {
                return $container;
            }),

            Router::class => \DI\decorate(function (Router $router, IContainer $container) {
                return $router
                    ->addRoutes($container->get(HttpRouteMapper::class))
                    ->addRoutes($container->get(ApiRouteMapper::class))
                    ->addRoutes($container->get(HealthcheckRouteMapper::class));
            }),

            SessionMiddleware::class => \DI\factory(function (IContainer $container) {
                $config = ConfigFactory::fromContainer($container);
                return SessionMiddleware::fromSymmetricKeyDefaults(
                    $config->get('session.crypt-key'),
                    $config->get('session.expiry')
                );
            }),

            Authoriser::class => \DI\factory(function (IContainer $container) {
                $config = $container->get(Config::class);
                return new ArrayAuthoriser($config->get('auth.authorized-keys'), []);
            }),

            SessionStore::class => \DI\factory(function (IContainer $container) {
                return $container->get(StoragelessSession::class);
            }),

            ILogger::class => \DI\factory(function (IContainer $container) {
                switch ($logger = $container->get(Config::class)->get('log.logger')) {
                    case 'monolog':
                        $logger = new Logger('error');
                        $logger->pushHandler(new ErrorLogHandler);
                        return $logger;

                    case 'null':
                        return new NullLogger;

                    default:
                        throw new \UnexpectedValueException("Logger '$logger' not recognised");
                }
            }),

            CommandBus::class => \DI\factory(function (IContainer $container) {
                return new NativeCommandBus(
                    new NativeNamespaceResolver(
                        new DepotContainer($container)
                    )
                );
            }),
        ]);
    }

    /**
     * @return array
     */
    private function defineDomain(): array
    {
        return [
            //
        ];
    }

    /**
     * @return array
     */
    private function defineApplications(): array
    {
        return [
            //
        ];
    }

    /**
     * @return array
     */
    private function defineDatabase(): array
    {
        return [
            AbstractSchemaManager::class => \DI\factory(function (IContainer $container) {
                return $container->get(Connection::class)->getDoctrineSchemaManager();
            }),

            Connection::class => \DI\factory(function (IContainer $container) {

                $config = $container->get(Config::class);

                $dsn = $config->get('database.default.pdo.dsn');

                if (substr($dsn, 0, 5) === 'mysql') {
                    return new MySqlConnection($container->get(\PDO::class));
                }

                if (substr($dsn, 0, 6) === 'sqlite') {
                    return new SQLiteConnection($container->get(\PDO::class));
                }

                throw new \RuntimeException("Unrecognised DSN {$dsn}");
            }),

            \Doctrine\DBAL\Driver\Connection::class => \DI\factory(function (IContainer $container) {
                return $container->get(Connection::class)->getDoctrineConnection();
            }),

            \PDO::class => \DI\factory(function (IContainer $container) {
                $config = $container->get(Config::class);
                $pdo = new \PDO(
                    $config->get('database.default.pdo.dsn'),
                    $config->get('database.default.pdo.user'),
                    $config->get('database.default.pdo.pass')
                );
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return $pdo;
            }),
        ];
    }
}
