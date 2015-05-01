Логгер для 1C-Bitrix
=========

Модуль позволяет логгировать данные в вашем приложение. Расширяет функционал [monolog](https://github.com/Seldaek/monolog).

## Требования

 - PHP версия >= 5.3.3
 - Bitrix версия >= 14

## Установка

Создайте или обновите ``composer.json`` файл и запустите ``php composer.phar update``
``` json
  {
      "require": {
          "citfact/logger": "dev-master"
      }
  }
```
Подключить composer автолоадер 
``` php
// init.php

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
```

## Пример использования

``` php
\Bitrix\Main\Loader::includeModule('citfact.logger');

// Create a log channel
$logger = new \Citfact\Logger\Logger('Sale');

$logger->addDebug('Debug');
$logger->addInfo('Info');
$logger->addNotice('Notice');
$logger->addWarning('Warning');
$logger->addError('Error');
$logger->addCritical('Critical');
$logger->addAlert('Alert');
$logger->addEmergency('Emergency');
```

Регистрация каналов глобально в приложение

``` php
// init.php

\Bitrix\Main\Loader::includeModule('citfact.logger');

$sale = new \Citfact\Logger\Logger('Sale');

// Или другой хандлер
$order = new \Monolog\Logger('Order');
$order->pushHandler(new \Monolog\Handler\StreamHandler('path/to/your.log', Logger::WARNING));

// Регистрируем
Monolog\Registry::addLogger($sale);
Monolog\Registry::addLogger($order);

// test.php

Monolog\Registry::sale()->addError('Error');
Monolog\Registry::order()->addAlert('Alert');
```