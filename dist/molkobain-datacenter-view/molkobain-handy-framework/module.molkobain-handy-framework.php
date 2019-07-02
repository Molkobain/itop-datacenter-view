<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

//
// iTop module definition file
//

/** @noinspection PhpUnhandledExceptionInspection */
SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'molkobain-handy-framework/1.2.4',
	array(
		// Identification
		//
		'label' => 'Molkobain\'s handy framework',
		'category' => 'tools',

		// Setup
		//
		'dependencies' => array(
			'itop-welcome-itil/2.4.0'
		),
		'mandatory' => true,
		'visible' => false,

		// Components
		//
		'datamodel' => array(
			'core/attributerackunit.class.inc.php',
		    'common/confighelper.class.inc.php',
		    'common/stringhelper.class.inc.php',
		    'common/uihelper.class.inc.php',
		    'common/ui/togglebutton.class.inc.php',
		    'console/pageuiextension.class.inc.php',
            'portal/apis/extensions/portaluiextension.class.inc.php',
		),
		'webservice' => array(

		),
		'data.struct' => array(
			// add your 'structure' definition XML files here,
		),
		'data.sample' => array(
			// add your sample data XML files here,
		),

		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any

		// Default settings
		//
		'settings' => array(
			// Module specific settings go here, if any
            'enabled' => true,
		),
	)
);
