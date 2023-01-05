<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

require_once('PriceLinkClient.php');
require_once('Test.php');

$priceLinkClient = new PriceLink\PriceLinkClient();
$priceLinkTest = new PriceLink\Test();

// Test Domestic PriceLink Request
// Create XML for request
$priceLinkRequest = new PriceLink\PriceLinkRequest();
$priceLinkRequest = $priceLinkTest->createTestPriceLinkObject($priceLinkRequest, "true");
$domesticRateRequest = $priceLinkClient->createXMLRequest($priceLinkRequest);
echo '<div><strong>Domestic XML Rate Request:</strong></div>';
echo '<div><xmp>' . $domesticRateRequest . '</xmp></div>';

// Send XML request
$domesticRateResponse= $priceLinkClient->sendToHost('post', $domesticRateRequest);
echo '<div><strong>Domestic XML Rate Response:</strong></div>';
echo '<div><xmp>' . $domesticRateResponse . '</xmp></div>';

// Pretty Print XML request using domesticresponse.xsl
$pos1 = stripos($domesticRateResponse, '<');
$domesticRateResponse = substr($domesticRateResponse,$pos1);
$xmldoc = DOMDocument::loadXML($domesticRateResponse);
$xsldoc = new DOMDocument();
$xsldoc->load('domesticresponse.xsl');
$proc = new XSLTProcessor();
$proc->registerPHPFunctions();
$proc->importStyleSheet($xsldoc);
echo '<div><strong>Domestic Rate Response Pretty Print:</strong></div>';
echo $proc->transformToXML($xmldoc);

// Test International PriceLink Request
// Create XML for request
$priceLinkRequest = new PriceLink\PriceLinkRequest();
$priceLinkRequest = $priceLinkTest->createTestPriceLinkObject($priceLinkRequest, false);
$internationalRateRequest = $priceLinkClient->createXMLRequest($priceLinkRequest);
echo '<div><strong>International XML Rate Request:</strong></div>';
echo '<div><xmp>' . $internationalRateRequest . '</xmp></div>';

// Send XML request
$internationalRateResponse= $priceLinkClient->sendToHost('post', $internationalRateRequest);
echo '<div><strong>International XML Rate Response:</strong></div>';
echo '<div><xmp>' . $internationalRateResponse . '</xmp></div>';

// Pretty Print XML request using internationalresponse.xsl
$pos1 = stripos($internationalRateResponse, '<');
$internationalRateResponse = substr($internationalRateResponse,$pos1);
$xmldoc = DOMDocument::loadXML($internationalRateResponse);
$xsldoc = new DOMDocument();
$xsldoc->load('internationalresponse.xsl');
$proc = new XSLTProcessor();
$proc->registerPHPFunctions();
$proc->importStyleSheet($xsldoc);
echo '<div><strong>International Rate Response Pretty Print:</strong></div>';
echo $proc->transformToXML($xmldoc);
