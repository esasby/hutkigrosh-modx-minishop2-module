<?php
/** @var modX $modx */

//use esas\cmsgate\hutkigrosh\utils\LoggerDefault;
use esas\cmsgate\utils\Logger;

switch ($modx->event->name) {
    // добавим автозагрузчик composer-а
    case 'OnMODXInit':
        $file = MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/EsasAutoloader.php';
        if (file_exists($file)) {
            require_once $file;
        }
        Logger::init(); // используем настройки по умолчанию для сохранения логов в безопасном каталоге
        break;
}
