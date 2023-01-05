<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

namespace PriceLink;

abstract class ServiceLevels {

	const ALL = "ALL";

	// Domestic
	const UPS_NEXT_DAY_AIR = "ND";
	const UPS_NEXT_DAY_AIR_SAVER = "ND4";
	const UPS_NEXT_DAY_AIR_EARLY_AM = "ND5";
	const UPS_2ND_DAY_AIR = "SC";
	const UPS_2ND_DAY_AIR_AM = "SC25";
	const UPS_3_DAY_SELECT = "SC3";
	const UPS_GROUND = "SG";
	const SATURDAY_UPS_NEXT_DAY_AIR = "SND"; // This service code is for convenience and is not an actual UPS service code. Saturday Delivery is considered an accessorial on top of the normal ND services and will return in the response as such.
	const SATURDAY_UPS_NEXT_DAY_AIR_EARLY_AM = "SND5"; // This service code is for convenience and is not an actual UPS service code. Saturday Delivery is considered an accessorial on top of the normal ND5 services and will return in the response as such.
	const SATURDAY_UPS_2ND_DAY_AIR = "SSC"; // This service code is for convenience and is not an actual UPS service code. Saturday Delivery is considered an accessorial on top of the normal SSC services and will return in the response as such.

	// International
	const WORLDWIDE_EXPRESS = "ZZ1";
	const WORLDWIDE_EXPEDITED = "ZZ2";
	const WORLDWIDE_SAVER = "ZZ90";
	const STANDARD_CANADA = "ZZ11";
}
