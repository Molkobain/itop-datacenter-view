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
	 * @var string Suffix of the rack unit, appended to values
	 * @since v1.10.2
	 */
	const RACK_UNIT_SUFFIX = 'U';
	/**
	 * @var string Label of an empty value
	 * @since v1.10.2
	 */
	const EMPTY_VALUE_LABEL = '-';

	/**
	 * @inheritdoc
	 */
	public function GetValueLabel($sValue)
	{
		$sValueLabel = parent::GetValueLabel($sValue);
		if(($sValueLabel !== null) && ($sValueLabel !== ''))
		{
			$sValueLabel .= static::RACK_UNIT_SUFFIX;
		}
		else
		{
			$sValueLabel = static::EMPTY_VALUE_LABEL;
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
			$sHTMLValue .= static::RACK_UNIT_SUFFIX;
		}
		else
		{
			$sHTMLValue = static::EMPTY_VALUE_LABEL;
		}

		return $sHTMLValue;
	}
}