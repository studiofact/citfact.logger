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

if (file_exists(getenv('DOCUMENT_ROOT').'/vendor/autoload.php')) {
    require_once getenv('DOCUMENT_ROOT').'/vendor/autoload.php';
}

Loader::registerAutoLoadClasses('citfact.logger', array(
    'Citfact\Logger\Formatter\BitrixEntityFormatter' => 'lib/Formatter/BitrixEntityFormatter.php',
    'Citfact\Logger\Handler\BitrixEntityHandler' => 'lib/Handler/BitrixEntityHandler.php',
    'Citfact\Logger\Logger' => 'lib/Logger.php',
    'Citfact\Logger\LoggerAgent' => 'lib/LoggerAgent.php',
));
