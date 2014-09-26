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

use Bitrix\Main\Entity;
use Citfact\Logger\Entity\LoggerTable;

class LoggerManager
{
    /**
     * Return unique channels for menu
     *
     * @return array
     */
    public static function getUniqChannels()
    {
        $queryBuilder = new Entity\Query(LoggerTable::getEntity());
        $filterResult = $queryBuilder
            ->registerRuntimeField('CHANNEL',
                array('expression' => array('DISTINCT CHANNEL')
            ))
            ->setSelect(array('CHANNEL'))
            ->setOrder('ID')
            ->exec();

        $channelList = array();
        while ($channel = $filterResult->fetch()) {
            $channelList[] = array(
                'text' => $channel['CHANNEL'],
                'url' => sprintf('logger.php?find_channel=%s', $channel['CHANNEL']),
            );
        }

        return $channelList;
    }
}