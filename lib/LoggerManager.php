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
use Bitrix\Main\Config;
use Monolog\Logger as BaseLogger;
use Citfact\Logger\Entity\LoggerTable;

class LoggerManager
{
    /**
     * Translates Monolog log levels to html color priorities.
     */
    private static $logLevels = array(
        BaseLogger::DEBUG     => '#cccccc',
        BaseLogger::INFO      => '#468847',
        BaseLogger::NOTICE    => '#3a87ad',
        BaseLogger::WARNING   => '#c09853',
        BaseLogger::ERROR     => '#f0ad4e',
        BaseLogger::CRITICAL  => '#FF7708',
        BaseLogger::ALERT     => '#C12A19',
        BaseLogger::EMERGENCY => '#000000',
    );

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
                'url' => sprintf('logger.php?filter_channel=%s&set_filter=Y', $channel['CHANNEL']),
            );
        }

        return $channelList;
    }

    /**
     * @param int $time
     * @return string
     */
    public static function getFormatTime($time)
    {
        return FormatDate(Config\Option::get('citfact.logger', 'FORMAT_TIME'), $time);
    }

    /**
     * @param int $level
     * @return string
     */
    public static function getViewColorLevel($level)
    {
        return '<span style="color:#ffffff;padding:5px;background:'.self::$logLevels[$level].'">'.$level.'</span>';
    }

    /**
     * @return array
     */
    public static function getLogsLevel()
    {
        return self::$logLevels;
    }
}