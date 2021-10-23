<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\NewsroomProvider\Hook\Console;

use iPageUIExtension;
use iTopWebPage;
use Molkobain\iTop\Extension\NewsroomProvider\Helper\ConfigHelper;
use utils;

// Protection, only for iTop 2.4-2.7.
// - Since 3.0 the stylesheet is fixed and this API deprecated
// - We can't use ITOP_DESIGN_LATEST_VERSION as it is not loaded yet
if (version_compare(ITOP_VERSION, '3.0.0', '<')) {
	/**
	 * Class PageUIExtension
	 *
	 * @package Molkobain\iTop\Extension\NewsroomProvider\Hook\Console
	 */
	class PageUIExtension implements iPageUIExtension
	{
		/**
		 * @inheritDoc
		 * @throws \Exception
		 */
		public function GetNorthPaneHtml(iTopWebPage $oPage)
		{
			// Check if enabled
			if(!ConfigHelper::IsEnabled())
			{
				return;
			}

			// Add external files now as it might make some glitches if loaded after async call
			// - CSS files
			$oPage->add_saas('env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/asset/css/default.scss');
		}

		/**
		 * @inheritDoc
		 */
		public function GetSouthPaneHtml(iTopWebPage $oPage)
		{
			// Do nothing
		}

		/**
		 * @inheritDoc
		 */
		public function GetBannerHtml(iTopWebPage $oPage)
		{
			// Do nothing
		}
	}
}
