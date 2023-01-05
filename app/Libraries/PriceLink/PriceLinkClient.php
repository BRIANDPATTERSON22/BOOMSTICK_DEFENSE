<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

namespace PriceLink;

include('PriceLinkRequest.php');
include('ServiceLevels.php');
include('RequestFees.php');
include('ResponseFees.php');
include('Package.php');
include('PackageTypes.php');

class PriceLinkClient {

	/**
	 * Create the XML request.
	 *
	 * @param PriceLinkRequest $priceLinkRequest
	 * @return string
	 */
	function createXMLRequest(PriceLinkRequest $priceLinkRequest) {
		// create the xml request
		$xmlParams = <<<XMLRequest
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

XMLRequest;
		if ($priceLinkRequest->getReceiverCountry() == "US" || $priceLinkRequest->getReceiverCountry() == "PR") {
			$xmlParams .= <<<XMLRequest
<unishippersdomesticmultipieceraterequest>

XMLRequest;

		} else {
			$xmlParams .= <<<XMLRequest
<unishippersinternationalmultipieceraterequest>

XMLRequest;

		}
		$xmlParams .= <<<XMLRequest
	<requestkey>$priceLinkRequest->requestKey</requestkey>
	<username>$priceLinkRequest->username</username>
	<password>$priceLinkRequest->password</password>
	<upsaccountnumber>$priceLinkRequest->upsAccountNumber</upsaccountnumber>
	<unishipperscustomernumber>$priceLinkRequest->unishippersCustomerNumber</unishipperscustomernumber>
	<service>$priceLinkRequest->serviceLevel</service>
	<shipdate>$priceLinkRequest->shipDate</shipdate>
	<senderstate>$priceLinkRequest->senderState</senderstate>
	<sendercountry>$priceLinkRequest->senderCountry</sendercountry>
	<senderzip>$priceLinkRequest->senderZip</senderzip>
	<receiverstate>$priceLinkRequest->receiverState</receiverstate>
	<receivercountry>$priceLinkRequest->receiverCountry</receivercountry>
	<receiverzip>$priceLinkRequest->receiverZip</receiverzip>

XMLRequest;
		if ($priceLinkRequest->getCustomsAmount()) {
			$xmlParams .= <<<XMLRequest
	<customsamount>$priceLinkRequest->customsAmount</customsamount>

XMLRequest;
		}
		$xmlParams .= <<<XMLRequest
	<fees>

XMLRequest;
		foreach ($priceLinkRequest->getFees() as $fee) {
			$xmlParams .= <<<XMLRequest
		<fee>$fee</fee>

XMLRequest;
		}
		$xmlParams .= <<<XMLRequest
	</fees>
	<packages>

XMLRequest;
		/* @var Package $package */
		foreach ($priceLinkRequest->getPackages() as $package) {
			$xmlParams .= <<<XMLRequest
		<package>
			<weight>$package->weight</weight>
			<length>$package->length</length>
			<width>$package->width</width>
			<height>$package->height</height>
			<packagetype>$package->packageType</packagetype>

XMLRequest;
			if ($package->getDeclaredValue()) {
				$xmlParams .= <<<XMLRequest
			<declaredvalue>$package->declaredValue</declaredvalue>

XMLRequest;
			}
			if ($package->getCod()) {
				$xmlParams .= <<<XMLRequest
			<cod>$package->cod</cod>

XMLRequest;
			}
			$xmlParams .= <<<XMLRequest
		</package>

XMLRequest;

		}

		$xmlParams .= <<<XMLRequest
	</packages>

XMLRequest;
		if ($priceLinkRequest->getReceiverCountry() == "US" || $priceLinkRequest->getReceiverCountry() == "PR") {
			$xmlParams .= <<<XMLRequest
</unishippersdomesticmultipieceraterequest>

XMLRequest;

		} else {
			$xmlParams .= <<<XMLRequest
</unishippersinternationalmultipieceraterequest>

XMLRequest;

		}

		return $xmlParams;
	}

	/**
	 * Send to XML request to PriceLink.
	 *
	 * @param $method
	 * @param $data
	 * @param int $useragent
	 * @return string
	 */
	function sendToHost($method, $data, $useragent=0)	{

		$host = 'uone-price.unishippers.com';
		$path = '/price/pricelink';

		// Supply a default method of GET if the one passed was empty
		if (empty($method)) {
			$method = 'GET';
		}
		$method = strtoupper($method);
		$fp = fsockopen($host, 80);
		if ($method == 'GET') {
			$path .= '?' . $data;
		}
		fputs($fp, "$method $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp,"Content-type: application/x-www-form- urlencoded\r\n");
		fputs($fp, "Content-length: " . strlen($data) . "\r\n");
		if ($useragent) {
			fputs($fp, "User-Agent: MSIE\r\n");
		}
		fputs($fp, "Connection: close\r\n\r\n");
		if ($method == 'POST') {
			fputs($fp, $data);
		}

		$buf = "";
		while (!feof($fp)) {
			$buf .= fgets($fp,128);
		}
		fclose($fp);
		return $buf;
	}
}
