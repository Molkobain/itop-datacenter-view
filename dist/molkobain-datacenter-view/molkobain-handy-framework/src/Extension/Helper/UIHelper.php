<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Helper;

use Molkobain\iTop\Extension\HandyFramework\UI\ToggleButton;

/**
 * Class UIHelper
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Helper
 * @since 1.1.0
 */
class UIHelper
{
	/**
	 * Returns a ToggleButton ready to be rendered
	 *
	 * @param string $sInputName "name" attribute of the HTML input
	 * @param bool $bOn Default state of the toggle
	 * @param string|null $sInputId "id" attribute of the HTML input, if null one will be generated
	 * @param string|null $sJSOnChangeCallback Javascript callback to execute on change
	 * @param bool $bEnabled Set to false to disabled button from being used
	 * @param string|null $sOnLabel Label to display when toggle is "On", display depends on the theme
	 * @param string|null $sOffLabel Label to display when toggle is "Off", display depends on the theme
	 *
	 * @return \Molkobain\iTop\Extension\HandyFramework\UI\ToggleButton
	 */
	public static function MakeToggleButton($sInputName, $bOn = true, $sInputId = null, $sJSOnChangeCallback = null, $bEnabled = true, $sOnLabel = null, $sOffLabel = null)
	{
		$oButton = new ToggleButton($sInputName, $bOn, $sInputId);
		$oButton->SetJSOnChangeCallback($sJSOnChangeCallback)
			->SetEnabled($bEnabled)
			->SetOnLabel($sOnLabel)
	        ->SetOffLabel($sOffLabel);

		return $oButton;
	}
}
