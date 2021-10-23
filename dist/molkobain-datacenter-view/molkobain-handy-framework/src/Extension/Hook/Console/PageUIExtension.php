<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Hook\Console;

use iPageUIExtension;
use iTopWebPage;
use utils;
use Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper;

/**
 * Class PageUIExtension
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Console\Extension
 */
class PageUIExtension implements iPageUIExtension
{
	/**
	 * @inheritdoc
	 * @throws \Exception
	 */
	public function GetNorthPaneHtml(iTopWebPage $oPage)
	{
		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return;
		}

		// Module CSS path
		if (ConfigHelper::IsRunningiTop30OrNewer()) {
			$sModuleCssBaseRelPath = 'env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/asset/css/';
		} else {
			$sModuleCssBaseRelPath = 'env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/legacy/asset/css/';
		}

		// Portal CSS path (for compilation of the global stylesheet)
		if (ConfigHelper::IsRunningiTop27OrNewer()) {
			$sPortalCssBaseRelPath = 'datamodels/2.x/itop-portal-base/portal/public/css/';
		} else {
			$sPortalCssBaseRelPath = 'datamodels/2.x/itop-portal-base/portal/web/css/';
		}

		$aScssImportPaths = array(APPROOT.$sModuleCssBaseRelPath, APPROOT.$sPortalCssBaseRelPath);
		$oPage->add_linked_stylesheet(utils::GetAbsoluteUrlAppRoot().utils::GetCSSFromSASS($sModuleCssBaseRelPath.'handy-framework.scss', $aScssImportPaths));
		$oPage->add_linked_script(ConfigHelper::GetAbsoluteModuleUrl() . 'asset/js/handy-framework.js');
	}

	/**
	 * @inheritdoc
	 */
	public function GetSouthPaneHtml(iTopWebPage $oPage)
	{
		// Nothing to do
	}

	/**
	 * @inheritdoc
	 */
	public function GetBannerHtml(iTopWebPage $oPage)
	{
		// Nothing to do
	}
}
