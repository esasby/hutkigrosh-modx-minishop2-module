<?php
/** @var modX $modx */

if (!class_exists("esas\cmsgate\CmsPlugin"))
    require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/vendor/esas/cmsgate-core/src/esas/cmsgate/CmsPlugin.php');

global $modx;

use esas\cmsgate\CmsPlugin;
use esas\cmsgate\hutkigrosh\RegistryHutkigroshMs;

(new CmsPlugin(dirname(__FILE__, 5) . '/vendor', dirname(__FILE__)))
    ->setRegistry(new RegistryHutkigroshMs($modx))
    ->init();