<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
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
	/** @var string */
    const MODULE_NAME = 'molkobain-datacenter-view';
    /** @var string */
    const SETTING_CONST_FQCN = 'Molkobain\\iTop\\Extension\\DatacenterView\\Common\\Helper\\ConfigHelper';

    // Note: Mind to update defaults values in the module file when changing those default values.
	/** @var bool Default debug value */
    const DEFAULT_SETTING_DEBUG = false;
	/**
	 * @var bool Default value, tooltips will not be displayed if summary card available (iTop 3.1+)
	 * @since v1.13.0
	 */
	const DEFAULT_SETTING_FORCE_DEVICE_TOOLTIP_EVEN_WITH_SUMMARY_CARD = false;
    /** @var array|null Default attributes to be displayed in the device tooltip */
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
	 * Returns an array of classes that can host devices (eg. rack or enclosure).
	 *
	 * @return array
	 * @since v1.5.2
	 */
	public static function GetHostClasses()
	{
		return array('Rack', 'Enclosure');
	}

	/**
	 * Returns an array of classes that can be displayed in an host (both standards and customs)
	 *
	 * @return array
	 * @since v1.5.2
	 */
	public static function GetAllDeviceClasses()
	{
		return array_merge(
			static::GetStandardDeviceClasses(),
			static::GetOtherDeviceClasses()
		);
	}

	/**
	 * Returns an array of standard classes that can be displayed in an host (eg. rack or enclosure).
	 *
	 * @return array
	 * @since v1.5.2
	 */
	public static function GetStandardDeviceClasses()
	{
		return array('DatacenterDevice');
	}

	/**
	 * Returns an array of custom classes that can be displayed in an host.
	 *
	 * @return array
	 * @since v1.3.2
	 */
	public static function GetOtherDeviceClasses()
	{
		return array('PDU');
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

        $aAllowedClasses = static::GetHostClasses();
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
}
