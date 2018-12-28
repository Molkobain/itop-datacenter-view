<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
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
use MetaModel;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/**
 * Class DatacenterView
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Common
 */
class DatacenterView
{
	const ENUM_ASSEMBLY_TYPE_MOUNTED = 'mounted';
	const ENUM_ASSEMBLY_TYPE_UNMOUNTED = 'unmounted';
	const ENUM_ELEMENT_TYPE_RACK = 'rack';
	const ENUM_ELEMENT_TYPE_ENCLOSURE = 'enclosure';
	const ENUM_ELEMENT_TYPE_DEVICE = 'device';

	protected $sType;
	protected $aElementClasses;

	public function __construct()
	{

	}

	/**
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
	 * Returns if the $oObject is a rack|enclosure|device
	 *
	 * @param \DBObject $oObject
	 *
	 * @return string
	 */
	public static function GetObjectType(DBObject $oObject)
	{
		$sObjClass = get_class($oObject);
		switch($sObjClass)
		{
			case 'Rack':
				$sObjType = 'rack';
				break;
			case 'Enclosure':
				$sObjType = 'enclosure';
				break;
			default:
				$sObjType = 'device';
				break;
		}

		return $sObjType;
	}

	/**
	 * Returns the $oObject data for the JS widget either as a PHP array or JSON string
	 *
	 * @param \DBObject $oObject
	 * @param bool $bAsJSON
	 *
	 * @return array|string
	 * @throws \DictExceptionMissingString
	 */
	public static function GetWidgetData(DBObject $oObject, $bAsJSON = false)
	{
		$aObjectData = static::GetObjectData($oObject);

		$aData = array(
			'debug' => ConfigHelper::IsDebugEnabled(),
			'object_type' => static::GetObjectType($oObject),
			'object_data' => $aObjectData,
			'legend' => static::GetLegendData($aObjectData),
			'dict' => static::GetDictEntries(),
		);

		return ($bAsJSON) ? json_encode($aData) : $aData;
	}


	//---------
	// Data
	//---------

	/**
	 * Returns structured data about the $oObject and its enclosures/devices
	 *
	 * @param \DBObject $oObject
	 *
	 * @return array
	 */
	public static function GetObjectData(DBObject $oObject)
	{
		$sObjType = static::GetObjectType($oObject);
		$sMethodName = 'Get' . ucfirst($sObjType) . 'Data';

		return static::$sMethodName($oObject);
	}

	/**
	 * @param \DBObject $oObject
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected static function GetObjectBaseData(DBObject $oObject)
	{
		$iNbU = (empty($oObject->Get('nb_u'))) ? 1 : (int) $oObject->Get('nb_u');

		$aData = array(
			'class' => get_class($oObject),
			'id' => $oObject->GetKey(),
			'name' => $oObject->GetName(),
			'icon' => $oObject->GetIcon(false),
			'url' => $oObject->GetHyperlink(), // Note: GetHyperlink() actually return the HTML markup
			'nb_u' => $iNbU,
			'tooltip' => array(
				'content' => static::MakeDeviceTooltipContent($oObject),
			),
		);

		return $aData;
	}

	/**
	 * @param \DBObject $oRack
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected static function GetRackData(DBObject $oRack)
	{
		$aData = static::GetObjectBaseData($oRack) + array(
				'panels' => array(
					'front' => Dict::S('Molkobain:DatacenterView:Rack:Panel:Front:Title'),
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
		while($oEnclosure = $oEnclosureSet->Fetch())
		{
			$aEnclosureData = static::GetEnclosureData($oEnclosure);
			$sEnclosureAssemblyType = ($aEnclosureData['position_v'] > 0) ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;

			$aData['enclosures'][$sEnclosureAssemblyType][] = $aEnclosureData;
		}

		$oDeviceSearch = DBObjectSearch::FromOQL('SELECT DatacenterDevice WHERE rack_id = :rack_id AND enclosure_id = 0');
		$oDeviceSet = new DBObjectSet($oDeviceSearch, array(), array('rack_id' => $oRack->GetKey()));
		while($oDevice = $oDeviceSet->Fetch())
		{
			$aDeviceData = static::GetDeviceData($oDevice);
			$sDeviceAssemblyType = ($aDeviceData['position_v'] > 0) ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;

			$aData['devices'][$sDeviceAssemblyType][] = $aDeviceData;
		}

		return $aData;
	}

	/**
	 * @param \DBObject $oEnclosure
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected static function GetEnclosureData(DBObject $oEnclosure)
	{
		$aData = static::GetObjectBaseData($oEnclosure) + array(
				'rack_id' => (int) $oEnclosure->Get('rack_id'),
				'position_v' => (int) $oEnclosure->Get('position_v'),
				'position_p' => 'front',
				'devices' => array(
					'icon' => MetaModel::GetClassIcon('DatacenterDevice', false),
					static::ENUM_ASSEMBLY_TYPE_MOUNTED => array(),
					static::ENUM_ASSEMBLY_TYPE_UNMOUNTED => array(),
				),
			);

		/** @var \DBObjectSet $oDeviceSet */
		$oDeviceSet = $oEnclosure->Get('device_list');
		while($oDevice = $oDeviceSet->Fetch())
		{
			$aDeviceData = static::GetDeviceData($oDevice);
			$sDeviceAssemblyType = ($aDeviceData['position_v'] > 0) ? static::ENUM_ASSEMBLY_TYPE_MOUNTED : static::ENUM_ASSEMBLY_TYPE_UNMOUNTED;

			$aData['devices'][$sDeviceAssemblyType][] = $aDeviceData;
		}

