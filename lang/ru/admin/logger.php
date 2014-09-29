<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$MESS['LOGGER_SECTION_TITLE'] = 'Список логов';
$MESS['LOGGER_TABLE_CHANNEL'] = 'Каннал';
$MESS['LOGGER_TABLE_LEVEL'] = 'Уровень ошибки';
$MESS['LOGGER_TABLE_MESSAGE'] = 'Описание';
$MESS['LOGGER_TABLE_TIME'] = 'Дата добавления';
$MESS['LOGGER_LEVEL_DESC'] = '
<strong>Описание уровней ошибок:</strong>
<p>
- DEBUG (100): Подробная информация отладки.<br>
- INFO (200): Интересные события. Примеры: Пользователь входит в систему, журналы SQL.<br>
- NOTICE (250): Нормальные, но значимые события.<br>
- WARNING (300): Исключительные случаи, которые не ошибки. Примеры: Использование устаревшего API, плохой использованием API, нежелательных вещей, которые не обязательно плохо.<br>
- ERROR (400): Runtime ошибок, которые не требуют немедленных действий, но как правило, должны быть зарегистрированы и контролируются.<br>
- CRITICAL (500): Критические условия. Пример: компонент Применение недоступен, неожиданное исключение.<br>
- ALERT (550): Необходимо принять меры немедленно. Пример: Весь сайт вниз, базы данных недоступен, и т.д. Это должно привести в действие SMS оповещения и разбудить вас.<br>
- EMERGENCY (600): Аварийный: система неработоспособна.
</p>';