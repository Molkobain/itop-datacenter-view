<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

// IMPORTANT: This is a temporary compatibility bridge to enable a smooth migration from iTop 2.6- to iTop 2.7+.
// In the next version of the extension, this will be remove and the require_once from the 2.7 will be moved to the 'datamodel' section of the module.itop-portal-url-brick.php file.

// iTop 2.7 and newer
if(file_exists(MODULESROOT . '/itop-portal-base/portal/vendor/autoload.php'))
{
	require_once __DIR__ . '/src/Extension/Hook/Portal/PortalUIExtension.php';
}
// iTop 2.6 and older
else
{
	require_once __DIR__ . '/legacy/PortalUIExtension.php';
}