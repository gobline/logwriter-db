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

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class TableMetadata
{
    private $tableName;
    private $columnDate;
    private $columnLevel;
    private $columnMessage = 'message';
    private $columnExceptionCode;
    private $columnExceptionStackTrace;

    /**
     * @param string $tableName
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($tableName)
    {
        $tableName = (string) $tableName;
        if ($tableName === '') {
            throw new \InvalidArgumentException('$tableName cannot be empty');
        }

        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return string
     */
    public function getColumnDate()
    {
        return $this->columnDate;
    }

    /**
     * @param string $columnDate
     *
     * @throws \InvalidArgumentException
     *
     * @return TableMetadata
     */
    public function setColumnDate($columnDate)
    {
        $columnDate = (string) $columnDate;
        if ($columnDate === '') {
            throw new \InvalidArgumentException('$columnDate cannot be empty');
        }

        $this->columnDate = $columnDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getColumnLevel()
    {
        return $this->columnLevel;
    }

    /**
     * @param string $columnLevel
     *
     * @throws \InvalidArgumentException
     *
     * @return TableMetadata
     */
    public function setColumnLevel($columnLevel)
    {
        $columnLevel = (string) $columnLevel;
        if ($columnLevel === '') {
            throw new \InvalidArgumentException('$columnLevel cannot be empty');
        }

        $this->columnLevel = $columnLevel;

        return $this;
    }

    /**
     * @return string
     */
    public function getColumnMessage()
    {
        return $this->columnMessage;
    }

    /**
     * @param string $columnMessage
     *
     * @throws \InvalidArgumentException
     *
     * @return TableMetadata
     */
    public function setColumnMessage($columnMessage)
    {
        $columnMessage = (string) $columnMessage;
        if ($columnMessage === '') {
            throw new \InvalidArgumentException('$columnMessage cannot be empty');
        }

        $this->columnMessage = $columnMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getColumnExceptionCode()
    {
        return $this->columnExceptionCode;
    }

    /**
     * @param string $columnExceptionCode
     *
     * @throws \InvalidArgumentException
     *
     * @return TableMetadata
     */
    public function setColumnExceptionCode($columnExceptionCode)
    {
        $columnExceptionCode = (string) $columnExceptionCode;
        if ($columnExceptionCode === '') {
            throw new \InvalidArgumentException('$columnExceptionCode cannot be empty');
        }

        $this->columnExceptionCode = $columnExceptionCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getColumnExceptionStackTrace()
    {
        return $this->columnExceptionStackTrace;
    }

    /**
     * @param string $columnExceptionStackTrace
     *
     * @throws \InvalidArgumentException
     *
     * @return TableMetadata
     */
    public function setColumnExceptionStackTrace($columnExceptionStackTrace)
    {
        $columnExceptionStackTrace = (string) $columnExceptionStackTrace;
        if ($columnExceptionStackTrace === '') {
            throw new \InvalidArgumentException('$columnExceptionStackTrace cannot be empty');
        }

        $this->columnExceptionStackTrace = $columnExceptionStackTrace;

        return $this;
    }
}
