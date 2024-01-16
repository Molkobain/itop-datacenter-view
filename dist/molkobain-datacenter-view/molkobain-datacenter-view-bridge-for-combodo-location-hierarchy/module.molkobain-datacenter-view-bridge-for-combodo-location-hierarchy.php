<?php
/**
 * Copyright (c) 2015 - 2020 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

/** @noinspection PhpUnhandledExceptionInspection */
SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'molkobain-datacenter-view-bridge-for-combodo-location-hierarchy/1.0.0', array(
        // Identification
        'label' => 'Bridge - Datacenter view + Location hierarchy = ❤',
        'category' => 'business',

        // Setup
        'dependencies' => array(
            'molkobain-datacenter-view/1.9.0',
	        'molkobain-datacenter-view/1.9.0||combodo-location-hierarchy/1.0.1',
        ),
        'mandatory' => false,
        'visible' => false,
		'auto_select' => 'SetupInfo::ModuleIsSelected("molkobain-datacenter-view") && SetupInfo::ModuleIsSelected("combodo-location-hierarchy")',

        // Components
        'datamodel' => array(
        ),
        'webservice' => array(
        ),
        'dictionary' => array(
        ),
        'data.struct' => array(
        ),
        'data.sample' => array(
        ),

        // Documentation
        'doc.manual_setup' => '',
        'doc.more_information' => '',

        // Default settings
        'settings' => array(
        ),
	)
);
