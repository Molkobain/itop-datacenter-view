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
	'molkobain-datacenter-view/1.13.0', array(
        // Identification
        'label' => 'Datacenter view (racks visual representation)',
        'category' => 'business',

        // Setup
        'dependencies' => array(
            'itop-datacenter-mgmt/2.7.0 && itop-config-mgmt/2.7.0 && itop-storage-mgmt/2.7.0', // Mandatory dependencies, we should consider bridge modules in the future
	        'molkobain-handy-framework/1.7.0 || combodo-location-hierarchy/1.0.0', // Optional dependency on location hierarchy
	        'molkobain-handy-framework/1.7.0',
	        'molkobain-console-tooltips/1.1.1 || itop-structure/3.0.0', // Optional dependency, only for iTop 2.7 and older
	        'molkobain-newsroom-provider/1.1.0',
        ),
        'mandatory' => false,
        'visible' => true,
        'installer' => 'DatacenterViewInstaller',

        // Components
        'datamodel' => array(
        	'model.molkobain-datacenter-view.php',
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
			'force_device_tooltip_even_with_summary_card' => false,
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

if (!class_exists('DatacenterViewInstaller'))
{
	/**
	 * Class DatacenterViewInstaller
	 *
	 * @since v1.6.0
	 */
	class DatacenterViewInstaller extends ModuleInstallerAPI
	{
		/**
		 * @inheritDoc
		 */
		public static function AfterDatabaseCreation(Config $oConfiguration, $sPreviousVersion, $sCurrentVersion)
		{
			if (version_compare($sPreviousVersion, '1.6.0', '<'))
			{
				SetupLog::Info("|- Upgrading molkobain-datacenter-view from '$sPreviousVersion' to '$sCurrentVersion'. From v1.6.0, the extension brings the LocationType typology to better document Location objects. This adds some basic LocationTypes to bootstrap the user.");

				$aLTNames = array(
					'Building',
					'Floor',
					'Room',
				);
				foreach($aLTNames as $sLTName)
				{
					$oLT = MetaModel::NewObject('LocationType');
					$oLT->Set('name', $sLTName);
					$oLT->DBWrite();
					SetupLog::Info("|  |- LocationType '$sLTName' created.");
				}
			}
		}
	}
}
