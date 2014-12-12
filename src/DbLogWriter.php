<?php

/*
 * Mendo Framework
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mendo\Logger\Writer;

use Psr\Log\AbstractLogger;
use \PDO;

/**
 * Writes log information to a database.
 *
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class DbLogWriter extends AbstractLogger
{
    use GetStackTraceTrait;

    private $pdo;
    private $table;
    private $dataProviders = [];

    /**
     * @param PDO           $pdo
     * @param TableMetaData $table
     */
    public function __construct(PDO $pdo, TableMetaData $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $values = [];

        $values[$this->table->getColumnMessage()] = (string) $message;

        if ($this->table->getColumnLevel()) {
            $values[$this->table->getColumnLevel()] = (string) $level;
        }

        if ($this->table->getColumnDate()) {
            $values[$this->table->getColumnDate()] = date('Y-m-d H:i:s');
        }

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            if ($this->table->getColumnExceptionCode()) {
                $values[$this->table->getColumnExceptionCode()] = $context['exception']->getCode();
            }
            if ($this->table->getColumnExceptionStackTrace()) {
                $values[$this->table->getColumnExceptionStackTrace()] = $this->getExceptionStackTrace($context['exception']);
            }
        }

        foreach ($this->dataProviders as $provider) {
            $values = $values + $provider->getData();
        }

        $this->insert($this->table->getTableName(), $values);
    }

    /**
     * @param string $tableName
     * @param array  $arrNameValuePairs
     */
    private function insert($tableName, array $arrNameValuePairs)
    {
        $sql = 'INSERT INTO '.$tableName.'(';
        $prefix = '';
        foreach ($arrNameValuePairs as $key => $value) {
            $sql .= $prefix.$key;
            $prefix = ', ';
        }
        $sql .= ') VALUES (';
        $prefix = ':';
        foreach ($arrNameValuePairs as $key => $value) {
            $sql .= $prefix.$key;
            $prefix = ', :';
        }
        $sql .= ')';
        $stmt = $this->pdo->prepare($sql);
        foreach ($arrNameValuePairs as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }
        $stmt->execute();
    }

    /**
     * @param TableDataProviderInterface $provider
     */
    public function addDataProvider(TableDataProviderInterface $provider)
    {
        $this->dataProviders[] = $provider;
    }
}
