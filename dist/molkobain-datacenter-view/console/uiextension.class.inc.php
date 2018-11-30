<?php
/**
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Molkobain\iTop\DatacenterView\Console\Extension;

use DBObjectSet;
use Dict;
use iApplicationUIExtension;
use Molkobain\iTop\DatacenterView\Common\Helper\DataHelper;
use utils;
use WebPage;
use Molkobain\iTop\DatacenterView\Common\Helper\ConfigHelper;

/**
 * Class UIExtension
 *
 * @package Molkobain\iTop\Console\DatacenterView\Extension
 */
class UIExtension implements iApplicationUIExtension
{
	/**
	 * @inheritdoc
	 */
	public function OnDisplayProperties($oObject, WebPage $oPage, $bEditMode = false)
	{
		// Do nothing
	}

	/**
	 * @inheritdoc
	 * @throws \DictExceptionMissingString
	 */
	public function OnDisplayRelations($oObject, WebPage $oPage, $bEditMode = false)
	{
		// Check if enabled && class allowed
		if(!ConfigHelper::IsEnabled() || !ConfigHelper::IsAllowedClass(get_class($oObject)))
		{
			return;
		}

		// Retrieve data
		$sJSWidgetName = 'datacenter_' . DataHelper::GetObjectType($oObject) . '_view';
		$sJSWidgetDataJSON = DataHelper::GetWidgetData($oObject, true);

		// Add JS files
		$sJSRootUrl = utils::GetAbsoluteUrlModulesRoot() . ConfigHelper::GetModuleCode() . '/common/js/';
		$oPage->add_linked_script($sJSRootUrl . 'datacenter-view.js');
		$oPage->add_linked_script($sJSRootUrl . 'datacenter-rack-view.js');

		// Add CSS files
		$oPage->add_saas('env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/common/css/datacenter-view.scss');

		// Add markup
		$sPreviousTab = $oPage->GetCurrentTab();
		$oPage->SetCurrentTab(Dict::S('Molkobain:DatacenterView:Tabs:View:Title'));

		$oPage->add(
<<<EOF
	<div class="molkobain-datacenter-view-container" data-portal="backoffice">
		<div class="mdv-legend">
		</div>
	
		<div class="mdv-views">
		</div>
		
		<div class="mdv-unmounted">
		</div>
		
		<div class="mdv-templates">
			<!-- Rack panel template -->
			<div class="mdv-rack-panel" data-class="" data-id="" data-code="" data-name="">
				<div class="mdv-rp-title"></div>
				<div class="mdv-rp-view">
					<div class="mdv-rpv-top"></div>
					<div class="mdv-rpv-middle"></div>
					<div class="mdv-rpv-bottom"></div>
				</div>
			</div>
			
			<!-- Rack unit template -->
			<div class="mdv-rack-unit" data-unit-number="">
				<div class="mdv-ru-left"></div>
				<div class="mdv-ru-slot"></div>
				<div class="mdv-ru-right"></div>
			</div>
			
			<!-- Enclosure template -->
			<div class="mdv-enclosure" data-class="" data-id="" data-name="" data-rack-id="" data-position-v="">
			</div>
			
			<!-- Enclosure unit template -->
			<div class="mdv-enclosure-unit" data-unit-number="">
				<div class="mdv-eu-slot"></div>
			</div>
			
			<!-- Device template -->
			<div class="mdv-device" data-class="" data-id="" data-name="" data-rack-id="" data-enclosure-id="" data-position-v="">
				<span class="mdv-d-name"></span>
			</div>
			
			<div class="mdv-unmounted-type" data-type="">
				<div class="mdv-ut-header">
					<span class="mdv-ut-icon"></span>
					<span class="mdv-ut-name"></span>
				</div>
				<div class="mdv-ut-content">
				</div>
			</div>
		</div>
	</div>
EOF
		);

		// Init JS widget
		$oPage->add_ready_script(
			<<<EOF
	// Molkobain datacenter view
    // - Initializing widget
    $.molkobain.{$sJSWidgetName}(
        $sJSWidgetDataJSON,
        $('.molkobain-datacenter-view-container')
    );
EOF
		);

		// Put tab cursor back to previous to make sure nothing breaks our tab (other extension for example)
		$oPage->SetCurrentTab($sPreviousTab);

		return;
	}

	/**
	 * @inheritdoc
	 */
	public function OnFormSubmit($oObject, $sFormPrefix = '')
	{
		// Do nothing
	}

	/**
	 * @inheritdoc
	 */
	public function OnFormCancel($sTempId)
	{
		// Do nothing
	}

	/**
	 * @inheritdoc
	 */
	public function EnumUsedAttributes($oObject)
	{
		return array();
	}

	/**
	 * @inheritdoc
	 */
	public function GetIcon($oObject)
	{
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function GetHilightClass($oObject)
	{
		// Possible return values are:
		// HILIGHT_CLASS_CRITICAL, HILIGHT_CLASS_WARNING, HILIGHT_CLASS_OK, HILIGHT_CLASS_NONE
		return HILIGHT_CLASS_NONE;
	}

	/**
	 * @inheritdoc
	 */
	public function EnumAllowedActions(DBObjectSet $oSet)
	{
		// No action
		return array();
	}
}
