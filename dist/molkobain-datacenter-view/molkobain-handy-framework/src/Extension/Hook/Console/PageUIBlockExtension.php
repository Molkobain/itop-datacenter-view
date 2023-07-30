<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Hook\Console;

use iBackofficeLinkedScriptsExtension;
use iBackofficeLinkedStylesheetsExtension;
use iTopWebPage;
use utils;
use Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper;


// Protection for iTop 2.7 and older
if(version_compare(ITOP_VERSION, '3.0', '>=')) {
	/**
	 * Class PageUIBlockExtension
	 *
	 * @package Molkobain\iTop\Extension\HandyFramework\Console\Extension
	 * @since 1.10.0
	 */
	class PageUIBlockExtension implements iBackofficeLinkedScriptsExtension, iBackofficeLinkedStylesheetsExtension
	{
		/*
		 * inheritdoc
		 */
		public function GetLinkedScriptsAbsUrls() : array
		{
			$aUrls = [];

			// Check if enabled
			if (ConfigHelper::IsEnabled() === false) {
				return $aUrls;
			}

			$aUrls[] = ConfigHelper::GetAbsoluteModuleUrl() . 'asset/js/handy-framework.js';

			return $aUrls;
		}

		/**
		 * @inheritdoc
		 */
		public function GetLinkedStylesheetsAbsUrls() : array
		{
			$aUrls = [];

			// Check if enabled
			if (ConfigHelper::IsEnabled() === false) {
				return $aUrls;
			}

			// Module CSS path
			$sModuleCssBaseRelPath = 'env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/asset/css/';
			// Portal CSS path (for compilation of the global stylesheet)
			$sPortalCssBaseRelPath = 'datamodels/2.x/itop-portal-base/portal/public/css/';

			$aScssImportPaths = array(APPROOT . $sModuleCssBaseRelPath, APPROOT . $sPortalCssBaseRelPath);
			$aUrls[] = utils::GetAbsoluteUrlAppRoot() . utils::GetCSSFromSASS($sModuleCssBaseRelPath . 'handy-framework.scss', $aScssImportPaths);

			return $aUrls;
		}
	}
}
