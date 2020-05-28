<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

/**
 * Class AttributeRackUnit
 */
class AttributeMHFRackUnit extends AttributeInteger
{
	/**
	 * @inheritdoc
	 */
	public function GetValueLabel($sValue)
	{
		$sValueLabel = parent::GetValueLabel($sValue);
		if(($sValueLabel !== null) && ($sValueLabel !== ''))
		{
			$sValueLabel .= 'U';
		}
		else
		{
			$sValueLabel = '-';
		}

		return $sValueLabel;
	}

	/**
	 * @inheritdoc
	 */
	public function GetAsHTML($sValue, $oHostObject = null, $bLocalize = true)
	{
		$sHTMLValue = parent::GetAsHTML($sValue, $oHostObject, $bLocalize);
		if(($sHTMLValue !== null) && ($sHTMLValue !== ''))
		{
			$sHTMLValue .= 'U';
		}
		else
		{
			$sHTMLValue = '-';
		}

		return $sHTMLValue;
	}
}