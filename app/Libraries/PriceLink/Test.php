<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

namespace PriceLink;

class Test {

	/**
	 * Creates a PriceLink test object to test Unishippers PriceLink.
	 *
	 * @param PriceLinkRequest $priceLinkRequest
	 * @param $isDomestic
	 * @return PriceLinkRequest $priceLinkRequest
	 */
	function createTestPriceLinkObject($priceLinkRequest, $isDomestic) {

		$priceLinkRequest->setRequestKey("CreateXMLRequest test");
		$priceLinkRequest->setUsername("testups");
		$priceLinkRequest->setPassword("testups");
		$priceLinkRequest->setUpsAccountNumber("123UPS");
		$priceLinkRequest->setUnishippersCustomerNumber("U1236822371");
		$priceLinkRequest->setServiceLevel(ServiceLevels::ALL);
		$priceLinkRequest->setShipDate("2020-01-01");

		$priceLinkRequest->setSenderState("UT");
		$priceLinkRequest->setSenderCountry("US");
		$priceLinkRequest->setSenderZip("84047");

		if ($isDomestic) {
			$priceLinkRequest->setReceiverState("UT");
			$priceLinkRequest->setReceiverCountry("US");
			$priceLinkRequest->setReceiverZip("84047");
		} else {
			$priceLinkRequest->setReceiverState("AB");
			$priceLinkRequest->setReceiverCountry("CA");
			$priceLinkRequest->setReceiverZip("T2G3C3");
			$priceLinkRequest->setCustomsAmount("200.14");
		}

		// Fees
		$fees = [];
		array_push($fees, RequestFees::DELIVERY_IS_TO_A_RESIDENTIAL_ADDRESS);
		array_push($fees, RequestFees::SIGNATURE_REQUIRED);
		$priceLinkRequest->setFees($fees);

		// Packages
		$packages = [];

		$package1 = new Package();
		$package1->setWeight(15);
		$package1->setLength(15);
		$package1->setWidth(10);
		$package1->setHeight(5);
		$package1->setPackageType(PackageTypes::PACKAGE);
		$package1->setDeclaredValue(100);
		if ($priceLinkRequest->getReceiverCountry() == "US") {
			$package1->setCod(100); // COD not allowed on International shipments
		}
		array_push($packages, $package1);

		$package2 = new Package();
		$package2->setWeight(1);
		$package2->setLength(13);
		$package2->setWidth(10);
		$package2->setHeight(1);
		$package2->setPackageType(PackageTypes::LETTER);
		array_push($packages, $package2);
		$priceLinkRequest->setPackages($packages);

		return $priceLinkRequest;
	}
}
