<?php
/*
 * Copyright (c) 2015 - 2024 Molkobain.
 *
 * This file is part of a licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more information)
 */

namespace Molkobain\iTop\Extension\NewsroomProvider\Hook\Console;

use Combodo\iTop\Application\Helper\Session;
use iBackofficeReadyScriptExtension;
use iPageUIExtension;
use iTopWebPage;
use Molkobain\iTop\Extension\NewsroomProvider\Helper\ConfigHelper;
use Molkobain\iTop\Extension\NewsroomProvider\Core\MolkobainNewsroomProvider;
use UserRights;

if (version_compare(ITOP_VERSION, '3.0.0', '<')) {
	/**
	 * Class PageUIExtension
	 *
	 * Fallback of the newsroom provider for Combodo products (not used in Community version)
	 *
	 * @since v1.7.0
	 */
	class PageProductBeam implements iPageUIExtension
	{
		/**
		 * @inheritDoc
		 * @throws \Exception
		 */
		public function GetNorthPaneHtml(iTopWebPage $oPage)
		{
			if (false === UserRights::IsAdministrator() && false === UserRights::IsActionAllowed('ResourceDesignerConnectorMenu', UR_ACTION_MODIFY)) {
				return "";
			}

			if (false === ConfigHelper::IsCombodoProductPackage()) {
				return "";
			}

			if (false === isset($_SESSION['auth_user'])) {
				return "";
			}

			$oNewsroomProvider = new MolkobainNewsroomProvider();
			$iTTL = $oNewsroomProvider->GetTTL();

			// Don't beam if TTL is not reached
			$iCurrentTime = time();
			if (isset($_SESSION['molkobain-newsroom-provider-last-beam']) && ($iCurrentTime - $_SESSION['molkobain-newsroom-provider-last-beam']) <= $iTTL) {
				return "";
			}

			$_SESSION['molkobain-newsroom-provider-last-beam'] = $iCurrentTime;

			$sBeamURL = $oNewsroomProvider->GetBeamURL();
			$sBeamURLForJSON = json_encode($sBeamURL);

			$oPage->add_ready_script(<<<JS
	$.ajax({ type: "POST",
	         url: $sBeamURLForJSON,
	         async: true,
	         dataType : 'json',
	         crossDomain: true
	 });
JS
			);
		}

		/**
		 * @inheritDoc
		 */
		public function GetSouthPaneHtml(iTopWebPage $oPage)
		{
			// Do nothing
		}

		/**
		 * @inheritDoc
		 */
		public function GetBannerHtml(iTopWebPage $oPage)
		{
			// Do nothing
		}
	}
} else {
	/**
	 * Class PageProductBeam
	 *
	 * Fallback of the newsroom provider for Combodo products (not used in Community version)
	 * @since v1.7.0
	 */
	class PageProductBeam implements iBackofficeReadyScriptExtension
	{
		/**
		 * @inheritDoc
		 */
		public function GetReadyScript(): string
		{
			if (false === UserRights::IsAdministrator() && false === UserRights::IsActionAllowed('ResourceDesignerConnectorMenu', UR_ACTION_MODIFY)) {
				return "";
			}

			if (false === ConfigHelper::IsCombodoProductPackage()) {
				return "";
			}

			if (false === Session::IsInitialized()) {
				return "";
			}

			$oNewsroomProvider = new MolkobainNewsroomProvider();
			$iTTL = $oNewsroomProvider->GetTTL();

			// Don't beam if TTL is not reached
			$iCurrentTime = time();
			if (Session::IsSet('molkobain-newsroom-provider-last-beam') && ($iCurrentTime - Session::Get('molkobain-newsroom-provider-last-beam')) <= $iTTL) {
				return "";
			}

			Session::Set('molkobain-newsroom-provider-last-beam', $iCurrentTime);

			$sBeamURL = $oNewsroomProvider->GetBeamURL();
			$sBeamURLForJSON = json_encode($sBeamURL);

			return <<<JS
	$.ajax({ type: "POST",
	         url: $sBeamURLForJSON,
	         async: true,
	         dataType : 'json',
	         crossDomain: true
	 });
JS;
		}
	}

}
