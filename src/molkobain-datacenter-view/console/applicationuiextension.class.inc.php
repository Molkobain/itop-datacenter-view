<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
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
use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory;
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
	 * @throws \Exception
	 */
	public function OnDisplayRelations($oObject, WebPage $oPage, $bEditMode = false)
	{
		// Check if enabled && class allowed
		if(!ConfigHelper::IsEnabled() || !ConfigHelper::IsAllowedClass(get_class($oObject)))
		{
			return;
		}

		// Don't display graphical view is element still being created
		if ($oObject->IsNew()) {
			return;
		}

		// Retrieve DatacenterView
		$oDatacenterView = DatacenterViewFactory::BuildFromObject($oObject);
		$oDatacenterView->SetObjectInEditMode($bEditMode);

		// Add external files now as it might make some glitches if loaded after async call
		// - JS files
		$sJSRootUrl = utils::GetAbsoluteUrlModulesRoot() . ConfigHelper::GetModuleCode() . '/common/js/';
		$sJSWidgetFilename = 'datacenter-' . strtolower($oDatacenterView->GetType()) . '-view.js';

		$oPage->add_linked_script($sJSRootUrl . 'datacenter-view.js' . '?v=' . ConfigHelper::GetModuleVersion());
		$oPage->add_linked_script($sJSRootUrl . $sJSWidgetFilename . '?v=' . ConfigHelper::GetModuleVersion());

		// - CSS files
		$sModuleCssBaseRelPath = 'env-' . utils::GetCurrentEnvironment() . '/' . ConfigHelper::GetModuleCode() . '/common/css/';
		// Portal CSS path (for compilation of the global stylesheet)
		if (ConfigHelper::IsRunningiTop27OrNewer()) {
			$sPortalCssBaseRelPath = 'datamodels/2.x/itop-portal-base/portal/public/css/';
		} else {
			$sPortalCssBaseRelPath = 'datamodels/2.x/itop-portal-base/portal/web/css/';
		}
		$aScssImportPaths = [
			APPROOT.$sPortalCssBaseRelPath,
			MODULESROOT, // For imports of modules files
		];
		$oPage->add_linked_stylesheet(utils::GetAbsoluteUrlAppRoot().utils::GetCSSFromSASS($sModuleCssBaseRelPath.'datacenter-view.scss', $aScssImportPaths));

		// Add content in an async tab
		$sPreviousTab = $oPage->GetCurrentTab();
		$oPage->AddAjaxTab(
			Dict::S('Molkobain:DatacenterView:Tabs:View:Title'),
			$oDatacenterView->GetEndpoint(array(
				'operation' => $oDatacenterView::ENUM_ENDPOINT_OPERATION_RENDERTAB,
				'edit_mode' => $bEditMode,
			))
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
