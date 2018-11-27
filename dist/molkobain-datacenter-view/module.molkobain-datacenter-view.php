<?php
/**
 * Copyright (c) 2015 - 2018 Molkobain.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'molkobain-datacenter-view/1.0.0', array(
        // Identification
        'label' => 'TODO: Datacenter view (racks visual representation)',
        'category' => 'cmdb',

        // Setup
        'dependencies' => array(
            'itop-datacenter-mgmt/2.2.0||itop-config-mgmt/2.2.0||itop-storage-mgmt/2.2.0',
        ),
        'mandatory' => false,
        'visible' => true,

        // Components
        'datamodel' => array(
            'common/confighelper.class.inc.php',
            'common/datahelper.class.inc.php',
            'console/uiextension.class.inc.php',
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
