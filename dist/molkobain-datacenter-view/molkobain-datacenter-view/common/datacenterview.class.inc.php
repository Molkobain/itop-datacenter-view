<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Common;

use DBObject;
use DBObjectSearch;
use DBObjectSet;
use Dict;
use AttributeExternalKey;
use AttributeHTML;
use MetaModel;
use Rack;
use Enclosure;
use DatacenterDevice;
use utils;
use appUserPreferences;
use Combodo\iTop\Renderer\RenderingOutput;
use Molkobain\iTop\Extension\HandyFramework\Common\Helper\UIHelper;
use Molkobain\iTop\Extension\HandyFramework\Common\Helper\StringHelper;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/**
 * Class DatacenterView
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Common
 */
class DatacenterView
{
	const ENUM_PANEL_FRONT = 'front';

	const ENUM_ASSEMBLY_TYPE_MOUNTED = 'mounted';
	const ENUM_ASSEMBLY_TYPE_UNMOUNTED = 'unmounted';

	const ENUM_ELEMENT_TYPE_RACK = 'rack';
	const ENUM_ELEMENT_TYPE_ENCLOSURE = 'enclosure';
	const ENUM_ELEMENT_TYPE_DEVICE = 'device';

	const ENUM_ENDPOINT_OPERATION_RENDERTAB = 'render_tab';
	const ENUM_ENDPOINT_OPERATION_SUBMITOPTIONS = 'submit_options';

	const ENUM_OPTION_CODE_SHOWOBSOLETE = 'show_obsolete';

	const DEFAULT_PANEL = self::ENUM_PANEL_FRONT;
	const DEFAULT_NB_COLS = 1;
	const DEFAULT_OBJECT_IN_EDIT_MODE = false;

	/** @var array $aDeviceCategories Parameters (callbacks) for each category of devices */
	protected static $aDeviceCategories = array(
		'standard' => array(
			'enum_classes_callback_name' => 'GetStandardDeviceClasses',
		),
		'other' => array(
			'enum_classes_callback_name' => 'GetOtherDeviceClasses',
		),
	);

	/** @var string $sStaticConfigHelperClass */
	protected $sStaticConfigHelperClass;
	/** @var \DBObject $oObject */
	protected $oObject;
	/** @var string $sType */
	protected $sType;
	/** @var bool $bObjectInEditMode Is object in edition mode */
	protected $bObjectInEditMode;
	/** @var array $aOptions Current value of the options */
	protected $aOptions;

	public function __construct(DBObject $oObject)
	{
		$this->sStaticConfigHelperClass = static::GetStaticConfigHelperClass();
		$this->oObject = $oObject;
		$this->sType = static::FindObjectType($this->oObject);
		$this->bObjectInEditMode = static::DEFAULT_OBJECT_IN_EDIT_MODE;
		// Note: There is note static default value as array is not allowed before PHP 5.6
		$this->aOptions = array();
	}


	//--------------------
	// Getters / Setters
	//--------------------

	/**
	 * @return \DBObject
	 */
	public function GetObject()
	{
		return $this->oObject;
	}

	/**
	 * Returns the object's type (see ENUM_ELEMENT_TYPE_XXX constants)
	 *
	 * @return string
	 */
	public function GetType()
	{
		return $this->sType;
	}

	/**
	 * Returns true if the object is in edition mode
	 *
	 * @return bool
	 */
	public function IsObjectInEditMode()
	{
		return (bool) $this->bObjectInEditMode;
	}

	/**
	 * Sets if the object is in edition mode
	 *
	 * @param bool $bObjectInEditMode If not passed, set to true automatically
	 *
	 * @return $this
	 */
	public function SetObjectInEditMode($bObjectInEditMode = true)
	{
		$this->bObjectInEditMode = (bool) $bObjectInEditMode;
		return $this;
	}


	//----------
	// Helpers
	//----------

	/**
	 * Returns the endpoint url with optional $aParams.
	 * Note: that object's class & id are always passed as parameters.
	 *
	 * @param array $aParams Array of key => value to pass in the endpoint as parameters
	 *
	 * @return string
	 */
	public function GetEndpoint($aParams = array())
	{
		$aQueryStringParams = array(
			'class=' . $this->GetObjectClass(),
			'id=' . $this->GetObjectId(),
		);

		foreach($aParams as $sKey => $sValue)
		{
			$aQueryStringParams[] = $sKey . '=' . $sValue;
		}

		return utils::GetAbsoluteUrlModulesRoot() . ConfigHelper::GetModuleCode() . '/console/ajax.render.php?' . implode('&', $aQueryStringParams);
	}

	/**
	 * @return string
	 */
	public function GetObjectClass()
	{
		return get_class($this->oObject);
	}

