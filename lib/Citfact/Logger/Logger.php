<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Logger;

use Citfact\Logger\Entity\LoggerTable;
use Citfact\Logger\Handler\BitrixEntityHandler;
use Monolog\Logger as BaseLogger;

class Logger extends BaseLogger
{
    /**
     * @param string             $name       The logging channel
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     */
    public function __construct($name, array $handlers = array(), array $processors = array())
    {
        parent::__construct($name, $handlers, $processors);

        // Add default handler
        $this->pushHandler(new BitrixEntityHandler(new LoggerTable()));
    }

    /**
     * Proxy adds a log record.
     *
     * @param  integer $level   The logging level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = array())
    {
        parent::addRecord($level, $message, $context);
    }
}