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

/**
 * Class DataHelper
 *
 * @package Molkobain\iTop\DatacenterView\Common\Helper
 */
class DataHelper
{
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
	public static function GetData(DBObject $oObject)
	{
		$sObjType = static::GetObjectType($oObject);
		$sMethodName = 'Get'.ucfirst($sObjType).'Data';

		return static::$sMethodName($oObject);
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
			    'mounted' => array(),
			    'unmounted' => array(),
		    ),
		    'devices' => array(
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

	    	$aData[$sDeviceAssembly][] = $aDeviceData;
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
	 * @param \DBObject $oObject
	 *
	 * @return array
	 */
    protected static function GetObjectBaseData(DBObject $oObject)
    {
	    $aData = array(
		    'class' => get_class($oObject),
		    'id' => $oObject->GetKey(),
		    'name' => $oObject->GetName(),
		    'icon' => $oObject->GetIcon(false),
		    'url' => $oObject->GetHyperlink(), // Note: GetHyperlink() actually return the HTML markup
		    'nb_u' => $oObject->Get('nb_u'),
	    );

	    return $aData;
    }
}