	/**
	 * @return int
	 */
	public function GetObjectId()
	{
		return $this->oObject->GetKey();
	}

	/**
	 * Returns the whole view (legend, elements, ...) as fragments (HTML, JS files, JS inline, CSS files, CSS inline)
	 *
	 * @return \Combodo\iTop\Renderer\RenderingOutput
	 * @throws \DictExceptionMissingString
	 */
	public function Render()
	{
		$oOutput = new RenderingOutput();

		$sJSWidgetName = 'datacenter_' . $this->sType . '_view';
		$sJSWidgetDataJSON = $this->GetDataForJSWidget(true);

		// Dict. entries
		$sNoElementLabel = Dict::S('Molkobain:DatacenterView:NoElement');

		// Add markup
		// - Header messages
		$sHeaderMessagesAsHTML = '';
		//   No height defined for element
		if ((int) $this->oObject->Get('nb_u') === 0) {
			$sDictAsHTML = htmlentities(Dict::S('Molkobain:DatacenterView:WarningMessage:NoHeightForHost'), ENT_QUOTES, 'UTF-8');
			$sHeaderMessagesAsHTML .= <<<HTML
<div class="header_message message_warning ibo-alert ibo-is-warning">{$sDictAsHTML}</div>
HTML;
		}

		// - Legend
		$sLegendTitle = Dict::S('Molkobain:DatacenterView:Legend:Title');

		// - Filter
		$sFilterTitle = Dict::S('Molkobain:DatacenterView:Filter:Title');
		$sFilterDescription = Dict::S('Molkobain:DatacenterView:Filter:Description');
		$sFilterInputTooltip = Dict::S('Molkobain:DatacenterView:Filter:Input:Placeholder');
		$sFilterInputTooltipAsHTML = htmlentities($sFilterInputTooltip, ENT_QUOTES, 'UTF-8');

		// - Options
		$sOptionsTitle = Dict::S('Molkobain:DatacenterView:Options:Title');
		$sOptionsOperation = static::ENUM_ENDPOINT_OPERATION_SUBMITOPTIONS;
		$sOptionsItemsHtml = '';
		foreach($this->PrepareOptions() as $sOptionCode => $aOptionData)
		{
			$sOptionItemLabelForHtml = '';
			if(!empty($aOptionData['input_id']))
			{
				$sOptionItemLabelForHtml = 'for="' . $aOptionData['input_id'] . '"';
			}

			$sOptionItemTooltipHtml = '';
			if(!empty($aOptionData['tooltip']))
			{
				// Note: Escaping tooltip to avoid breaking HTML tag and XSS attacks
				$sEscapedOptionTooltip = htmlentities($aOptionData['tooltip'], ENT_QUOTES, 'UTF-8');
				$sOptionItemTooltipHtml = 'title="' . $sEscapedOptionTooltip . '" data-toggle="tooltip"';
			}

			$sOptionsItemsHtml .= <<<HTML
<li class="mdv-of-item">
	<label {$sOptionItemLabelForHtml}>
		<span {$sOptionItemTooltipHtml}>{$aOptionData['label']}</span>
		<span class="mhf-pull-right">{$aOptionData['input_html']}</span>	
	</label>
</li>
HTML;
		}

		// - Unmounted panels
		$sTogglerTooltip = Dict::S('Molkobain:DatacenterView:Unmounted:Toggler:Tooltip');

		// Note: We could split this in protected methods for overloading (PrepareHtml, PrepareJs, ...)
		$oOutput->AddHtml(<<<HTML
<div class="molkobain-datacenter-view-container" data-portal="backoffice">
	<div class="mdv-header">$sHeaderMessagesAsHTML</div>
	<div class="mdv-body">
		<div class="mdv-controls">
			<div class="mdv-legend mhf-panel">
				<div class="mhf-p-header">
					<span class="mhf-ph-icon"><span class="fas fa-fw fa-list"></span></span>
					<span class="mhf-ph-title">{$sLegendTitle}</span>
				</div>
				<!-- Important: There must be no spaces in this div, otherwise the :empty CSS rule will not work -->
				<!-- Note: We can't use :blank yet as it is not implemented by any browser... -->
				<div class="mhf-p-body" data-empty-text="{$sNoElementLabel}"></div>
			</div>
			<div class="mdv-filter mhf-panel">
				<div class="mhf-p-header">				
					<span class="mhf-ph-icon"><span class="fas fa-fw fa-filter"></span></span>
					<span class="mhf-ph-title">{$sFilterTitle}</span>
				</div>
				<div class="mhf-p-body">
					<div class="mdv-filter-description">{$sFilterDescription}</div>
					<div class="mdv-filter-container"><input class="mdv-filter-input" type="search" placeholder="{$sFilterInputTooltipAsHTML}" /></div>
				</div>
			</div>
			<div class="mdv-options mhf-panel">
				<div class="mhf-p-header">				
					<span class="mhf-ph-icon"><span class="fas fa-fw fa-cog"></span></span>
					<span class="mhf-ph-title">{$sOptionsTitle}</span>
				</div>
				<div class="mhf-p-body">
					<form method="post" class="mdv-options-form">
						<input type="hidden" name="operation" value="{$sOptionsOperation}" />
						<ul>
							{$sOptionsItemsHtml}
						</ul>
					</form>
				</div>
			</div>
		</div>
	
		<div class="mdv-views">
		</div>
		
		<div class="mdv-unmounted">
		</div>
	
		<div class="mhf-loader mhf-hide">
			<div class="mhf-loader-text">
				<span class="fas fa-spin fa-sync-alt fa-fw"></span>
			</div>
		</div>
	</div>
	
	<div class="mhf-templates">
		<!-- Legend item template -->
		<li class="mdv-legend-item" data-class="" data-count="">
			<span class="mdv-li-title"></span>
			<span class="mdv-li-count mhf-pull-right"></span>
		</li>
		
		<!-- Rack panel template -->
		<div class="mdv-rack-panel mdv-host-panel" data-type="" data-class="" data-id="" data-panel-code="" data-name="">
			<div class="mdv-rp-title"></div>
			<div class="mdv-rp-view">
				<div class="mdv-rpv-top"></div>
				<div class="mdv-rpv-middle mdv-host-units-wrapper"></div>
				<div class="mdv-rpv-bottom"></div>
			</div>
		</div>
		
		<!-- Rack unit template -->
		<div class="mdv-rack-unit mdv-host-unit" data-unit-number="">
			<div class="mdv-ru-left mdv-hu-left"></div>
			<div class="mdv-ru-slot mdv-hu-slot"></div>
			<div class="mdv-ru-right mdv-hu-right"></div>
		</div>
		
		<!-- Enclosure template -->
		<div class="mdv-enclosure mdv-element mdv-host-panel" data-type="" data-class="" data-id="" data-panel-code="" data-name="" data-rack-id="" data-position-v="" data-position-p="">
			<div class="mdv-host-units-wrapper"></div>
		</div>
		
		<!-- Enclosure unit template -->
		<div class="mdv-enclosure-unit mdv-host-unit" data-unit-number="">
			<div class="mdv-eu-left mdv-hu-left"></div>
			<div class="mdv-eu-slot mdv-hu-slot"></div>
			<div class="mdv-eu-right mdv-hu-right"></div>
		</div>
		
		<!-- Device template -->
		<div class="mdv-device mdv-element" data-type="" data-class="" data-id="" data-name="" data-rack-id="" data-enclosure-id="" data-position-v="" data-position-p="">
			<span class="mdv-d-name"></span>
		</div>
		
		<!-- Unmounted type template (enclosures / devices) -->
		<div class="mdv-unmounted-type mhf-panel" data-type="">
			<div class="mhf-p-header">
				<span class="mhf-ph-icon">
					<span class="mdv-uth-spot"></span>
				</span>
				<span class="mhf-ph-title"></span>
				<span class="mhf-ph-actions mhf-pull-right">
					<span class="mhf-ph-toggler fas fa-fw fa-caret-down" title="{$sTogglerTooltip}"></span>
				</span>
			</div>
			<!-- Important: There must be no spaces in this div, otherwise the :empty CSS rule will not work -->
			<!-- Note: We can't use :blank yet as it is not implemented by any browser... -->
			<div class="mhf-p-body mdv-ut-body" data-hover-text="" data-empty-text="{$sNoElementLabel}"></div>
		</div>
	</div>
</div>
HTML
		);

		// Init JS widget
		$oOutput->AddJs(<<<EOF
// Molkobain datacenter view
// - Initializing widget
$.molkobain.{$sJSWidgetName}(
    $sJSWidgetDataJSON,
    $('.molkobain-datacenter-view-container')
);
EOF
		);

		return $oOutput;
	}


