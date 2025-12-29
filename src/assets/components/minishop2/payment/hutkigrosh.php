<?php

use esas\cmsgate\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\cmsgate\hutkigrosh\controllers\ControllerNotifyModxMinishop2;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshAlfaclick;

if (!isset($modx)) {
    define('MODX_API_MODE', true);
    require dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

    $modx->getService('error', 'error.modError');
    $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
}
$modx->error->message = null;

switch ($_GET['action']) {
    case 'alfaclick':
        $controller = new ControllerHutkigroshAlfaclick(new ConfigurationWrapperModxMinishop2($modx));
        $controller->process($_REQUEST['bill_id'], $_REQUEST['phone']);
        break;
    case 'notify':
        $controller = new ControllerNotifyModxMinishop2(new ConfigurationWrapperModxMinishop2($modx));
        $controller->process($_REQUEST['purchaseid']);
        break;
}




