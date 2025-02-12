<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;

if(class_exists('mu_files_numeration')) {
    return;
}

class mu_files_numeration extends CModule {
    public $MODULE_ID;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS;
    public $PARTNER_NAME;
    public $PARTNER_URI;
    public $CLASS_NAME;

    public function __construct() {
        $arModuleVersion = array();
        include_once(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_ID = "mu.files_numeration";
        $this->CLASS_NAME = 'MUfilesNumeration';

        $this->MODULE_NAME = "Нумерация файлов";
        $this->MODULE_DESCRIPTION = "Модуль добавляет нумерацию файлов для свойства типа файл";
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = "Юрченко Дмитрий";
        $this->PARTNER_URI = "";
    }

    public function doInstall() {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('main','OnAdminTabControlBegin', $this->MODULE_ID, $this->CLASS_NAME,'OnAdminTabControlBeginHandler');
        unset($eventManager);

        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall() {
        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main','OnAdminTabControlBegin', $this->MODULE_ID, $this->CLASS_NAME,'OnAdminTabControlBeginHandler');
        unset($eventManager);

        ModuleManager::unregisterModule($this->MODULE_ID);
    }
}
