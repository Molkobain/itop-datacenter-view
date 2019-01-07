<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\HandyFramework\Console\Extension;

use iPageUIExtension;
use iTopWebPage;
use utils;
use Molkobain\iTop\Extension\HandyFramework\Common\Helper\ConfigHelper;

/**
 * Class PageUIExtension
 *
 * @package Molkobain\iTop\Extension\HandyFramework\Console\Extension
 */
class PageUIExtension implements iPageUIExtension
{
    /**
	 * @inheritdoc
	 */
	public function GetNorthPaneHtml(iTopWebPage $oPage)
	{
		// Check if enabled
		if(ConfigHelper::IsEnabled() === false)
		{
			return;
		}

		$oPage->add_saas('env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/common/css/handy-framework.scss');
		$oPage->add_linked_script(ConfigHelper::GetAbsoluteModuleUrl() . 'common/js/handy-framework.js');
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
}}
