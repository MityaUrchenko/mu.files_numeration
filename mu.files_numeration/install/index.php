<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;

//Loc::loadMessages(__FILE__);

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
        $this->MODULE_ID = "mu.files_numeration";
        $this->CLASS_NAME = 'MUfilesNumeration';

        $this->MODULE_NAME = "Нумерация файлов";
        $this->MODULE_DESCRIPTION = "Модуль добавляет нумерацию файлов для свойства типа файл";
        $this->MODULE_VERSION = '1.0.1';
        $this->MODULE_VERSION_DATE = '2025-02-11 21:00:00';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = "Юрченко Дмитрий";
        $this->PARTNER_URI = "";
    }

    public function doInstall() {
        global $DOCUMENT_ROOT, $APPLICATION;

        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('main','OnAdminTabControlBegin', $this->MODULE_ID, $this->CLASS_NAME,'OnAdminTabControlBeginHandler');
        unset($eventManager);

        ModuleManager::registerModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(
            "Установка модуля $this->MODULE_NAME ($this->MODULE_ID)",
            $DOCUMENT_ROOT . "/local/modules/$this->MODULE_ID/install/step.php"
        );
    }

    public function doUninstall() {
        global $DOCUMENT_ROOT, $APPLICATION;

        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main','OnAdminTabControlBegin', $this->MODULE_ID, $this->CLASS_NAME,'OnAdminTabControlBeginHandler');
        unset($eventManager);

        ModuleManager::unregisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile(
            "Деинсталляция модуля $this->MODULE_NAME ($this->MODULE_ID)",
            $DOCUMENT_ROOT . "/local/modules/$this->MODULE_ID/install/unstep.php"
        );
    }
}
