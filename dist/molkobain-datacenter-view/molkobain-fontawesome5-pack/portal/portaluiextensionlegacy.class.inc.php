<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\FontAwesome5\Portal\Extension;

use AbstractPortalUIExtension;
use MetaModel;
use Silex\Application;
use utils;

// Protection, only for iTop 2.4-2.6
if(version_compare(ITOP_VERSION, '2.3', '>') && version_compare(ITOP_VERSION, '2.7', '<') && (ITOP_VERSION !== 'develop'))
{
	/**
	 * Class PortalUIExtensionLegacy
	 *
	 * @package Molkobain\iTop\Extension\FontAwesome5\Portal\Extension
	 * @since v1.2.0
	 */
	class PortalUIExtensionLegacy extends AbstractPortalUIExtension
	{
		/**
		 * @inheritdoc
		 * @throws \Exception
		 */
		public function GetCSSFiles(Application $oApp)
		{
			$aReturn = array();

			if (MetaModel::GetConfig()->GetModuleSetting('molkobain-fontawesome5-pack', 'enabled', true) === false) {
				return $aReturn;
			}

			$aReturn[] = utils::GetAbsoluteUrlModulesRoot() . 'molkobain-fontawesome5-pack/fontawesome-free-5.15.3-web/css/all.min.css?v=' . utils::GetCompiledModuleVersion('molkobain-fontawesome5-pack');

			return $aReturn;
		}
	}
}
