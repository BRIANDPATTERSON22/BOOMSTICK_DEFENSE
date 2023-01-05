<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

namespace PriceLink;

abstract class ResponseFees {

	const FREIGHT_CHARGE_ESTIMATE = "400";
	const FUEL_SURCHARGE_ESTIMATE = "FUE";
	const RESIDENTIAL_DELIVERY_CHARGE = "REP";
	const ADULT_SIGNATURE_REQUIRED_CHARGE = "ADV";
	const SIGNATURE_REQUIRED_CHARGE = "SUR";
	const SATURDAY_SURCHARGE_ESTIMATE = "665";
	const DECLARED_VALUE_CHARGE_ESTIMATE = "EVC";
	const ADDITIONAL_HANDLING = "690";
	const ADDITIONAL_HANDLING_OVER_70LB = "690-WT";
	const ADDITIONAL_HANDLING_OVER_DIMENSIONS = "LDG";
	const INSURANCE_DECLARED_VALUE_TIME_IN_TRANSIT = "EVC-TNT";
	const INSURANCE_DECLARED_VALUE_JEWELRY = "EVC-JEW";
}
