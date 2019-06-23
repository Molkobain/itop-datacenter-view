<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Common\Helper;

use Molkobain\iTop\Extension\HandyFramework\Common\Helper\ConfigHelper as BaseConfigHelper;

/**
 * Class ConfigHelper
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Common\Helper
 */
class ConfigHelper extends BaseConfigHelper
{
    const MODULE_NAME = 'molkobain-datacenter-view';
    const SETTING_CONST_FQCN = 'Molkobain\\iTop\\Extension\\DatacenterView\\Common\\Helper\\ConfigHelper';

    // Note: Mind to update defaults values in the module file when changing those default values.
    const DEFAULT_SETTING_DEBUG = false;
    const DEFAULT_SETTING_DEVICE_TOOLTIP_ATTRIBUTES = null;

    /**
	 * Returns true if the debug option is enabled
	 *
	 * @return boolean
     * @since v1.0.0
	 */
    public static function IsDebugEnabled()
    {
    	return static::GetSetting('debug');
    }

    /**
     * Returns true if $sClass is allowed for graphical view
     *
     * @param string $sClass
     *
     * @return bool
     * @since v1.0.0
     */
    public static function IsAllowedClass($sClass)
    {
        $bIsAllowedClass = false;

        $aAllowedClasses = array('Rack', 'Enclosure');
        foreach($aAllowedClasses as $sAllowedClass)
        {
            if(is_a($sClass, $sAllowedClass, true))
            {
                $bIsAllowedClass = true;
                break;
            }
        }

        return $bIsAllowedClass;
    }

	/**
	 * Returns an array of custom classes that can be displayed in a rack or enclosure
	 *
	 * @return array
	 * @since v1.3.2
	 */
    public static function GetOtherDeviceClasses()
    {
    	return array('PDU');
    }
}
