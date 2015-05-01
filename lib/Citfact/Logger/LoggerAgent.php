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
use Citfact\Logger\Entity\LoggerTable;

class LoggerAgent
{
    /**
     * Deletes old logs, depending on the module settings
     *
     * @param int $logsCount
     */
    public static function cleanLogs($logsCount = 500)
    {
        $logsClean = (Config\Option::get('citfact.logger', 'CLEAN_LOGS') == 'Y');
        $logsTimeStorage = (int)Config\Option::get('citfact.logger', 'STORAGE_TIME');
        $logsCount = (int)$logsCount;

        if ($logsClean === true) {
            $queryBuilder = new Entity\Query(LoggerTable::getEntity());
            $filterResult = $queryBuilder->setSelect(array('ID'))
                ->setFilter(array('<TIME' => time() - $logsTimeStorage))
                ->setLimit($logsCount)
                ->exec();

            while ($filterRow = $filterResult->fetch()) {
                LoggerTable::delete(array('ID' => $filterRow['ID']));
            }
        }

        return "\\Citfact\\Logger\\LoggerAgent::cleanLogs($logsCount)";
    }
}