	//-------------------------------------------
	// Data, used for the visual representation
	//-------------------------------------------

	/**
	 * Returns the object data for the JS widget either as a PHP array or JSON string
	 *
	 * @param bool $bAsJSON
	 *
	 * @return array|string
	 * @throws \Exception
	 * @throws \DictExceptionMissingString
	 */
	protected function GetDataForJSWidget($bAsJSON = false)
	{
		// Note: Data could be retrieved on object instanciation along with legend data
		$aObjectData = $this->GetObjectData();

		$aData = array(
			'debug' => ConfigHelper::IsDebugEnabled(),
			'object_type' => $this->sType,
			'object_data' => $aObjectData,
			'endpoint' => $this->GetEndpoint(),
			'legend' => $this->GetLegendData($aObjectData),
			'dict' => $this->GetDictEntries(),
			'use_legacy_tooltips' => (ConfigHelper::IsRunningiTop30OrNewer() === false),
		);

		return ($bAsJSON) ? json_encode($aData) : $aData;
	}

	/**
	 * Returns structured data about the object and its enclosures/devices
	 *
	 * @return array
	 */
	protected function GetObjectData()
	{
		$sMethodName = 'Get' . StringHelper::ToCamelCase($this->sType) . 'Data';

		// Note: Here we could check if the method is callable and return static::GetObjectBaseData() as a fallback.
		return static::$sMethodName($this->oObject);
	}

