<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\NewsroomProvider\Core;

use MetaModel;
use Molkobain\iTop\Extension\NewsroomProvider\Helper\ConfigHelper;
use NewsroomProviderBase;
use User;
use UserRights;

// Protection for iTop older than 2.6.0 when the extension is packaged with another.
if(class_exists('NewsroomProviderBase'))
{
	/**
	 * Class MolkobainNewsroomProvider
	 *
	 * Note: This is greatly inspired by the itop-hub-connector module.
	 *
	 * @package Molkobain\iTop\Extension\NewsroomProvider\Core
	 * @since v1.0.0
	 */
	class MolkobainNewsroomProvider extends NewsroomProviderBase
	{
		/**
		 * @inheritDoc
		 */
		public function GetTTL()
		{
			// Update every hour
			return 60 * 60;
		}

		/**
		 * @inheritDoc
		 */
		public function IsApplicable(User $oUser = null)
		{
			if(!ConfigHelper::IsEnabled())
			{
				return false;
			}
			elseif($oUser !== null)
			{
				return UserRights::IsAdministrator($oUser);
			}
			else
			{
				return false;
			}

		}

		/**
		 * @inheritDoc
		 */
		public function GetLabel()
		{
			return 'Molkobain I/O';
		}

		/**
		 * @inheritDoc
		 */
		public function GetMarkAllAsReadURL()
		{
			return $this->MakeUrl('mark_all_as_read');
		}

		/**
		 * @inheritDoc
		 */
		public function GetFetchURL()
		{
			return $this->MakeUrl('fetch');
		}

		/**
		 * @inheritDoc
		 */
		public function GetViewAllURL()
		{
			return $this->MakeUrl('view_all');
		}

		/**
		 * Note: Placeholders are only used in the news' URL
		 *
		 * @inheritDoc
		 * @throws \Exception
		 */
		public function GetPlaceholders()
		{
			$aPlaceholders = array();

			$oUser = UserRights::GetUserObject();
			if($oUser !== null)
			{
				$aPlaceholders['%user_login%'] = $oUser->Get('login');
				$aPlaceholders['%user_hash%'] = ConfigHelper::GetUserHash();
			}

			// Default contact placeholders values
			$aPlaceholders['%contact_firstname%'] = '';
			$aPlaceholders['%contact_lastname%'] = '';
			$aPlaceholders['%contact_email%'] = '';
			$aPlaceholders['%contact_organization%'] = '';
			$aPlaceholders['%contact_location%'] = '';

			// Check if we can have a better value for those placeholders
			$oContact = UserRights::GetContactObject();
			if($oContact !== null)
			{
				$sContactClass = get_class($oContact);
				$aPlaceholdersAttCodes = array(
					'%contact_firstname%' => 'first_name',
					'%contact_lastname%' => 'name',
					'%contact_email%' => 'email',
					'%contact_organization%' => 'org_id_friendlyname',
					'%contact_location%' => 'location_id_friendlyname',
				);
				foreach($aPlaceholdersAttCodes as $sPlaceholderCode => $sPlaceholderAttCode)
				{
					// Skip invalid attributes (non standard DM)
					if(!MetaModel::IsValidAttCode($sContactClass, $sPlaceholderAttCode))
					{
						continue;
					}

					$aPlaceholders[$sPlaceholderCode] = $oContact->Get($sPlaceholderAttCode);
				}
			}

			return $aPlaceholders;
		}

		/**
		 * @inheritDoc
		 */
		public function GetPreferencesUrl()
		{
			return null;
		}

		/**
		 * Returns an URL to the news editor for the $sOperation and current user
		 *
		 * @param string $sOperation
		 *
		 * @return string
		 */
		private function MakeUrl($sOperation)
		{
			return ConfigHelper::GetSetting('endpoint')
				. '&operation=' . $sOperation
				. '&version=' . ConfigHelper::GetVersion()
				. '&user=' . urlencode(ConfigHelper::GetUserHash())
				. '&instance=' . urlencode(ConfigHelper::GetInstanceHash())
				. '&app-name=' . urlencode(ConfigHelper::GetApplicationName())
				. '&app-version=' . urlencode(ConfigHelper::GetApplicationVersion());
		}
	}
}
