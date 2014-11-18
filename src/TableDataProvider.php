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
class TableDataProvider implements TableDataProviderInterface
{
    private $data = [];

    /**
     * @param string $column
     * @param string $value
     *
     * @throws \InvalidArgumentException
     */
    public function add($column, $value)
    {
        $column = (string) $column;
        if ($column === '') {
            throw new \InvalidArgumentException('$column cannot be empty');
        }

        $this->data[$column] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }
}
