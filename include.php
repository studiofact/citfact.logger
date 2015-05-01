<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses('citfact.logger', array(
    'Citfact\Logger\Entity\LoggerTable' => 'lib/Citfact/Logger/Entity/LoggerTable.php',
    'Citfact\Logger\Handler\BitrixEntityHandler' => 'lib/Citfact/Logger/Handler/BitrixEntityHandler.php',
    'Citfact\Logger\Logger' => 'lib/Citfact/Logger/Logger.php',
    'Citfact\Logger\LoggerAgent' => 'lib/Citfact/Logger/LoggerAgent.php',
    'Citfact\Logger\LoggerManager' => 'lib/Citfact/Logger/LoggerManager.php',
));