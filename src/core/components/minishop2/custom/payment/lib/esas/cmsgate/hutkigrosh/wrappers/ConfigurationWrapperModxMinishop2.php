<?php
namespace esas\cmsgate\hutkigrosh\wrappers;

use esas\cmsgate\hutkigrosh\ConfigFieldsHutkigrosh;
use esas\cmsgate\hutkigrosh\ConfigurationFieldsModx;
use esas\cmsgate\utils\Logger;

require_once( dirname(__FILE__, 6) . '\init.php');

class ConfigurationWrapperModxMinishop2 extends ConfigWrapperHutkigrosh
{

    public $modx;

    /**
     * ConfigurationWrapperModxMinishop2 constructor.
     * @param $modx
     */
    public function __construct(&$modx)
    {
        parent::__construct();
        $this->modx = $modx;
        Logger::getLogger(get_class($this))->info("init");
    }

    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public function getShopName()
    {
        return $this->getOption(ConfigurationFieldsModx::SHOP_NAME, true);
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->getOption(ConfigurationFieldsModx::LOGIN, true);
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->getOption(ConfigurationFieldsModx::PASSWORD, true);
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->checkOn(ConfigurationFieldsModx::SANDBOX);
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->getOption(ConfigurationFieldsModx::ERIP_ID, true);
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->checkOn(ConfigurationFieldsModx::EMAIL_NOTIFICATION);
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return $this->checkOn(ConfigurationFieldsModx::SMS_NOTIFICATION);
    }

    /**
     * Итоговый текст, отображаемый клменту после успешного выставления счета
     * Чаще всего содержит подробную инструкцию по оплате счета в ЕРИП
     * @return string
     */
    public function getCompletionText()
    {
        // TODO: Implement getCompletionText() method.
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->getOption(ConfigurationFieldsModx::BILL_STATUS_PENDING, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->getOption(ConfigurationFieldsModx::BILL_STATUS_PAYED, true);
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->getOption(ConfigurationFieldsModx::BILL_STATUS_FAILED, true);
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->getOption(ConfigurationFieldsModx::BILL_STATUS_CANCELED, true);
    }

    public function getSuccessResourceId()
    {
        return $this->getOption(ConfigurationFieldsModx::SUCCESS_RESOURCE_ID,true);
    }

    public function getFailedResourceId()
    {
        return $this->getOption(ConfigurationFieldsModx::FAILED_RESOURCE_ID, true);
    }

    protected function checkOn($key, $warn = false)
    {
        $value = $this->modx->getOption('ms2_msp' . $key, null, '0');
        return $value == '1' || $value == "true";
    }

    /**
     * Необходимо ли добавлять QR-код
     * @return boolean
     */
    public function isQRCodeEnabled()
    {
        return $this->checkOn(ConfigurationFieldsModx::QR_CODE);
    }

    /**
     * Необходимо ли добавлять кнопку "выставить в Alfaclick"
     * @return boolean
     */
    public function isAlfaclickButtonEnabled()
    {
        return $this->checkOn(ConfigurationFieldsModx::ALFACLICK_BUTTON);
    }

    /**
     * Необходимо ли добавлять кнопку "оплатить картой"
     * @return boolean
     */
    public function isWebpayButtonEnabled()
    {
        return $this->checkOn(ConfigurationFieldsModx::WEBPAY_BUTTON);
    }

    /**
     * Название системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodName()
    {
        // TODO: не используется
    }

    /**
     * Описание системы ХуткиГрош, отображаемое клиенту на этапе оформления заказа
     * @return string
     */
    public function getPaymentMethodDetails()
    {
        // TODO: не используется
    }

    /***
     * В некоторых CMS не получается в настройках хранить html, поэтому использует текст итогового экрана по умолчанию,
     * в который проставлятся значение ERIPPATh
     * @return string
     */
    public function getEripPath()
    {
        return $this->getOption( ConfigurationFieldsModx::ERIP_PATH, true );
    }

    /**
     * Какой срок действия счета после его выставления (в днях)
     * @return string
     */
    public function getDueInterval()
    {
        return $this->getOption(ConfigurationFieldsModx::DUE_INTERVAL, true);
    }

    public function createCmsRelatedKey($key) {
        return $key;
    }

    public function isUseOrderNumber(){
        return true;
    }

    public function getOption($key, $warn = false)
    {
        Logger::getLogger(get_class($this))->info("getOption ". 'ms2_msp' . $key);

        $value = $this->modx->getOption('ms2_msp' . $key, null, '');
        if ($warn)
            return $this->warnIfEmpty($value, $key);
        else
            return $value;
    }
}