	/**
	 * Returns base data of $oObject (which can be $this->oObject or one of its devices)
	 *
	 * @param \DBObject $oObject
	 *
	 * @return array
	 * @throws \CoreException
	 * @throws \Exception
	 */
	protected function GetObjectBaseData(DBObject $oObject)
	{
		$sObjClass = get_class($oObject);
		$iNbU = (empty($oObject->Get('nb_u'))) ? 1 : (int) $oObject->Get('nb_u');

		$aData = array(
			'type' => static::FindObjectType($oObject),
			'class' => $sObjClass,
			'id' => $oObject->GetKey(),
			'name' => $oObject->GetName(),
			'serial_number' => MetaModel::IsValidAttCode($sObjClass, 'serialnumber') ? $oObject->Get('serialnumber') : null,
			'asset_number' => MetaModel::IsValidAttCode($sObjClass, 'asset_number') ? $oObject->Get('asset_number') : null,
			'icon' => $oObject->GetIcon(false),
			'url' => $oObject->GetHyperlink(), // Note: GetHyperlink() actually return the HTML markup
			'nb_u' => $iNbU,
			'nb_cols' => static::DEFAULT_NB_COLS,
		);

		// Optional tooltip
		$sTooltipContent = $this->MakeDeviceTooltipContent($oObject);
		if ($sTooltipContent !== null) {
			$aData['tooltip'] = [
				'content' => $sTooltipContent,
			];
		}

		return $aData;
	}

	/**
	 * Returns data for a rack object
	 *
	 * @param \Rack $oRack
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected function GetRackData(Rack $oRack)
	{
		$aData = $this->GetObjectBaseData($oRack) + array(
				'panels' => array(
					static::ENUM_PANEL_FRONT => Dict::S('Molkobain:DatacenterView:Rack:Panel:Front:Title'),
				),
				'enclosures' => array(
					'icon' => MetaModel::GetClassIcon('Enclosure', false),
					static::ENUM_ASSEMBLY_TYPE_MOUNTED => array(),
					static::ENUM_ASSEMBLY_TYPE_UNMOUNTED => array(),
				),
				'devices' => array(
					'icon' => MetaModel::GetClassIcon('DatacenterDevice', false),
					static::ENUM_ASSEMBLY_TYPE_MOUNTED => array(),
					static::ENUM_ASSEMBLY_TYPE_UNMOUNTED => array(),
				),
			);

		/** @var \DBObjectSet $oEnclosureSet */
		$oEnclosureSet = $oRack->Get('enclosure_list');
		/** @var \Enclosure $oEnclosure */
		while($oEnclosure = $oEnclosureSet->Fetch())
		{
			// Note: Here we can't filter set on none obsolete data (SetShowObsoleteData()) only because since iTop 2.4 it returns an ormLinkSet instead of a DBObjectSet
			if($oEnclosure->IsObsolete() && ($this->GetOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE) === false))
			{
				continue;
			}

			$aEnclosureData = $this->GetEnclosureData($oEnclosure);
			$sEnclosureAssemblyType = $oEnclosure->IsMounted() ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;

