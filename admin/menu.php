<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Citfact\Logger\LoggerManager;

Loc::loadMessages(__FILE__);
Loader::includeModule('citfact.logger');

$menuList[] = array(
    'parent_menu' => (Loader::includeModule('citfact.core')) ? 'global_menu_citfact' : 'global_menu_services',
    'section' => 'logger',
    'sort' => 200,
    'text' => Loc::getMessage('LOGGER_TITLE'),
    'url' => 'logger.php',
    'icon' => 'logger_menu_icon',
    'page_icon' => 'logger_page_icon',
    'more_url' => array(),
    'items_id' => 'logger_menu',
    'items' => LoggerManager::getUniqChannels(),
);

return $menuList;