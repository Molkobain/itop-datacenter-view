<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Helper;

/**
 * Class StringHelper
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Helper
 * @since 1.3.0
 */
class StringHelper
{
	/**
	 * Transform a snake_case $sInput into a CamelCase string
	 *
	 * @param string $sInput
	 *
	 * @return string
	 */
    public static function ToCamelCase($sInput)
    {
        return str_replace(' ', '', ucwords(strtr($sInput, '_-', '  ')));
    }
}
