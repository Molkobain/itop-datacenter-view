<?php
/*
 * Copyright (c) 2015 - 2023 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Tests\PHPUnitTests\UnitaryTests\Common;

use Combodo\iTop\Test\UnitTest\ItopDataTestCase;
use MetaModel;
use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory;
use Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper;

/**
 * @covers \Molkobain\iTop\Extension\DatacenterView\Common\ConfigHelper
 */
class ConfigHelperTest extends ItopDataTestCase
{
	/**
	 * @covers       \Molkobain\iTop\Extension\DatacenterView\Common\Helper\ConfigHelper::IsAllowedClass
	 * @dataProvider providerIsAllowedClass
	 *
	 * @param string $sClass
	 * @param bool $bExpectedResult
	 *
	 * @return void
	 */
	public function testIsAllowedClass(string $sClass, bool $bExpectedResult): void
	{
		$bTestedResult = ConfigHelper::IsAllowedClass($sClass);
		$this->assertSame($bExpectedResult, $bTestedResult, "Class $sClass tested as allowed ".var_dump($bTestedResult)." when it was expected to be ".var_dump($bExpectedResult));
	}

	public function providerIsAllowedClass(): array
	{
		return [
			"Valid host: Rack" => [
				"Rack",    // Tested class
				true,      // Should be allowed
			],
			"Valid host: Enclosure" => [
				"Enclosure",
				true,
			],
			"Invalid host, can only be a device: DatacenterDevice" => [
				"DatacenterDevice",
				false,
			],
			"Invalid host and device: Person" => [
				"Person",
				false,
			],
		];
	}

	/**
	 * @covers \Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory::BuildFromObject
	 * @dataProvider providerBuildFromObject
	 *
	 * @param string $sObjClass
	 * @param array $aObjData
	 *
	 * @return void
	 * @throws \CoreException
	 */
	public function testBuildFromObject(string $sObjClass, array $aObjData, string $sObjType)
	{
		$oObject = MetaModel::NewObject($sObjClass, $aObjData);
		$oDatacenterView = DatacenterViewFactory::BuildFromObject($oObject);

		// Test that factory returned a well-formed DCV by checking its object class
		$this->assertSame($sObjClass, $oDatacenterView->GetObjectClass());
		$this->assertSame($sObjType, $oDatacenterView->GetType());
	}

	public function providerBuildFromObject(): array
	{
		return [
			'Rack object' => [
				'Rack',
				[
					'name' => 'Rack for tests',
					'org_id' => '3',
					'nb_u' => 42,
				],
				'rack',
			],
			'Enclosure object' => [
				'Enclosure',
				[
					'name' => 'Enclosure for tests',
					'org_id' => '3',
					'nb_u' => 6,
				],
				'enclosure',
			],
			'device object' => [
				'Server',
				[
					'name' => 'Server for tests',
					'org_id' => '3',
					'nb_u' => 2,
				],
				'device',
			],
		];
	}
}