		return $aData;
	}

	/**
	 * @param \DBObject $oDevice
	 *
	 * @return array
	 * @throws \CoreException
	 */
	protected static function GetDeviceData(DBObject $oDevice)
	{
		$aData = static::GetObjectBaseData($oDevice) + array(
				'rack_id' => (int) $oDevice->Get('rack_id'),
				'enclosure_id' => (int) $oDevice->Get('enclosure_id'),
				'position_v' => (int) $oDevice->Get('position_v'),
				'position_p' => 'front',
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
	 */
	protected static function GetLegendData($aObjectData, &$aLegendData = array())
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
							static::GetLegendData($aElement, $aLegendData);
						}
					}
				}
			}
		}

		return $aLegendData;
	}

	/**
	 * Returns the HTML content for the device's tooltip
	 *
	 * @param \DBObject $oObject
	 *
	 * @return string
	 * @throws \CoreException
	 * @throws \Exception
	 */
	protected static function MakeDeviceTooltipContent(DBObject $oObject)
	{
		$sObjClass = get_class($oObject);
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
		$sClassName = MetaModel::GetName($sObjClass);
		$sObjName = $oObject->GetName();
		// - Attributes
		$sAttributesHTML = '';
		foreach($aObjAttCodes as $sAttCategory => $aAttCodes)
		{
			if(count($aAttCodes) > 0)
			{
				$sAttributesHTML .= '<div class="mdv-dt-list-wrapper mdv-dt-' . $sAttCategory . '">';
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
					else
					{
						$sAttValue = htmlentities($oAttDef->GetValueLabel($oObject->Get($sAttCode)), ENT_QUOTES, 'UTF-8');
					}
					$sAttributesHTML .= '<li><span class="mdv-dtl-label">' . $sAttLabel . '</span><span class="mdv-dtl-value">' . $sAttValue . '</span></li>';
				}
				$sAttributesHTML .= '</ul>';
				$sAttributesHTML .= '</fieldset>';
				$sAttributesHTML .= '</div>';
			}
		}

		$sHTML = <<<EOF
	<div class="mdv-dt-header">
		<span class="mdv-dth-icon">{$sClassImage}</span>
		<span class="mdv-dth-name">{$sObjName}</span>
	</div>
	{$sAttributesHTML}
EOF;

		return $sHTML;
	}

	/**
	 * Returns dictionary entries used by the JS widget
	 *
	 * @return array
	 * @throws \DictExceptionMissingString
	 */
	protected static function GetDictEntries()
	{
		return array(
			'Molkobain:DatacenterView:Unmounted:Enclosures:Title' => Dict::S('Molkobain:DatacenterView:Unmounted:Enclosures:Title'),
			'Molkobain:DatacenterView:Unmounted:Enclosures:Title+' => Dict::S('Molkobain:DatacenterView:Unmounted:Enclosures:Title+'),
			'Molkobain:DatacenterView:Unmounted:Devices:Title' => Dict::S('Molkobain:DatacenterView:Unmounted:Devices:Title'),
			'Molkobain:DatacenterView:Unmounted:Devices:Title+' => Dict::S('Molkobain:DatacenterView:Unmounted:Devices:Title+'),
		);
	}
}
