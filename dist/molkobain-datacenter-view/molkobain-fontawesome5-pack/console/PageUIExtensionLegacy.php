<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\FontAwesome5\Console\Extension;

use MetaModel;
use utils;
use iTopWebPage;
use iPageUIExtension;

// Protection, only for iTop 2.4-2.7
if(version_compare(ITOP_VERSION, '2.3', '>') && version_compare(ITOP_VERSION, '3.0', '<') && (ITOP_VERSION !== 'develop')) {
	/**
	 * Class ConsoleUIExtension
	 *
	 * @package Molkobain\iTop\Extension\FontAwesome5\Console\Extension
	 */
	class PageUIExtensionLegacy implements iPageUIExtension
	{
		/**
		 * @inheritdoc
		 */
		public function GetNorthPaneHtml(iTopWebPage $oPage)
		{
			if (MetaModel::GetConfig()->GetModuleSetting('molkobain-fontawesome5-pack', 'enabled', true) === false) {
				return;
			}

			$sModuleVersion = utils::GetCompiledModuleVersion('molkobain-fontawesome5-pack');
			$oPage->add_linked_stylesheet(utils::GetAbsoluteUrlModulesRoot() . 'molkobain-fontawesome5-pack/fontawesome-free-5.15.3-web/css/all.min.css?v=' . $sModuleVersion);
		}

		/**
		 * @inheritdoc
		 */
		public function GetSouthPaneHtml(iTopWebPage $oPage)
		{
			// Do nothing.
		}

		/**
		 * @inheritdoc
		 */
		public function GetBannerHtml(iTopWebPage $oPage)
		{
			// Do nothing.
		}
	}
}
