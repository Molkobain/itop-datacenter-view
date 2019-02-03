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
	 * @param string $sInputName "name" attribute of the HTML input
	 * @param bool $bOn Default state of the toggle
	 * @param string|null $sInputId "id" attribute of the HTML input, if null one will be generated
	 * @param string|null $sJSOnChangeCallback Javascript callback to execute on change
	 * @param string|null $sOnLabel Label to display when toggle is "On", display depends on the theme
	 * @param string|null $sOffLabel Label to display when toggle is "Off", display depends on the theme
	 *
	 * @return string
	 */
	public static function MakeToggleButton($sInputName, $bOn = true, $sInputId = null, $sJSOnChangeCallback = null, $sOnLabel = null, $sOffLabel = null)
	{
		// Prepare parameters
		// - Make unique ID for input if necessary
		$sInputId = (empty($sInputId)) ? 'mhf-tb-' . time() . '-' . static::GetNextId() : $sInputId;
		// - Convert default value
		$sInputChecked = (((bool) $bOn) === true) ? 'checked' : '';
		// - Optional labels, depend on the theme
		$sOffTagAtt = (!empty($sOffLabel)) ? 'data-off-label="' . $sOffLabel . '"' : '';
		$sOnTagAtt = (!empty($sOnLabel)) ? 'data-on-label="' . $sOnLabel . '"' : '';
		// - Optional JS callback
		// Note: escaping html chars to avoid breaking the quotes around the attribute's value
		$sOnChangeAtt = (!empty($sJSOnChangeCallback)) ? 'onchange="javascript: ' . htmlspecialchars($sJSOnChangeCallback) . '"' : '';

		$sHtml =
			<<<EOF
<span class="mhf-toggle-button">
	<input class="mhf-tb-input mhf-tb-flat" id="{$sInputId}" name="{$sInputName}" type="checkbox" {$sOnChangeAtt} {$sInputChecked} />
	<label class="mhf-tb-button" {$sOffTagAtt} {$sOnTagAtt} for="{$sInputId}">
</span>
EOF;

		return $sHtml;
	}

	protected static function GetNextId()
	{
		return ++static::$iIdCounter;
	}
}
