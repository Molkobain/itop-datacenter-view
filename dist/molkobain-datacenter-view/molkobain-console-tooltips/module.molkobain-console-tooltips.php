<?php
/**
 * Copyright (c) 2015 - 2019 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

/** @noinspection PhpUnhandledExceptionInspection */
SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'molkobain-console-tooltips/1.3.0', array(
	// Identification
	'label' => 'Attributes description tooltip',
		'category' => 'ui',
	// Setup
	'dependencies' => array(
		'molkobain-handy-framework/1.7.0',
		'molkobain-newsroom-provider/1.0.1',
		'molkobain-fontawesome5-pack/1.3.0',
	),
	'mandatory' => false,
	'visible' => true,
	// Components
	'datamodel' => array(
	    'console/uiextension.class.inc.php',
	),
	'webservice' => array(
	//'webservices.itop-portal-base.php',
	),
	'dictionary' => array(
	//'en.dict.itop-portal-base.php',
	),
	'data.struct' => array(
	//'data.struct.itop-portal-base.xml',
	),
	'data.sample' => array(
	//'data.sample.itop-portal-base.xml',
	),
	// Documentation
	'doc.manual_setup' => '',
	'doc.more_information' => '',
	// Default settings
	'settings' => array(
	    'decoration_class' => 'fas fa-question',
        'enabled' => true,
	),
	)
);
