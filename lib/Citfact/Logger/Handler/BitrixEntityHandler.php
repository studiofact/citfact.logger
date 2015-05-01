<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Logger\Handler;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Bitrix\Main\Entity\DataManager;

class BitrixEntityHandler extends AbstractProcessingHandler
{
    /**
     * @var \Bitrix\Main\Entity\DataManager
     */
    private $entity;

    /**
     * @param DataManager $entity
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(DataManager $entity, $level = Logger::DEBUG, $bubble = true)
    {
        $this->entity = $entity;
        parent::__construct($level, $bubble);
    }

    /**
     * @inheritdoc
     */
    public function write(array $record)
    {
        $this->entity->add(array(
            'CHANNEL' => $record['channel'],
            'LEVEL' => $record['level'],
            'MESSAGE' => $record['formatted'],
            'TIME' => $record['datetime']->format('U'),
        ));
    }
}