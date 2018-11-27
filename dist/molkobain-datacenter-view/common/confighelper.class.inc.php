<?php
/**
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Molkobain\iTop\DatacenterView\Common\Helper;

use Exception;
use MetaModel;

/**
 * Class ConfigHelper
 *
 * @package Molkobain\iTop\DatacenterView\Common\Helper
 */
class ConfigHelper
{
    const MODULE_NAME = 'molkobain-datacenter-view';
    const SETTING_CONST_FQCN = 'Molkobain\\iTop\\DatacenterView\\Common\\Helper\\ConfigHelper';

    const DEFAULT_SETTING_ENABLED = true;
    const DEFAULT_SETTING_DEBUG = true;
    const DEFAULT_SETTING_DEVICE_TOOLTIP_ATTRIBUTES = null;

    /**
     * @return string
     */
    public static function GetModuleCode()
    {
        return static::MODULE_NAME;
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

	/**
	 * Returns true if the debug option is enabled
	 *
	 * @return boolean
	 */
    public static function IsDebugEnabled()
    {
    	return static::GetSetting('debug');
    }

    /**
     * @param string $sClass
     *
     * @return bool
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
}
