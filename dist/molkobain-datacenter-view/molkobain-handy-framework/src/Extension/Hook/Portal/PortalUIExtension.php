<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Hook\Portal;

use AbstractPortalUIExtension;
use Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class PortalUIExtension
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Portal\Extension
 * @since v1.3.0
 */
class PortalUIExtension extends AbstractPortalUIExtension
{
	/**
	 * @inheritdoc
	 * @throws \Exception
	 */
	public function GetCSSFiles(Container $oContainer)
	{
		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return array();
		}

		$sModuleVersion = ConfigHelper::GetModuleVersion();
		$sURLBase = ConfigHelper::GetAbsoluteModuleUrl();

		// Note: Here we pass the compiled .css file in order to be compatible with iTop 2.5 and earlier (ApplicationHelper::LoadUIExtensions() refactoring that uses utils::GetCSSFromSASS())
		$aReturn = array();
		if (ConfigHelper::IsRunningiTop30OrNewer()) {
			$aReturn[] = $sURLBase . 'asset/css/handy-framework.css?v=' . $sModuleVersion;
		} else {
			$aReturn[] = $sURLBase . 'legacy/asset/css/handy-framework.css?v=' . $sModuleVersion;
		}

		return $aReturn;
	}

	/**
	 * @inheritdoc
	 * @throws \Exception
	 */
	public function GetJSFiles(Container $oContainer)
	{
		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return array();
		}

		$sModuleVersion = ConfigHelper::GetModuleVersion();
		$sURLBase = ConfigHelper::GetAbsoluteModuleUrl();

		$aJSFiles = array(
			$sURLBase . 'asset/js/handy-framework.js?v=' . $sModuleVersion,
		);

		return $aJSFiles;
	}
}
