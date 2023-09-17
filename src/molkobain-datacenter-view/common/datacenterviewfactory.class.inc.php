<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Common;

use Exception;
use DBObject;

/**
 * Class DatacenterViewFactory
 *
 * @package Molkobain\iTop\Extension\DatacenterView\Common
 * @since 1.1.0
 */
class DatacenterViewFactory
{
	const DEFAULT_DATACENTER_VIEW_CLASS = 'Molkobain\\iTop\\Extension\\DatacenterView\\Common\\DatacenterView';

	/** @var string $sDatacenterViewClass */
	protected static $sDatacenterViewClass;
	/** @var array $aCachedDatacenterViews */
	protected static $aCachedDatacenterViews = array();

	/**
	 * Returns a DatacenterView of $oObject based on the current registered class (static::$sDatacenterView)
	 *
	 * Note: DatacenterView objects are cached in static::$aCachedDatacenterView
	 *
	 * @param \DBObject $oObject
	 *
	 * @return \Molkobain\iTop\Extension\DatacenterView\Common\DatacenterView
	 *
	 * @throws \Exception
	 */
	public static function BuildFromObject(DBObject $oObject)
	{
		// Set default class if none
		if(empty(static::$sDatacenterViewClass))
		{
			static::$sDatacenterViewClass = static::DEFAULT_DATACENTER_VIEW_CLASS;
		}

		// Check if class exists
		if(!class_exists(static::$sDatacenterViewClass))
		{
			throw new Exception('Could not make DatacenterView as "'.static::$sDatacenterViewClass.'" class does not exists.');
		}

		// Cache view
		$sCacheKey = get_class($oObject) . '::' . $oObject->GetKey();
		if(!array_key_exists($sCacheKey, static::$aCachedDatacenterViews))
		{
			static::$aCachedDatacenterViews[$sCacheKey] = new static::$sDatacenterViewClass($oObject);
		}

		return static::$aCachedDatacenterViews[$sCacheKey];
	}

	/**
	 * Registers the PHP class to build. Must be an instance of static::DEFAULT_DATACENTER_VIEW_CLASS.
	 *
	 * @param string $sClass The FQCN of the class
	 *
	 * @throws \Exception
	 */
	public static function RegisterClass($sClass)
	{
		// Check if class instance of DatacenterView
		if(false === is_a($sClass, static::DEFAULT_DATACENTER_VIEW_CLASS, true)) {
			throw new Exception('Could not register "'.$sClass.'" as DatacenterView class as it does not extends it.');
		}

		static::$sDatacenterViewClass = $sClass;
	}
}
