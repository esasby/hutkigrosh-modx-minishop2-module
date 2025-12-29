<?php

namespace esas\cmsgate\hutkigrosh\controllers;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:55
 */
use esas\cmsgate\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\cmsgate\hutkigrosh\wrappers\OrderWrapper;
use esas\cmsgate\hutkigrosh\wrappers\OrderWrapperModxMinishop2;
//use esas\cmsgate\hutkigrosh\controllers\ControllerHutkigroshNotify;

class ControllerNotifyModxMinishop2 extends ControllerHutkigroshNotify
{
    private $modx;

    /**
     * ControllerNotifyModxMinishop2 constructor.
     */
    public function __construct(ConfigurationWrapperModxMinishop2 $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
        $this->modx = $configurationWrapper->modx;
    }

    /**
     * По локальному номеру счета (номеру заказа) возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public function getOrderWrapperByOrderNumber($orderNumber)
    {
        $order = $this->configurationWrapper->modx->getObject('msOrder', $orderNumber);
        return empty($order) ? null : new OrderWrapperModxMinishop2($order);
    }
}