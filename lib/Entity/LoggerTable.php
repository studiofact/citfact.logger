<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Logger\Entity;

use Bitrix\Main\Entity;

class LoggerTable extends Entity\DataManager
{
    /**
     * {@inheritdoc}
     */
    public static function getFilePath()
    {
        return __FILE__;
    }

    /**
     * {@inheritdoc}
     */
    public static function getTableName()
    {
        return 'b_citfact_logger';
    }

    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return array(
            'ID' => array(
                'data_type' => 'integer',
                'primary' => true,
                'autocomplete' => true,
            ),
            'CHANNEL' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'LEVEL' => array(
                'data_type' => 'integer',
                'required' => true,
            ),
            'MESSAGE' => array(
                'data_type' => 'string',
                'required' => true,
            ),
            'TIME' => array(
                'data_type' => 'integer',
                'required' => true,
            ),
        );
    }
}