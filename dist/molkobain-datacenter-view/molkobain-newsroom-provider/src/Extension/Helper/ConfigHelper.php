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
	const API_VERSION = '1.1';

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
		$bIsCombodoProduct = utils::GetCompiledModuleVersion('itsm-designer-connector') !== null;
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
	 * Returns the version of the API called on the remote server
	 *
	 * @return string
	 */
	public static function GetVersion()
	{
		return static::API_VERSION;
	}

	/**
	 * Returns an hash to identify the current user
	 *
	 * Note: User ID is sent as a non-reversible hash to ensure user's privacy
	 *
	 * @return string
	 */
	public static function GetUserHash()
	{
		$sUserId = UserRights::GetUserId();

		// Prepare a unique hash to identify users across all iTops in order to be able for them to tell which news they have already read.
		return hash('fnv1a64', $sUserId);
	}

	/**
	 * Returns an hash to identify the current iTop instance
	 *
	 * Note: iTop UUID is sent as a non-reversible hash to ensure user's privacy
	 *
	 * @return string
	 */
	public static function GetInstanceHash()
	{
		$sITopUUID = (string) trim(@file_get_contents(APPROOT . 'data/instance.txt'), "{} \n");

		// Note: We don't retrieve DB UUID for now as it is not of any use for now.
		return hash('fnv1a64', $sITopUUID);
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
}
