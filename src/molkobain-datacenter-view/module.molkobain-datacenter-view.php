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
	'molkobain-datacenter-view/1.2.0', array(
        // Identification
        'label' => 'Datacenter view (racks visual representation)',
        'category' => 'business',

        // Setup
        'dependencies' => array(
            'itop-datacenter-mgmt/2.2.0||itop-config-mgmt/2.2.0||itop-storage-mgmt/2.2.0',
	        'molkobain-handy-framework/1.2.1',
	        'molkobain-console-tooltips/1.0.2',
        ),
        'mandatory' => false,
        'visible' => true,

        // Components
        'datamodel' => array(
            'common/confighelper.class.inc.php',
            'common/datacenterviewfactory.class.inc.php',
            'common/datacenterview.class.inc.php',
            'console/applicationuiextension.class.inc.php',
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
	        // Module specific settings go here, if any
	        'enabled' => true,
	        'debug' => false,
	        'device_tooltip_attributes' => array(
		        'DatacenterDevice' => array(
			        'brand_id',
			        'model_id',
			        'serialnumber',
			        'asset_number',
		        ),
		        'NetworkDevice' => array(
		        	'networkdevicetype_id',
			        'brand_id',
			        'model_id',
			        'ram',
			        'serialnumber',
			        'asset_number',
		        ),
		        'Server' => array(
			        'brand_id',
			        'model_id',
			        'osfamily_id',
			        'cpu',
			        'ram',
			        'serialnumber',
			        'asset_number',
		        ),
	        ),
        ),
	)
);
