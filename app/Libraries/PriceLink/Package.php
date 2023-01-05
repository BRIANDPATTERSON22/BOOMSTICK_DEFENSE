<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2007-2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
 */

namespace PriceLink;

class Package {

	public $weight = 0;
	public $length = 0;
	public $width = 0;
	public $height = 0;
	public $packageType;
	public $declaredValue;
	public $cod;

	/**
	 * @return int
	 */
	public function getWeight() : int {
		return $this->weight;
	}

	/**
	 * @param $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
	}

	/**
	 * @return int
	 */
	public function getLength() : int{
		return $this->length;
	}

	/**
	 * @param mixed $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @return int
	 */
	public function getWidth() : int {
		return $this->width;
	}

	/**
	 * @param mixed $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * @return int
	 */
	public function getHeight() : int {
		return $this->height;
	}

	/**
	 * @param mixed $height
	 */
	public function setHeight($height) {
		$this->height = $height;
	}

	/**
	 * @return mixed
	 */
	public function getPackageType() {
		return $this->packageType;
	}

	/**
	 * @param mixed $packageType
	 */
	public function setPackageType($packageType) {
		$this->packageType = $packageType;
	}

	/**
	 * @return mixed
	 */
	public function getDeclaredValue() {
		return round($this->declaredValue, 2, PHP_ROUND_HALF_UP);
	}

	/**
	 * @param mixed $declaredValue
	 */
	public function setDeclaredValue($declaredValue) {
		$this->declaredValue = $declaredValue;
	}

	/**
	 * @return mixed
	 */
	public function getCod() {
		return $this->cod;
	}

	/**
	 * @param mixed $cod
	 */
	public function setCod($cod) {
		$this->cod = $cod;
	}
}
