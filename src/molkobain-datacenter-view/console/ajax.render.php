<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/** @noinspection UsingInclusionOnceReturnValueInspection */
@include_once '../approot.inc.php';
@include_once '../../approot.inc.php';
@include_once '../../../approot.inc.php';

try
{
	require_once APPROOT.'application/application.inc.php';
	require_once APPROOT.'/application/startup.inc.php';
	if (ConfigHelper::IsRunningiTop30OrNewer() === false) {
		require_once APPROOT.'application/webpage.class.inc.php';
		require_once APPROOT.'application/ajaxwebpage.class.inc.php';
		require_once APPROOT.'application/loginwebpage.class.inc.php';

		$oPage = new ajax_page('');
	} else {
		$oPage = new AjaxPage('');
	}
	require_once APPROOT.'/application/user.preferences.class.inc.php';

	LoginWebPage::DoLoginEx('backoffice', false);

	$oPage->no_cache();

	$sOperation = utils::ReadParam('operation', '');
	$sClass = utils::ReadParam('class', '', false, 'class');
	$iId = (int) utils::ReadParam('id', 0);

	$oObject = MetaModel::GetObject($sClass, $iId);
	$oDatacenterView = DatacenterViewFactory::BuildFromObject($oObject);

	switch ($sOperation)
	{
		case $oDatacenterView::ENUM_ENDPOINT_OPERATION_RENDERTAB:
		case $oDatacenterView::ENUM_ENDPOINT_OPERATION_SUBMITOPTIONS:
			// Retrieve if object in edition mode
			$bEditMode = (bool) utils::ReadParam('edit_mode', $oDatacenterView::DEFAULT_OBJECT_IN_EDIT_MODE);
			$oDatacenterView->SetObjectInEditMode($bEditMode);

			// Retrieve options if present
			if($sOperation === $oDatacenterView::ENUM_ENDPOINT_OPERATION_SUBMITOPTIONS)
			{
				$oDatacenterView->ReadPostedOptions();
			}

			// Render tab
			$oPage->SetContentType('text/html');
			$oOutput = $oDatacenterView->Render();

			// HTML
			$oPage->add($oOutput->GetHtml());
			// JS inline
			if(!empty($oOutput->GetJs()))
			{
				$oPage->add_ready_script($oOutput->GetJs());
			}
			// CSS inline
			if(!empty($oOutput->GetCss()))
			{
				$oPage->add_style($oOutput->GetCss());
			}
			// JS & CSS files should have been added when adding tab
			break;

		default:
			$sCallbackName = $oDatacenterView::GetCallbackNameFromAsyncOpCode($sOperation);
			if(method_exists($oDatacenterView, $sCallbackName))
			{
				$aOutput = array(
					'status' => 'ok',
				);

				try
				{
					// Mind the "+" as we want to preserve the "status" to "ok". Error messages should be thrown through an exception.
					$aOutput = $aOutput + $oDatacenterView->$sCallbackName();
				}
				catch(Exception $e)
				{
					$aOutput['status'] = 'error';
					$aOutput['message'] = htmlentities($e->GetMessage(), ENT_QUOTES, 'utf-8');
				}

				$oPage->SetContentType('application/json');
				echo json_encode($aOutput);
			}
			else
			{
				$oPage->p("Invalid query.");
			}
	}

	$oPage->output();
} catch (Exception $e)
{
	// Note: Transform to cope with XSS attacks
	echo htmlentities($e->GetMessage(), ENT_QUOTES, 'utf-8');
	IssueLog::Error($e->getMessage()."\nDebug trace:\n".$e->getTraceAsString());
}
