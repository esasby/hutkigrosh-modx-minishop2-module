<?php
if (!class_exists('msPaymentInterface')) {
    if( is_file( dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php' ) )
        require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
    if( is_file( dirname(dirname(dirname(__FILE__))) . '/handlers/mspaymenthandler.class.php' ) )
        require_once dirname(dirname(dirname(__FILE__))) . '/handlers/mspaymenthandler.class.php';
}

require_once('init.php');

use esas\cmsgate\hutkigrosh\ConfigurationFieldsModx;
use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshAddBill;
use esas\cmsgate\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\cmsgate\hutkigrosh\wrappers\OrderWrapperModxMinishop2;
use esas\cmsgate\utils\Logger;

global $modx;
/** @var modX $modx */

//require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';

class Hutkigrosh extends msPaymentHandler implements msPaymentInterface
{
    public static $configurationWrapper;

    function __construct(xPDOObject $object, $config = array())
    {
        parent::__construct($object, $config);
        Logger::init();
    }

    /* @inheritdoc} */
    public function send(msOrder $order)
    {
        try {
            if ($order->get('status') > 1) {
                return $this->error('ms2_err_status_wrong');
            }
            $orderWrapper = new OrderWrapperModxMinishop2($order);
            $configurationWrapper = new ConfigurationWrapperModxMinishop2($this->modx);
            $controller = new ControllerHutkigroshAddBill($configurationWrapper);
            $context = $order->get('context');
            $params['msorder'] = $orderWrapper->getOrderId();
            $controller->process($orderWrapper);
            $resourceId = $configurationWrapper->getSuccessResourceId();
            $redirectURL = $this->modx->makeUrl($resourceId, $context, $params, 'full', array("xhtml_urls" => false));
            return $this->success('', array('redirect' => $redirectURL));
        } catch (Throwable $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                'Code[' . $e->getCode() . "]: " . $e->getMessage() . " Trace:" . $e->getTraceAsString());
            return $this->error("Произошла ошибка: " . $e->getMessage() . ". Обратитесь к администратору.");
        }
    }

    /* @inheritdoc} */
    public function receive(msOrder $order, $params = array())
    {
        return true;
    }
}




