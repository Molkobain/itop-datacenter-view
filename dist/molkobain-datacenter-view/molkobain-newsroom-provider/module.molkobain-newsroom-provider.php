<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
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
	'molkobain-newsroom-provider/1.5.0',
	array(
		// Identification
		//
		'label' => 'Molkobain\'s newsroom provider',
		'category' => 'tools',

		// Setup
		//
		'dependencies' => array(
			'molkobain-handy-framework/1.8.0',
		),
		'mandatory' => true,
		'visible' => true,

		// Components
		//
		'datamodel' => array(
			// Load extension autoloader
			'vendor/autoload.php',
			// Classes aliases
			'src/Compatibility/ClassesAliases.php',
			// Explicitly load APIs
			'src/Core/NewsroomProvider.php',
			'src/Extension/Hook/Console/PageUIExtension.php',
		),
		'webservice' => array(),
		'data.struct' => array(// add your 'structure' definition XML files here,
		),
		'data.sample' => array(// add your sample data XML files here,
		),

		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any

		// Default settings
		//
		'settings' => array(),
	)
);