<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Common\Helper;

/**
 * Class UHelper
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Common\Helper
 * @since 1.1.0
 */
class UIHelper
{
	protected static $iIdCounter = 0;

    /**
     * Returns HTML markup for a toggle button based on a checkbox
     *
     * @todo Parameters for default value, id, labels, extra CSS classes
     *
     * @return string
     */
    public static function MakeToggleButton($bOn = true)
    {
    	$sId = 'mhf-tb-' . time() . '-' . static::GetNextId();
    	$sOffLabel = '';
    	$sOnLabel = '';

    	$sOffTagAttribute = (!empty($sOffLabel)) ? 'data-off-label="'.$sOffLabel.'"' : '';
    	$sOnTagAttribute = (!empty($sOnLabel)) ? 'data-on-label="'.$sOnLabel.'"' : '';

    	$sHtml =
<<<EOF
<span class="mhf-toggle-button">
	<input class="mhf-tb-input mhf-tb-flat" id="{$sId}" type="checkbox"/>
	<label class="mhf-tb-button" {$sOffTagAttribute} {$sOnTagAttribute} for="{$sId}">
</span>
EOF;

        return $sHtml;
    }

    protected static function GetNextId()
    {
    	return ++static::$iIdCounter;
    }
}
