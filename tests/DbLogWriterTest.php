<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Mendo\Logger\Writer\DbLogWriter;
use Mendo\Logger\Writer\TableMetadata;
use \PDO;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{
    private $pdo;

    public function setUp()
    {
        $dsn = 'sqlite:'.__DIR__.'./resources/db.sqlite';
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );
        $this->pdo = new PDO($dsn, null, null, $options);

        $sql = 'DROP TABLE IF EXISTS log_errors';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $sql =
            'CREATE TABLE IF NOT EXISTS log_errors
            (
                id INTEGER NOT null PRIMARY KEY AUTOINCREMENT,
                level VARCHAR(20) NOT null,
                message VARCHAR(255) NOT null,
                exception_code INTEGER,
                exception_stack_trace TEXT,
                UNIQUE (id)
            );';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function testLoggerDbTable()
    {
        $metadata = new TableMetadata('log_errors');
        $metadata
            ->setColumnLevel('level')
            ->setColumnMessage('message')
            ->setColumnExceptionCode('exception_code')
            ->setColumnExceptionStackTrace('exception_stack_trace');

        $logger = new DbLogWriter($this->pdo, $metadata);

        $logger->error('something wrong happened', ['exception' => new \Exception('something wrong happened')]);

        $this->assertEquals(1, $this->pdo->lastInsertId());

        $sql = 'SELECT message FROM log_errors';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $this->assertSame('something wrong happened', $stmt->fetchColumn());
    }
}
