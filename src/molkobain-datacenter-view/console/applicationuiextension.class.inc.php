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
use iApplicationUIExtension;
use utils;
use WebPage;
use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterView;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/**
 * Class ApplicationUIExtension
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Console\Extension
 */
class ApplicationUIExtension implements iApplicationUIExtension
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
		$sJSWidgetFilename = 'datacenter-' . strtolower(DatacenterView::GetObjectType($oObject)) . '-view.js';
		$sJSWidgetName = 'datacenter_' . DatacenterView::GetObjectType($oObject) . '_view';
		$sJSWidgetDataJSON = DatacenterView::GetWidgetData($oObject, true);

		// Add JS files
		$sJSRootUrl = utils::GetAbsoluteUrlModulesRoot() . ConfigHelper::GetModuleCode() . '/common/js/';
		$oPage->add_linked_script($sJSRootUrl . 'datacenter-view.js');
		$oPage->add_linked_script($sJSRootUrl . $sJSWidgetFilename);

		// Add CSS files
		$oPage->add_saas('env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/common/css/datacenter-view.scss');

		// Add markup
		$sPreviousTab = $oPage->GetCurrentTab();
		$oPage->SetCurrentTab(Dict::S('Molkobain:DatacenterView:Tabs:View:Title'));

		$sLegendTitle = Dict::S('Molkobain:DatacenterView:Legend:Title');

		$oPage->add(
<<<EOF
	<div class="molkobain-datacenter-view-container" data-portal="backoffice">
		<div class="mdv-legend mhf-panel">
			<div class="mhf-p-header">
				<span class="mhf-ph-icon"><span class="fa fa-list"></span></span>
				<span class="mhf-ph-title">{$sLegendTitle}</span>
			</div>
			<div class="mhf-p-body">
				<ul>
				</ul>
			</div>
		</div>
	
		<div class="mdv-views">
		</div>
		
		<div class="mdv-unmounted mhf-panel">
		</div>
		
		<div class="mhf-templates">
			<!-- Legend item template -->
			<li class="mdv-legend-item" data-class="" data-count=""></li>
			
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
			<div class="mdv-enclosure" data-class="" data-id="" data-name="" data-rack-id="" data-position-v="" data-position-p="">
			</div>
			
			<!-- Enclosure unit template -->
			<div class="mdv-enclosure-unit" data-unit-number="">
				<div class="mdv-eu-left"></div>
				<div class="mdv-eu-slot"></div>
				<div class="mdv-eu-right"></div>
			</div>
			
			<!-- Device template -->
			<div class="mdv-device" data-class="" data-id="" data-name="" data-rack-id="" data-enclosure-id="" data-position-v="" data-position-p="">
				<span class="mdv-d-name"></span>
			</div>
			
			<!-- Unmounted type template (enclosures / devices) -->
			<div class="mdv-unmounted-type mhf-panel" data-type="">
				<div class="mhf-p-header">
					<span class="mhf-ph-icon"></span>
					<span class="mhf-ph-title"></span>
				</div>
				<div class="mhf-p-body">
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
