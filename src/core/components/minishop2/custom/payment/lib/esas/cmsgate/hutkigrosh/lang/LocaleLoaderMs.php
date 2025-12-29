<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 13:09
 */

namespace esas\cmsgate\hutkigrosh\lang;

use esas\cmsgate\lang\LocaleLoaderCms;

class LocaleLoaderMs extends LocaleLoaderCms
{


    /**
     * LocaleLoaderMs constructor.
     */
    public function __construct()
    {
        $this->addExtraVocabularyDir(dirname(__FILE__));
    }

    public function getLocale()
    {
        return parent::getLocale();
    }

}