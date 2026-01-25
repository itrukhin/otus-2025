<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;
\Bitrix\Main\Loader::includeModule('currency');

$allCurrencies = \Bitrix\Currency\CurrencyManager::getCurrencyList();

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'CURRENCY' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::GetMessage('CURRENCY'),
            'TYPE' => 'LIST',
            'VALUES' => $allCurrencies,
            'DEFAULT' => 'news',
            'REFRESH' => 'Y',
        ],
    ],
];