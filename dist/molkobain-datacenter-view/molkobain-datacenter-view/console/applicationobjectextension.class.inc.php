<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Console\Extension;

use DBObjectSet;
use Dict;
use iApplicationObjectExtension;
use utils;
use WebPage;
use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterView;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/**
 * Class ApplicationObjectExtension
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Console\Extension
 */
class ApplicationObjectExtension implements iApplicationObjectExtension
{
	/**
	 * @inheritdoc
	 */
	public function OnIsModified($oObject)
	{
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function OnCheckToWrite($oObject)
	{
		$aErrors = array();

		// Check if enabled && class allowed
		if(!ConfigHelper::IsEnabled() || !ConfigHelper::IsAllowedClass(get_class($oObject)))
		{
			return $aErrors;
		}

		// Consistency checks
		if(ConfigHelper::GetSetting('enable_consistency_checks') === true)
		{
			DatacenterView::CheckObjectConsistency($oObject, $aErrors);
		}

		return $aErrors;
	}

	/**
	 * @inheritdoc
	 */
	public function OnCheckToDelete($oObject)
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function OnDBUpdate($oObject, $oChange = null)
	{
		return;
	}

	/**
	 * @inheritdoc
	 */
	public function OnDBInsert($oObject, $oChange = null)
	{
		return;
	}

	/**
	 * @inheritdoc
	 */
	public function OnDBDelete($oObject, $oChange = null)
	{
		return void;
	}
}
