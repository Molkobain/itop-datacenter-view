<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\NewsroomProvider\Helper;

use MetaModel;
use Molkobain\iTop\Extension\HandyFramework\Helper\ConfigHelper as BaseConfigHelper;
use SimpleCrypt;
use UserRights;
use utils;

/**
 * Class ConfigHelper
 *
 * @package Molkobain\iTop\Extension\NewsroomProvider\Helper
 * @since v1.0.0
 */
class ConfigHelper extends BaseConfigHelper
{
	const MODULE_NAME = 'molkobain-newsroom-provider';
	const API_VERSION = '1.3';

	const SETTING_CONST_FQCN = 'Molkobain\\iTop\\Extension\\NewsroomProvider\\Helper\\ConfigHelper';

	// Note: Mind to update defaults values in the module file when changing those default values.
	const DEFAULT_SETTING_DEBUG = false;
	const DEFAULT_SETTING_ENDPOINT = 'https://www.molkobain.com/support/pages/exec.php?exec_module=molkobain-newsroom-editor&exec_page=index.php';

	/**
	 * Newsroom will be enabled only if manually enabled in the conf. parameters or if not in a Combodo product
	 *
	 * @inheritDoc
	 */
	public static function IsEnabled()
	{
		// We do NOT use the default value {@see BaseConfigHelper::GetSetting()} on purpose, so we know if the param. has been manually set or not
		$bEnabled = MetaModel::GetModuleSetting(static::MODULE_NAME, 'enabled', null);

		// Manually set, keep this value...
		if ($bEnabled !== null) {
			return $bEnabled;
		}

		// ... else check if in a Combodo product
		$bIsCombodoProduct = static::IsCombodoProductPackage();
		return $bIsCombodoProduct ? false : true;
	}

	/**
	 * Returns true if the debug option is enabled
	 *
	 * @return boolean
	 */
	public static function IsDebugEnabled()
	{
		return static::GetSetting('debug');
	}

	/**
	 * @return bool True if the current iTop instance is a Combodo product package
	 * @since v1.6.0
	 */
	public static function IsCombodoProductPackage()
	{
		return utils::GetCompiledModuleVersion('itsm-designer-connector') !== null;
	}

	/**
	 * Returns the version of the API called on the remote server
	 *
	 * @return string
	 * @since v1.6.0 Renamed from GetVersion to GetAPIVersion
	 */
	public static function GetAPIVersion()
	{
		return static::API_VERSION;
	}

	/**
	 * @return string Encrypted current user ID, non-reversible to ensure user's privacy
	 */
	public static function GetUserHash()
	{
		$sUserId = UserRights::GetUserId();

		// Prepare a unique hash to identify users across all iTops in order to be able for them to tell which news they have already read.
		return hash('fnv1a64', $sUserId);
	}

	/**
	 * @return string Encrypted UUID of the iTop web instance, non-reversible to ensure user's privacy
	 * @since v1.6.0 Renamed from GetInstanceHash to GetWebInstanceHashAsEncrypted
	 * @since v1.7.0 Renamed from GetWebInstanceHashAsEncrypted to GetWebInstanceHash
	 */
	public static function GetWebInstanceHash()
	{
		$sITopUUID = (string) trim(@file_get_contents(APPROOT . 'data/instance.txt'), "{} \n");

		return hash('fnv1a64', $sITopUUID);
	}

	/**
	 * @return string Encrypted UUID of the iTop database instance, non-reversible to ensure user's privacy
	 * @since v1.6.0
	 * @since v1.7.0 Renamed from GetDBInstanceHashAsEncrypted to GetDBInstanceHash
	 */
	public static function GetDBInstanceHash()
	{
		$sITopUUID = (string) trim(DBProperty::GetProperty('database_uuid', ''), "{}");

		return hash('fnv1a64', $sITopUUID);
	}

	/**
	 * @return string Encrypted URL of the iTop application
	 * @since v1.6.0
	 */
	public static function GetApplicationURLAsEncrypted()
	{
		return static::EncryptData(utils::GetAbsoluteUrlAppRoot());
	}

	/**
	 * Returns the application name (usually "iTop") or 'unknown' if the information is not available.
	 *
	 * @return string
	 * @since v1.1.0
	 */
	public static function GetApplicationName()
	{
		return defined('ITOP_APPLICATION') ? ITOP_APPLICATION : 'unknown';
	}

	/**
	 * Returns the application version or 'unknown' if the information is not available.
	 *
	 * @return string
	 * @since v1.1.0
	 */
	public static function GetApplicationVersion()
	{
		return defined('ITOP_VERSION') ? ITOP_VERSION : 'unknown';
	}

	/**
	 * @return string Encrypted PHP version currently ran by the iTop webserver
	 * @since v1.6.0
	 */
	public static function GetPHPVersionAsEncrypted()
	{
		return static::EncryptData(phpversion());
	}

	/**
	 * @return string Pipe-separated list of installed Molkobain modules
	 * @since v1.7.0
	 */
	public static function GetMolkobainInstalledModules()
	{
		/** @var string[] $aMolkobainModulesIDs */
		$aMolkobainModulesIDs = [];

		foreach (GetModulesInfo() as $sModuleCode => $aModuleData) {
			if (strpos($sModuleCode, 'molkobain-') === 0) {
				$aMolkobainModulesIDs[] = $sModuleCode . '/' . $aModuleData['version'];
			}
		}

		return implode('|', $aMolkobainModulesIDs);
	}

	/**
	 * @param string $sData String data to encrypt
	 *
	 * @return string Encrypted string
	 * @since v1.6.0
	 */
	protected static function EncryptData($sData)
	{
		// Use "Simple" encryption method to ensure compatibility with all iTop instances
		$oCryptService = new SimpleCrypt("Simple");
		return $oCryptService->Encrypt(static::GetAPIVersion(), $sData);
	}
}
