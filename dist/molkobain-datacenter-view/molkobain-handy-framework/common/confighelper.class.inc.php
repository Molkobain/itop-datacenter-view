<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Common\Helper;

use Exception;
use MetaModel;
use utils;

/**
 * Class ConfigHelper
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Common\Helper
 */
class ConfigHelper
{
    const MODULE_NAME = 'molkobain-handy-framework';
    const SETTING_CONST_FQCN = 'Molkobain\\iTop\\Extension\\HandyFramework\\Common\\Helper\\ConfigHelper';

    const DEFAULT_SETTING_ENABLED = true;

    /**
     * @return string
     */
    public static function GetModuleCode()
    {
        return static::MODULE_NAME;
    }

	/**
	 * @return string
	 */
    public static function GetModuleVersion()
    {
    	return utils::GetCompiledModuleVersion(static::GetModuleCode());
    }

	/**
	 * @return string
	 */
    public static function GetAbsoluteModuleUrl()
    {
    	return utils::GetAbsoluteUrlModulesRoot() . '/' . static::GetModuleCode() . '/';
    }

	/**
	 * @return string
	 */
    public static function GetAbsoluteModulePath()
    {
    	return APPROOT . '/env-' . utils::GetCurrentEnvironment() . '/' . static::GetModuleCode() . '/';
    }

    /**
     * Returns the value of the $sName module setting or its default value if not set in the conf file.
     *
     * @param string $sName Name of the module setting to get
     * @return mixed
     */
    public static function GetSetting($sName)
    {
        try
        {
            $defaultValue = constant(static::SETTING_CONST_FQCN.'::DEFAULT_SETTING_'.strtoupper($sName));
        }
        catch(Exception $e)
        {
            $defaultValue = null;
        }

        return MetaModel::GetModuleSetting(static::MODULE_NAME, $sName, $defaultValue);
    }

    /**
     * Returns true if the module is enabled
     *
     * @return boolean
     */
    public static function IsEnabled()
    {
        return static::GetSetting('enabled');
    }
}
