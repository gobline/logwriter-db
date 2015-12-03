<?php

/*
 * Gobline
 *
 * (c) Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gobline\Logger\Writer\Provider\Pimple;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Gobline\Logger\Writer\DbLogWriter;
use Gobline\Logger\Writer\TableMetadata;

/**
 * @author Mathieu Decaffmeyer <mdecaffmeyer@gmail.com>
 */
class DbLogWriterServiceProvider implements ServiceProviderInterface
{
    private $reference;

    public function __construct($reference = 'logwriter.db')
    {
        $this->reference = $reference;
    }

    public function register(Container $container)
    {
        $reference = $this->reference;

        $container[$reference.'.table'] = 'logs';

        $container[$reference.'.column.date'] = 'date';
        $container[$reference.'.column.level'] = 'level';
        $container[$reference.'.column.message'] = 'message';
        $container[$reference.'.column.exception_code'] = 'exception_code';
        $container[$reference.'.column.exception_stack_trace'] = 'exception_stack_trace';

        $container[$reference] = function ($c) use ($reference) {
            if (empty($c[$reference.'.pdo'])) {
                throw new \Exception('pdo not specified');
            }
            if (empty($c[$c[$reference.'.pdo']])) {
                throw new \Exception('pdo not found');
            }

            $metadata = new TableMetadata($c[$reference.'.table']);
            $metadata
                ->setColumnDate($c[$reference.'.column.date'])
                ->setColumnLevel($c[$reference.'.column.level'])
                ->setColumnMessage($c[$reference.'.column.message'])
                ->setColumnExceptionCode($c[$reference.'.column.exception_code'])
                ->setColumnExceptionStackTrace($c[$reference.'.column.exception_stack_trace']);

            return new DbLogWriter($c[$c[$reference.'.pdo']], $metadata);
        };
    }
}
