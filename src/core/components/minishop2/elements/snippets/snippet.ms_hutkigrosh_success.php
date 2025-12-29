<?php
use esas\cmsgate\hutkigrosh\controllers\ControllerWebpayFormModxMinishop2;
use esas\cmsgate\hutkigrosh\utils\QRUtils;
use esas\cmsgate\hutkigrosh\view\client\ClientViewFieldsHutkigrosh;
use esas\cmsgate\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\cmsgate\hutkigrosh\wrappers\OrderWrapperModxMinishop2;
use esas\cmsgate\CmsPlugin;
use esas\cmsgate\hutkigrosh\RegistryHutkigroshMs;
use esas\cmsgate\lang\Translator;

global $modx;
/** @var modX $modx */

//require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';
(new CmsPlugin(dirname(__FILE__, 5) . '/vendor', dirname(__FILE__)))
    ->setRegistry(new RegistryHutkigroshMs($modx))
    ->init();

/** @var array $scriptProperties */
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.mspHutkigrosh.success');

$configuration = new ConfigurationWrapperModxMinishop2($modx);
$order = $modx->getObject('msOrder', $_GET['msorder']);

$orderWrapper = new OrderWrapperModxMinishop2($order);
$chunkProperties = array('order_number' => $orderWrapper->getOrderId(), 'order_instruction' => $configuration->cookText(Translator::fromRegistry()->translate(ClientViewFieldsHutkigrosh::INSTRUCTIONS), $orderWrapper));

if ($configuration->isWebpayButtonEnabled()) {
    $controller = new ControllerWebpayFormModxMinishop2($configuration);
    $webpayResp = $controller->process($orderWrapper);
    $chunkProperties['webpay_button_enabled'] = true;
    $chunkProperties['webpay_status'] = $_GET['webpay_status']; // при возврате с webpay, статус передается в параметрах адреса
    $chunkProperties['webpay_form'] = $webpayResp->getHtmlForm(); // при возврате с webpay, статус передается в параметрах адреса
}
if ($configuration->isQRCodeEnabled()) {
    $chunkProperties['qr_code'] = QRUtils::getEripBillQR($orderWrapper);
    $chunkProperties['qr_details'] = strtr(Translator::fromRegistry()->translate(ClientViewFieldsHutkigrosh::QRCODE_DETAILS), array(
        "@qr_code" => QRUtils::getEripBillQR($orderWrapper)
    ));
}
if ($configuration->isAlfaclickButtonEnabled()) {
    $chunkProperties['alfaclick_button_enabled'] = true;
    $chunkProperties['alfaclick_url'] = $modx->getOption('site_url') . "assets/components/minishop2/payment/hutkigrosh.php?action=alfaclick";
    $chunkProperties['alfaclick_phone'] = $orderWrapper->getMobilePhone();
    $chunkProperties['alfaclick_bill_id'] = $orderWrapper->getBillId();
}


/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

return $pdoTools->getChunk($tpl, $chunkProperties);