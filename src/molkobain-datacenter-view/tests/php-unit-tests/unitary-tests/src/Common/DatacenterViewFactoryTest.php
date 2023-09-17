<?php
/*
 * Copyright (c) 2015 - 2023 Molkobain.
 *
 * This file is part of licensed extension.
 *
 * Use of this extension is bound by the license you purchased. A license grants you a non-exclusive and non-transferable right to use and incorporate the item in your personal or commercial projects. There are several licenses available (see https://www.molkobain.com/usage-licenses/ for more informations)
 */

namespace Molkobain\iTop\Extension\DatacenterView\Tests\PHPUnitTests\UnitaryTests\Common;

use MetaModel;
use Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory;
use Combodo\iTop\Test\UnitTest\ItopDataTestCase;

/**
 * @covers \Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory
 */
class DatacenterViewFactoryTest extends ItopDataTestCase
{
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

	/**
	 * @covers \Molkobain\iTop\Extension\DatacenterView\Common\DatacenterViewFactory::RegisterClass
	 * @dataProvider providerRegisterClass
	 *
	 * @param string $sClass
	 * @param bool $bShouldWork
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function testRegisterClass(string $sClass, bool $bShouldWork)
	{
		// In case of a wrong class, exception should be raised
		if (false === $bShouldWork) {
			$this->expectException('Exception');
		}
		DatacenterViewFactory::RegisterClass($sClass);

		// Otherwise, it's all good, no assertion needed
		$this->expectNotToPerformAssertions();
	}

	public function providerRegisterClass(): array
	{
		return [
			'Existing class' => ['Molkobain\\iTop\\Extension\\DatacenterView\\Common\\DatacenterView', true],
			'None existing class' => ['Foo\\Bar\\Something', false],
		];
	}
}