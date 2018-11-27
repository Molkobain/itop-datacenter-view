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

namespace Molkobain\iTop\DatacenterView\Common\Helper;

use DBObject;
use DBObjectSearch;
use DBObjectSet;
use Dict;
use AttributeExternalKey;
use MetaModel;

/**
 * Class DataHelper
 *
 * @package Molkobain\iTop\DatacenterView\Common\Helper
 */
class DataHelper
{
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
		$aData = array(
			'debug' => ConfigHelper::IsDebugEnabled(),
			'object_type' => static::GetObjectType($oObject),
			'object_data' => static::GetObjectData($oObject),
			'dict' => static::GetDictEntries(),
		);

		return ($bAsJSON) ? json_encode($aData) : $aData;
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
	 * Returns structured data about the $oObject and its enclosures/devices
	 *
	 * @param \DBObject $oObject
	 *
	 * @return array
	 */
	public static function GetObjectData(DBObject $oObject)
	{
		$sObjType = static::GetObjectType($oObject);
		$sMethodName = 'Get'.ucfirst($sObjType).'Data';

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
			    'mounted' => array(),
			    'unmounted' => array(),
		    ),
		    'devices' => array(
			    'icon' => MetaModel::GetClassIcon('DatacenterDevice', false),
		    	'mounted' => array(),
			    'unmounted' => array(),
		    ),
	    );

	    /** @var \DBObjectSet $oEnclosureSet */
	    $oEnclosureSet = $oRack->Get('enclosure_list');
	    while($oEnclosure = $oEnclosureSet->Fetch())
	    {
		    $aEnclosureData = static::GetEnclosureData($oEnclosure);
		    $sEnclosureAssembly = ($aEnclosureData['position_v'] > 0) ? 'mounted' : 'unmounted';

		    $aData['enclosures'][$sEnclosureAssembly][] = $aEnclosureData;
	    }

	    $oDeviceSearch = DBObjectSearch::FromOQL('SELECT DatacenterDevice WHERE rack_id = :rack_id AND enclosure_id = 0');
	    $oDeviceSet = new DBObjectSet($oDeviceSearch, array(), array('rack_id' => $oRack->GetKey()));
	    while($oDevice = $oDeviceSet->Fetch())
	    {
		    $aDeviceData = static::GetDeviceData($oDevice);
		    $sDeviceAssembly = ($aDeviceData['position_v'] > 0) ? 'mounted' : 'unmounted';

		    $aData['devices'][$sDeviceAssembly][] = $aDeviceData;
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
    		'position_v' => (int) $oEnclosure->Get('position_v'),
    		'position_p' => 'front',
    		'devices' => array(
			    'icon' => MetaModel::GetClassIcon('DatacenterDevice', false),
	            'mounted' => array(),
			    'unmounted' => array(),
		    ),
	    );

    	/** @var \DBObjectSet $oDeviceSet */
	    $oDeviceSet = $oEnclosure->Get('device_list');
	    while($oDevice = $oDeviceSet->Fetch())
	    {
	    	$aDeviceData = static::GetDeviceData($oDevice);
	    	$sDeviceAssembly = ($aDeviceData['position_v'] > 0) ? 'mounted' : 'unmounted';

	    	$aData['devices'][$sDeviceAssembly][] = $aDeviceData;
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
		    'position_v' => (int) $oDevice->Get('position_v'),
	        'position_p' => 'front',
	    );

	    return $aData;
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
    	$aObjAttCodes = array();

    	// Retrieving attributes to display in the "more" part
    	$aAttCodesFromSettings = ConfigHelper::GetSetting('device_tooltip_attributes');
        foreach(MetaModel::EnumParentClasses($sObjClass, ENUM_PARENT_CLASSES_ALL, false) as $sClass)
	    {
	    	if(is_array($aAttCodesFromSettings) && array_key_exists($sClass, $aAttCodesFromSettings) && is_array($aAttCodesFromSettings[$sClass]))
		    {
		    	$aObjAttCodes = $aAttCodesFromSettings[$sClass];
		    	break;
		    }
	    }

	    // Building the HTML markup
	    // - Base info
	    $sClassImage = $oObject->GetIcon();
        $sClassName = MetaModel::GetName($sObjClass);
        // - Optional attributes
	    $sAttributeHTML = '';
	    if(count($aObjAttCodes) > 0)
	    {
	    	$sAttributeHTML .= '<div class="mdv-dt-more-info">';
	    	$sAttributeHTML .= '<ul>';
	    	foreach($aObjAttCodes as $sAttCode)
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
		    	    $sAttValue = htmlentities($oObject->Get($sAttCode.'_friendlyname'), ENT_QUOTES, 'UTF-8');
			    }
			    else
			    {
				    $sAttValue = htmlentities($oAttDef->GetValueLabel($oObject->Get($sAttCode)), ENT_QUOTES, 'UTF-8');
			    }
		    	$sAttributeHTML .= '<li>'.Dict::Format('Molkobain:DatacenterView:Element:Tooltip:Attribute', $sAttLabel, $sAttValue).'</li>';
		    }
		    $sAttributeHTML .= '</ul>';
	    	$sAttributeHTML .= '</div>';
	    }

	    $sHTML = <<<EOF
	<div class="mdv-device-tooltip">
		<div class="mdv-dt-header">
			<span class="mdv-dth-icon">{$sClassImage}</span>
			<span class="mdv-dth-name">{$sClassName}</span>
		</div>
		<div class="mdv-dt-general-info">
		
		</div>
		{$sAttributeHTML}
	</div>
EOF;
\IssueLog::Error($sHTML);
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
