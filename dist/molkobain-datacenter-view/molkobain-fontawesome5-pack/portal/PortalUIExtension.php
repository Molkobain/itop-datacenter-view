<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\FontAwesome5\Portal\Extension;

use utils;
use AbstractPortalUIExtension;
use MetaModel;
use Symfony\Component\DependencyInjection\Container;

// Protection, for iTop 2.7-3.0 only (As of iTop 3.0 FontAwesome is acutally already updated to v5.12, but we decide to obselete this extension from iTop 3.1+)
if(!class_exists('Molkobain\\iTop\\Extension\\FontAwesome5\\Portal\\Extension\\PortalUIExtensionLegacy') && version_compare(ITOP_VERSION, '3.1', '<'))
{
	/**
	 * Class PortalUIExtension
	 *
	 * @package Molkobain\iTop\Extension\FontAwesome5\Portal\Extension
	 * @since v1.2.0
	 */
	class PortalUIExtension extends AbstractPortalUIExtension
	{
		/**
		 * @inheritdoc
		 * @throws \Exception
		 */
		public function GetCSSFiles(Container $oContainer)
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
