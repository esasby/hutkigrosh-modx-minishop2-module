<?php
namespace esas\cmsgate\hutkigrosh;

use esas\cmsgate\CmsConnector;
use esas\cmsgate\hutkigrosh\lang\LocaleLoaderMs;
use esas\cmsgate\Registry;

class CmsConnectorMs extends CmsConnector
{
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry()
    {
        return Registry::getRegistry()->getCmsConnector();
    }

    public function init() {
        parent::init();
    }

    public function createLocaleLoader()
    {
        return new LocaleLoaderMs();
    }

    public function createCommonConfigForm($managedFields)
    {
        // TODO: Implement createCommonConfigForm() method.
    }

    public function createOrderWrapperByOrderId($orderId)
    {
        // TODO: Implement createOrderWrapperByOrderId() method.
    }

    public function createOrderWrapperForCurrentUser()
    {
        // TODO: Implement createOrderWrapperForCurrentUser() method.
    }

    public function createOrderWrapperByExtId($extId)
    {
        // TODO: Implement createOrderWrapperByExtId() method.
    }

    public function createConfigStorage()
    {
        // TODO: Implement createConfigStorage() method.
    }

    public function createCmsConnectorDescriptor()
    {
        // TODO: Implement createCmsConnectorDescriptor() method.
    }
}