			$aData['enclosures'][$sEnclosureAssemblyType][] = $aEnclosureData;
		}

		foreach(static::$aDeviceCategories as $sCategoryName => $aCategoryParams)
		{
			// Calling registered (static) ConfigHelper in order to call the right method
			foreach(call_user_func(array($this->sStaticConfigHelperClass, $aCategoryParams['enum_classes_callback_name'])) as $sDeviceClass)
			{
				$oDeviceSearch = DBObjectSearch::FromOQL('SELECT '.$sDeviceClass.' WHERE rack_id = :rack_id AND enclosure_id = 0');
				$oDeviceSearch->SetShowObsoleteData($this->GetOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE));
				$oDeviceSet = new DBObjectSet($oDeviceSearch, array(), array('rack_id' => $oRack->GetKey()));
				/** @var \DatacenterDevice|\PDU|\DBObject $oDevice Note that \DBObject is only there for custom DM classes */
				while($oDevice = $oDeviceSet->Fetch())
				{
					$aDeviceData = $this->GetDeviceData($oDevice);
					if(is_callable(array($oDevice, 'IsMounted'), true))
					{
						$sDeviceAssemblyType = $oDevice->IsMounted() ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;
					}
					else
					{
						// Note: We might want to force custom classes to have a "IsMounted()" method.
						$sDeviceAssemblyType = ($oDevice->Get('position_v') > 0) ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;
					}

					$aData['devices'][$sDeviceAssemblyType][] = $aDeviceData;
				}
			}
		}

		return $aData;
	}

	/**
	 * Returns data for an eclosure object
	 *
	 * @param \Enclosure $oEnclosure
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected function GetEnclosureData(Enclosure $oEnclosure)
	{
		$aData = $this->GetObjectBaseData($oEnclosure) + array(
				'rack_id' => (int) $oEnclosure->Get('rack_id'),
				'position_v' => (int) $oEnclosure->Get('position_v'),
				'position_h' => 1,
				'position_p' => static::ENUM_PANEL_FRONT,
				'panels' => array(
					static::ENUM_PANEL_FRONT => Dict::S('Molkobain:DatacenterView:Enclosure:Panel:Front:Title'),
				),
				'devices' => array(
					'icon' => MetaModel::GetClassIcon('DatacenterDevice', false),
					static::ENUM_ASSEMBLY_TYPE_MOUNTED => array(),
					static::ENUM_ASSEMBLY_TYPE_UNMOUNTED => array(),
				),
			);

		foreach(static::$aDeviceCategories as $sCategoryName => $aCategoryParams)
		{
			// Calling registered (static) ConfigHelper in order to call the right method
			foreach(call_user_func(array($this->sStaticConfigHelperClass, $aCategoryParams['enum_classes_callback_name'])) as $sDeviceClass)
			{
				$oDeviceSearch = DBObjectSearch::FromOQL('SELECT '.$sDeviceClass.' WHERE rack_id = :rack_id AND enclosure_id = :enclosure_id');
				$oDeviceSearch->SetShowObsoleteData($this->GetOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE));
				$oDeviceSet = new DBObjectSet($oDeviceSearch, array(), array('rack_id' => $oEnclosure->Get('rack_id'), 'enclosure_id' => $oEnclosure->GetKey()));
				/** @var \DatacenterDevice|\PDU|\DBObject $oDevice Note that \DBObject is only there for custom DM classes */
				while($oDevice = $oDeviceSet->Fetch())
				{
					$aDeviceData = $this->GetDeviceData($oDevice);
					if(is_callable(array($oDevice, 'IsMounted'), true))
					{
						$sDeviceAssemblyType = $oDevice->IsMounted() ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;
					}
					else
					{
						// Note: We might want to force custom classes to have a "IsMounted()" method.
						$sDeviceAssemblyType = ($oDevice->Get('position_v') > 0) ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;
					}

					$aData['devices'][$sDeviceAssemblyType][] = $aDeviceData;
				}
			}
		}

		return $aData;
	}

	/**
	 * Returns data for a device object
	 *
	 * @param \DBObject $oDevice
	 *
	 * @return array
	 * @throws \CoreException
	 * @throws \Exception
	 */
	protected function GetDeviceData(DBObject $oDevice)
	{
		$aData = $this->GetObjectBaseData($oDevice) + array(
				'rack_id' => (int) $oDevice->Get('rack_id'),
				'enclosure_id' => MetaModel::IsValidAttCode(get_class($oDevice), 'enclosure_id') ? (int) $oDevice->Get('enclosure_id') : 0,
				'position_v' => (int) $oDevice->Get('position_v'),
				'position_h' => 1,
				'position_p' => static::ENUM_PANEL_FRONT,
			);

		return $aData;
	}

	/**
	 * Returns data to build the legend (classes, counts, ...) from the $aObjectData.
	 *
	 * @param array $aObjectData *
	 * @param array $aLegendData Passed by reference
	 *
	 * @return array
	 * @throws \Exception
	 */
	protected function GetLegendData($aObjectData, &$aLegendData = array())
	{
		if(empty($aLegendData))
		{
			$aLegendData = array(
				'classes' => array(),
			);
		}

		foreach(static::EnumElementTypes() as $sElementType)
		{
			$sElementTypePlural = $sElementType . 's';
			if(!array_key_exists($sElementTypePlural, $aObjectData))
			{
				continue;
			}

			foreach(static::EnumAssemblyTypes() as $sAssemblyType)
			{
				if(!array_key_exists($sAssemblyType, $aObjectData[$sElementTypePlural]))
				{
					continue;
				}

				foreach($aObjectData[$sElementTypePlural][$sAssemblyType] as $aElement)
				{
					if(!array_key_exists($aElement['class'], $aLegendData['classes']))
					{
						$aLegendData['classes'][$aElement['class']] = array(
							'title' => MetaModel::GetName($aElement['class']),
							'count' => 0,
						);
					}
					$aLegendData['classes'][$aElement['class']]['count']++;

					foreach(static::EnumElementTypes() as $sSubElementType)
					{
						$sSubElementTypePlural = $sSubElementType . 's';
						if(array_key_exists($sSubElementTypePlural, $aElement))
						{
							$this->GetLegendData($aElement, $aLegendData);
						}
					}
				}
			}
		}

		// Sort classes
		uasort($aLegendData['classes'], function($aClass1, $aClass2){
			$sValue1 = $aClass1['title'];
			$sValue2 = $aClass2['title'];

			if ($sValue1 == $sValue2) {
				return 0;
			}
			return ($sValue1 < $sValue2) ? -1 : 1;
		});

		return $aLegendData;
	}

	/**
	 * Returns the HTML content for the device's tooltip
	 *
	 * @param \DBObject $oObject
	 *
	 * @return string|null HTML content of the $oObject tooltip if there no summary card available
	 * @throws \CoreException
	 * @throws \Exception
	 *
	 * @since v1.13.0 Returns null in iTop 3.1+ if a summary card if available for $oObject
	 */
	protected function MakeDeviceTooltipContent(DBObject $oObject)
	{
		$sObjClass = get_class($oObject);

		// First, check if there is a summary card for that class, in which case we'll use it instead of our custom tooltip
		$aSummaryItems = MetaModel::GetZListItems($sObjClass, 'summary');
		if ((count($aSummaryItems) > 0) && (false === ConfigHelper::GetSetting('force_device_tooltip_even_with_summary_card'))) {
			return null;
		}

		$aObjMandatoryAttCodes = array('finalclass', 'org_id', 'status', 'business_criticity', 'enclosure_id');
		$aObjOptionalAttCodes = array();

		// Retrieving attributes to display in the "more" part
		$aAttCodesFromSettings = ConfigHelper::GetSetting('device_tooltip_attributes');
		foreach(MetaModel::EnumParentClasses($sObjClass, ENUM_PARENT_CLASSES_ALL, false) as $sClass)
		{
			if(is_array($aAttCodesFromSettings) && array_key_exists($sClass, $aAttCodesFromSettings) && is_array($aAttCodesFromSettings[$sClass]))
			{
				$aObjOptionalAttCodes = $aAttCodesFromSettings[$sClass];
				break;
			}
		}

		$aObjAttCodes = array(
			'base-info' => $aObjMandatoryAttCodes,
			'more-info' => $aObjOptionalAttCodes,
		);

		// Building the HTML markup
		// - Base info
		$sClassImage = $oObject->GetIcon();
		$sObjName = $oObject->GetName();
		// - Attributes
		$sAttributesHTML = '';
		foreach($aObjAttCodes as $sAttCategory => $aAttCodes)
		{
			if(count($aAttCodes) > 0)
			{
				$sAttributesHTML .= '<div class="mdv-et-list-wrapper mdv-dt-' . $sAttCategory . '">';
				$sAttributesHTML .= '<fieldset><legend>' . Dict::S('Molkobain:DatacenterView:Element:Tooltip:Fieldset:' . $sAttCategory) . '</legend>';
				$sAttributesHTML .= '<ul>';
				foreach($aAttCodes as $sAttCode)
				{
					if(!MetaModel::IsValidAttCode($sObjClass, $sAttCode))
					{
						continue;
					}

					$sAttLabel = MetaModel::GetLabel($sObjClass, $sAttCode);
					/** @var \AttributeDefinition $oAttDef */
					$oAttDef = MetaModel::GetAttributeDef($sObjClass, $sAttCode);
					if($oAttDef instanceof AttributeExternalKey)
					{
						$sAttValue = htmlentities($oObject->Get($sAttCode . '_friendlyname'), ENT_QUOTES, 'UTF-8');
					}
					elseif($oAttDef instanceof AttributeHTML)
					{
						// Already sanitized on object insert/update
						$sAttValue = $oObject->GetAsHTML($sAttCode);
					}
					else
					{
						$sAttValue = htmlentities($oAttDef->GetValueLabel($oObject->Get($sAttCode)), ENT_QUOTES, 'UTF-8');
					}
					$sAttributesHTML .= '<li><span class="mdv-etl-label">' . $sAttLabel . '</span><span class="mdv-etl-value">' . $sAttValue . '</span></li>';
				}
				$sAttributesHTML .= '</ul>';
				$sAttributesHTML .= '</fieldset>';
				$sAttributesHTML .= '</div>';
			}
		}

		$sHTML = <<<HTML
	<div class="mdv-et-header">
		<span class="mdv-eth-icon">{$sClassImage}</span>
		<span class="mdv-eth-name">{$sObjName}</span>
	</div>
	{$sAttributesHTML}
HTML;

		return $sHTML;
	}

	/**
	 * Returns dictionary entries used by the JS widget
	 *
	 * @return array
	 * @throws \DictExceptionMissingString
	 */
	protected function GetDictEntries()
	{
		return array(
			'Molkobain:DatacenterView:NoElement' => Dict::S('Molkobain:DatacenterView:NoElement'),
			'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => Dict::S('Molkobain:DatacenterView:Unmounted:Enclosures:Title'),
			'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => Dict::S('Molkobain:DatacenterView:Unmounted:Enclosures:Title+'),
			'Molkobain:DatacenterView:Unmounted:Devices:Title' => Dict::S('Molkobain:DatacenterView:Unmounted:Devices:Title'),
			'Molkobain:DatacenterView:Unmounted:Devices:Title+' => Dict::S('Molkobain:DatacenterView:Unmounted:Devices:Title+'),
		);
	}


	//----------
	// Options
	//----------

	/**
	 * Returns if the $sCode option is for the current object or global to the module
	 *
	 * @param string $sCode
	 *
	 * @return bool
	 */
	protected function IsGlobalOption($sCode)
	{
		switch($sCode)
		{
			// Prefs. specific to the current object
			case static::ENUM_OPTION_CODE_SHOWOBSOLETE:
				$bRet = false;
				break;

			// Prefs. global to the whole module
			default:
				$bRet = true;
				break;
		}

		return $bRet;
	}

	/**
	 * Returns the user preference code for the $sCode option as options can be stored either in a global user pref. or object specific user pref.
	 *
	 * @param string $sOptionCode
	 *
	 * @return string
	 */
	public function GetUserPrefCodeForOption($sOptionCode)
	{
		$sUserPrefCode = ($this->IsGlobalOption($sOptionCode)) ? ConfigHelper::GetModuleCode() . '|global' : ConfigHelper::GetModuleCode() . '|object|' . $this->GetObjectClass() . '|' . $this->GetObjectId();

		return $sUserPrefCode;
	}

	/**
	 * Returns the current value of the $sCode option if present, otherwise retrieves it from user preferences
	 *
	 * @param string $sCode
	 *
	 * @return mixed
	 */
	public function GetOption($sCode)
	{
		// Cache value if not already present
		if(!array_key_exists($sCode, $this->aOptions))
		{
			/** @noinspection PhpParamsInspection */
			/** @var array $aPref */
			$aPref = appUserPreferences::GetPref($this->GetUserPrefCodeForOption($sCode), array());

			$this->aOptions[$sCode] = (array_key_exists($sCode, $aPref)) ? $aPref[$sCode] : $this->GetOptionDefaultValue($sCode);
		}

		return $this->aOptions[$sCode];
	}

	/**
	 * Returns the default value for $sCode option.
	 *
	 * @param string $sCode
	 *
	 * @return null|mixed
	 */
	protected function GetOptionDefaultValue($sCode)
	{
		$defaultValue = null;

		switch($sCode)
		{
			case static::ENUM_OPTION_CODE_SHOWOBSOLETE:
				// Value is defined as follows: user pref on object >> user pref in iTop >> instance config parameter
				/** @var boolean $bShowObsoleteConfigDefault */
				$bShowObsoleteConfigDefault = MetaModel::GetConfig()->Get('obsolescence.show_obsolete_data');
				$defaultValue = appUserPreferences::GetPref('show_obsolete_data', $bShowObsoleteConfigDefault);
				break;
		}

		return $defaultValue;
	}

	/**
	 * Sets the current value of the $sCode option in the cache (but does NOT saves it in the DB, use SaveOption() for that)
	 *
	 * @param string $sCode
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function SetOption($sCode, $value)
	{
		$this->aOptions[$sCode] = $value;

		return $this;
	}

	/**
	 * Saves the $value of the $sCode option in the user preferences (DB)
	 *
	 * @param string $sCode
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function SaveOption($sCode, $value)
	{
		$sUserPrefCode = $this->GetUserPrefCodeForOption($sCode);

		/** @noinspection PhpParamsInspection */
		/** @var array $aPref */
		$aPref = appUserPreferences::GetPref($sUserPrefCode, array());
		if(array_key_exists($sCode, $aPref) && ($aPref[$sCode] === $value))
		{
			// Do not write it again
		}
		else
		{
			$aPref[$sCode] = $value;
			/** @noinspection PhpParamsInspection */
			appUserPreferences::SetPref($sUserPrefCode, $aPref);
		}

		return $this;
	}

	/**
	 * Read options from posted params and updates user preferences
	 *
	 * @return $this
	 */
	public function ReadPostedOptions()
	{
		// Show obsolete
		$bShowObsolete = (utils::ReadPostedParam(static::ENUM_OPTION_CODE_SHOWOBSOLETE, '') === 'on') ? true : false;
		$this->SetOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE, $bShowObsolete)
			->SaveOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE, $bShowObsolete);

		return $this;
	}

	/**
	 * Returns options data:
	 *
	 * array(
	 *   'label' => 'abc',
	 *   'tooltip' => 'def',        // Not escaped, can't be displayed in HTML as-is
	 *   'input_html' => '<foo>',
	 * )
	 *
	 * @return array
	 * @throws \DictExceptionMissingString
	 */
	protected function PrepareOptions()
	{
		$aOptions = array();

		// Show obsolete
		// - Retrieve value
		$bShowObsolete = $this->GetOption(static::ENUM_OPTION_CODE_SHOWOBSOLETE);
		$oShowObsoleteButton = UIHelper::MakeToggleButton(static::ENUM_OPTION_CODE_SHOWOBSOLETE, $bShowObsolete, null, '$(this).closest(".molkobain-datacenter-view").trigger("mdv.refresh_view")');
		// - Add to options
		$aOptions[static::ENUM_OPTION_CODE_SHOWOBSOLETE] = array(
			'label' => Dict::S('Molkobain:DatacenterView:Options:Option:ShowObsolete'),
			'tooltip' => Dict::S('Molkobain:DatacenterView:Options:Option:ShowObsolete+'),
			'input_id' => $oShowObsoleteButton->GetInputId(),
			'input_html' => $oShowObsoleteButton->Render(),
		);

		return $aOptions;
	}


	//-----------------
	// Static methods
	//-----------------

	/**
	 * Note: Using a static method instead of a static array as it is not possible in PHP 5.6
	 *
	 * @return array
	 */
	public static function EnumPanels()
	{
		return array(
			static::ENUM_PANEL_FRONT,
		);
	}

	/**
	 * Returns if the $oObject is a rack|enclosure|device (see ENUM_ELEMENT_TYPE_XXX constants)
	 *
	 * @param \DBObject $oObject
	 *
	 * @return string
	 */
	public static function FindObjectType(DBObject $oObject)
	{
		if($oObject instanceof Rack)
		{
			$sObjType = static::ENUM_ELEMENT_TYPE_RACK;
		}
		elseif($oObject instanceof Enclosure)
		{
			$sObjType = static::ENUM_ELEMENT_TYPE_ENCLOSURE;
		}
		else
		{
			$sObjType = static::ENUM_ELEMENT_TYPE_DEVICE;
		}

		return $sObjType;
	}

	/**
	 * Note: Using a static method instead of a static array as it is not possible in PHP 5.6
	 *
	 * @return array
	 */
	public static function EnumElementTypes()
	{
		return array(
			static::ENUM_ELEMENT_TYPE_RACK,
			static::ENUM_ELEMENT_TYPE_ENCLOSURE,
			static::ENUM_ELEMENT_TYPE_DEVICE,
		);
	}

	/**
	 * Note: Using a static method instead of a static array as it is not possible in PHP 5.6
	 *
	 * @return array
	 */
	public static function EnumAssemblyTypes()
	{
		return array(
			static::ENUM_ASSEMBLY_TYPE_MOUNTED,
			static::ENUM_ASSEMBLY_TYPE_UNMOUNTED,
		);
	}

	/**
	 * Return only option codes, not their labels.
	 *
	 * Note: Using a static method instead of a static array as it is not possible in PHP 5.6
	 *
	 * @return array
	 */
	public static function EnumOptionCodes()
	{
		return array(
			static::ENUM_OPTION_CODE_SHOWOBSOLETE,
		);
	}

	/**
	 * Returns the callback name for the $sOperation.
	 * Callback must be a NON static, public function and must return an array of data.
	 *
	 * Eg. For operation "update_position" => "OnUpdatePositionAsyncOp";
	 *
	 * @param string $sOperation
	 *
	 * @return string
	 */
	public static function GetCallbackNameFromAsyncOpCode($sOperation)
	{
		return 'On' . str_replace('_', '', ucwords($sOperation, '_')) . 'AsyncOp';
	}

	/**
	 * Returns the FQCN of the ConfigHelper used by the current (static) class
	 *
	 * @return string
	 */
	public static function GetStaticConfigHelperClass()
	{
		return '\\Molkobain\\iTop\\Extension\\DatacenterView\\Common\\Helper\\ConfigHelper';
	}
}
