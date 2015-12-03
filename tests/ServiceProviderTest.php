<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Pimple\Container;
use Gobline\Logger\Writer\Provider\Pimple\DbLogWriterServiceProvider;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class ServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function testServiceProvider()
    {
        $dsn = 'sqlite:'.__DIR__.'./resources/db.sqlite';
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $pdo = new PDO($dsn, null, null, $options);

        $container = new Container();

        $container['pdo'] = $pdo;

        $container->register(new DbLogWriterServiceProvider());
        $container['logwriter.db.pdo'] = 'pdo';

        $this->assertInstanceOf('Gobline\Logger\Writer\DbLogWriter', $container['logwriter.db']);
    }
}
