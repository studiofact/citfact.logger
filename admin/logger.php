<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once getenv('DOCUMENT_ROOT') . '/bitrix/modules/main/include/prolog_admin_before.php';

use Citfact\Logger\Entity\LoggerTable;
use Citfact\Logger\LoggerManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Entity;

Loc::loadMessages(__FILE__);

\Bitrix\Main\Loader::includeModule('citfact.logger');

$app = \Bitrix\Main\Application::getInstance();
$request = $app->getContext()->getRequest();

$moduleId = 'citfact.logger';
$currentPage = $GLOBALS['APPLICATION']->GetCurPage();

$headers = array(
    array('id' => 'ID', 'content' => 'ID', 'sort' => 'ID', 'default' => true),
    array('id' => 'CHANNEL', 'content' => Loc::getMessage('LOGGER_TABLE_CHANNEL'), 'sort' => 'CHANNEL', 'default' => true),
    array('id' => 'LEVEL', 'content' => Loc::getMessage('LOGGER_TABLE_LEVEL'), 'sort' => 'LEVEL', 'default' => true),
    array('id' => 'MESSAGE', 'content' => Loc::getMessage('LOGGER_TABLE_MESSAGE'), 'sort' => 'MESSAGE', 'default' => true),
    array('id' => 'TIME', 'content' => Loc::getMessage('LOGGER_TABLE_TIME'), 'sort' => 'TIME', 'default' => true),
);

$filterFields = array(
    'filter_channel' => array('code' => 'CHANNEL', 'name' => Loc::getMessage('LOGGER_TABLE_CHANNEL'), 'type' => array('text')),
    'filter_level' => array('code' => 'LEVEL', 'name' => Loc::getMessage('LOGGER_TABLE_LEVEL'), 'type' => array('text')),
    'filter_message' => array('code' => 'MESSAGE', 'name' => Loc::getMessage('LOGGER_TABLE_MESSAGE'), 'type' => array('text')),
    'filter_time' => array('code' => 'TIME', 'name' => Loc::getMessage('LOGGER_TABLE_TIME'), 'type' => array('period')),
);

$tableId = 'tbl_logger';
$adminSort = new CAdminSorting($tableId, 'ID', 'asc');
$adminList = new CAdminList($tableId, $adminSort);
$adminFilter = new CAdminFilter(
    $tableId . '_filter',
    array(
        $filterFields['filter_channel']['name'],
        $filterFields['filter_level']['name'],
        $filterFields['filter_message']['name'],
        $filterFields['filter_time']['name'],
    )
);

$adminList->addHeaders($headers);
$adminList->initFilter(array_keys($filterFields));

$sortBy = ($request->getQuery('by')) ? strtoupper($request->getQuery('by')) : 'ID';
$sortOrder = ($request->getQuery('order')) ? : 'asc';

$requestFilter = array();
foreach ($filterFields as $fieldName => $params) {
    foreach ($request->getQueryList()->toArray() as $query => $value) {
        if ($fieldName != $query || $params['type'][0] == 'period') continue;
        $requestFilter[$params['code']] = trim($value);
        $filterFields[$fieldName]['value'] = htmlspecialchars($value);
    }

    if (!isset($filterFields[$fieldName]['value'])) {
        $filterFields[$fieldName]['value'] = '';
    }
}

$filterFields['filter_time']['value'][0] = $dateFirst = trim($request->getQuery('filter_time'));
$filterFields['filter_time']['value'][1] = $dateSecond = trim($request->getQuery('filter_time_interval'));
if (strlen($dateFirst) > 0 || strlen($dateSecond) > 0) {
    $dateFirst = MkDateTime(FmtDate($dateFirst, 'D.M.Y'), 'd.m.Y');
    $dateSecond = MkDateTime(FmtDate($dateSecond, 'D.M.Y').' 23:59', 'd.m.Y H:i');
    $requestFilter['><TIME'] = array($dateFirst, $dateSecond);
}

$queryBuilder = new Entity\Query(LoggerTable::getEntity());
$queryBuilder->setSelect(array('*'))
    ->setFilter($requestFilter)
    ->setOrder(array($sortBy => $sortOrder));

$resultData = new CAdminResult($queryBuilder->exec(), $tableId);
$resultData->navStart();

$adminList->navText($resultData->getNavPrint(Loc::getMessage('PAGES')));
while ($item = $resultData->fetch()) {
    $row =& $adminList->addRow($item['ID'], $item);
    $row->AddViewField('TIME', LoggerManager::getFormatTime($item['TIME']));
    $row->AddViewField('LEVEL', LoggerManager::getViewColorLevel($item['LEVEL']));
}

$GLOBALS['APPLICATION']->SetTitle(Loc::getMessage('LOGGER_SECTION_TITLE'));
$adminList->checkListMode();

require getenv('DOCUMENT_ROOT') . '/bitrix/modules/main/include/prolog_admin_after.php';
?>
<form name="find_form" method="GET" action="<?= $currentPage ?>?">
    <?
    $adminFilter->Begin();
    foreach ($filterFields as $fieldName => $params): ?>
        <tr>
            <td><?= $params['name'] ?>:</td>
            <td>
                <? if ($params['type'][0] == 'checkbox'): ?>
                    <input type="checkbox" name="<?= $fieldName ?>"
                           value="Y" <?= ($params['value'] == 'Y') ? 'checked' : '' ?>>
                <? elseif ($params['type'][0] == 'text'): ?>
                    <input type="text" maxlength="255"
                           value="<?= $params['value'] ?>" name="<?= $fieldName ?>">
                <? elseif ($params['type'][0] == 'textarea'): ?>
                    <textarea rows="<?= $params['type'][1] ?>" cols="<?= $params['type'][2] ?>"
                              name="<? $fieldName ?>"><?= $params['value'] ?></textarea>
                <? elseif ($params['type'][0] == 'period'): ?>
                    <?= CalendarPeriod($fieldName, $params['value'][0], $fieldName.'_interval', $params['value'][1], 'find_form', 'Y') ?>
                <? endif ?>
            </td>
        </tr>
    <? endforeach;
    $adminFilter->Buttons(array('table_id' => $tableId, 'url' => $currentPage, 'form' => 'find_form'));
    $adminFilter->End();
    ?>
</form>
<?
$adminList->displayList();

echo BeginNote();
echo Loc::getMessage('LOGGER_LEVEL_DESC');
echo EndNote();

require getenv('DOCUMENT_ROOT') . '/bitrix/modules/main/include/epilog_admin.php';