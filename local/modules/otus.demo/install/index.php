<?php

use \Bitrix\Main\ModuleManager;
use \Bitrix\Main\EventManager;
use \Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED')) {
    die();
}

Loc::loadMessages(__FILE__);

class otus_demo extends CModule
{
    public $MODULE_ID = 'otus.demo';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME = 'OTUS';

    public function __construct()
    {
        $this->MODULE_NAME = GetMessage('OTUS_DEMO_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('OTUS_DEMO_MODULE_DESCRIPTION');

        $this->PARTNER_NAME = GetMessage('OTUS_DEMO_PARTNER_NAME');

        $arModuleVersion = [];
        include(__DIR__ . '/version.php');

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
    }

    public function DoInstall()
    {
        $this->InstallEvents();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        $this->UnInstallEvents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }


    public function InstallEvents(): void
    {
        $eventManager = EventManager::getInstance();

        $eventManager->registerEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Otus\\Demo\\Handlers',
            'updateTabs'
        );

        $eventManager->registerEventHandler(
            'iblock',
            'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            '\\Otus\\Demo\\UserTypes\\AppointmentType',
            'getUserTypeDescription'
        );
    }

    public function UnInstallEvents(): void
    {
        $eventManager = EventManager::getInstance();

        $eventManager->unRegisterEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            '\\Otus\\Demo\\Handlers',
            'updateTabs'
        );

        $eventManager->unRegisterEventHandler(
            'iblock',
            'OnIBlockPropertyBuildList',
            $this->MODULE_ID,
            '\\Otus\\Demo\\UserTypes\\AppointmentType',
            'getUserTypeDescription'
        );
    }
}