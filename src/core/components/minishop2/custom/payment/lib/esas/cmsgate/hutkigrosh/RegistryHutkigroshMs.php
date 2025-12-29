<?php
/** @var modX $modx */
namespace esas\cmsgate\hutkigrosh;

use esas\cmsgate\hutkigrosh\lang\TranslatorHutkigrosh;
use esas\cmsgate\hutkigrosh\lang\LocaleLoaderMs;
use esas\cmsgate\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;

class RegistryHutkigroshMs extends RegistryHutkigrosh
{
    /** @var modX $modx */
    public $modx;

    public function __construct($modx)
    {
        $this->cmsConnector = new CmsConnectorMs();
        $this->paysystemConnector = new PaysystemConnectorHutkigrosh();

        $this->modx = $modx;
    }

    /**
     * Переопделение для упрощения типизации
     * @return RegistryHutkigroshMs
     */
    public static function getRegistry()
    {
        return parent::getRegistry();
    }

    public function init() {
        parent::init();
    }

    /**
     * @return TranslatorHutkigrosh
     */
    public function createTranslator()
    {
        $localeLoader = new LocaleLoaderMs();
        return new TranslatorHutkigrosh($localeLoader);
    }

    public function createConfigForm()
    {
        // TODO: Implement createConfigForm() method.
    }

    public function createModuleDescriptor()
    {
        // TODO: Implement createModuleDescriptor() method.
    }

    function getUrlAlfaclick($orderWrapper)
    {
        // TODO: Implement getUrlAlfaclick() method.
    }

    function getUrlWebpay($orderWrapper)
    {
        // TODO: Implement getUrlWebpay() method.
    }

    public function createConfigWrapper()
    {
        return new ConfigurationWrapperModxMinishop2($this->modx);
    }
}