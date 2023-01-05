<?php
/**
Unishippers PriceLink API - Sample Code

Copyright 2019, Unishippers Global Logistics, LLC.

Modification and use of this file is governed by the terms
outlined in the LICENSE file which is included in this
software distribution.
*/

namespace PriceLink;

class PriceLinkRequest {

	public $url;
	public $requestKey;
	public $username;
	public $password;
	public $upsAccountNumber;
	public $unishippersCustomerNumber;
	public $shipDate;
	public $senderState;
	public $senderCountry;
	public $senderZip;
	public $receiverState;
	public $receiverCountry;
	public $receiverZip;
	public $serviceLevel;
	public $customsAmount;
	public $fees = [];
	public $packages = [];

	/**
	 * @return mixed
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param mixed $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return mixed
	 */
	public function getRequestKey() {
		return $this->requestKey;
	}

	/**
	 * @param mixed $requestKey
	 */
	public function setRequestKey($requestKey) {
		$this->requestKey = $requestKey;
	}

	/**
	 * @return mixed
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getUpsAccountNumber() {
		return $this->upsAccountNumber;
	}

	/**
	 * @param mixed $upsAccountNumber
	 */
	public function setUpsAccountNumber($upsAccountNumber) {
		$this->upsAccountNumber = $upsAccountNumber;
	}

	/**
	 * @return mixed
	 */
	public function getUnishippersCustomerNumber() {
		return $this->unishippersCustomerNumber;
	}

	/**
	 * @param mixed $unishippersCustomerNumber
	 */
	public function setUnishippersCustomerNumber($unishippersCustomerNumber) {
		$this->unishippersCustomerNumber = $unishippersCustomerNumber;
	}

	/**
	 * @return mixed
	 */
	public function getShipDate() {
		return $this->shipDate;
	}

	/**
	 * @param mixed $shipDate
	 */
	public function setShipDate($shipDate) {
		$this->shipDate = $shipDate;
	}

	/**
	 * @return mixed
	 */
	public function getSenderState() {
		return $this->senderState;
	}

	/**
	 * @param mixed $senderState
	 */
	public function setSenderState($senderState) {
		$this->senderState = $senderState;
	}

	/**
	 * @return mixed
	 */
	public function getSenderCountry() {
		return $this->senderCountry;
	}

	/**
	 * @param mixed $senderCountry
	 */
	public function setSenderCountry($senderCountry) {
		$this->senderCountry = $senderCountry;
	}

	/**
	 * @return mixed
	 */
	public function getSenderZip() {
		return $this->senderZip;
	}

	/**
	 * @param mixed $senderZip
	 */
	public function setSenderZip($senderZip) {
		$this->senderZip = $senderZip;
	}

	/**
	 * @return mixed
	 */
	public function getReceiverState() {
		return $this->receiverState;
	}

	/**
	 * @param mixed $receiverState
	 */
	public function setReceiverState($receiverState) {
		$this->receiverState = $receiverState;
	}

	/**
	 * @return mixed
	 */
	public function getReceiverCountry() {
		return $this->receiverCountry;
	}

	/**
	 * @param mixed $receiverCountry
	 */
	public function setReceiverCountry($receiverCountry) {
		$this->receiverCountry = $receiverCountry;
	}

	/**
	 * @return mixed
	 */
	public function getReceiverZip() {
		return $this->receiverZip;
	}

	/**
	 * @param mixed $receiverZip
	 */
	public function setReceiverZip($receiverZip) {
		$this->receiverZip = $receiverZip;
	}

	/**
	 * @return mixed
	 */
	public function getServiceLevel() {
		return $this->serviceLevel;
	}

	/**
	 * @param mixed $serviceLevel
	 */
	public function setServiceLevel($serviceLevel) {
		$this->serviceLevel = $serviceLevel;
	}

	/**
	 * @return mixed
	 */
	public function getCustomsAmount() {
		return round($this->customsAmount, 2, PHP_ROUND_HALF_UP);
	}

	/**
	 * @param mixed $customsAmount
	 */
	public function setCustomsAmount($customsAmount) {
		$this->customsAmount = $customsAmount;
	}

	/**
	 * @return array
	 */
	public function getFees(): array {
		return $this->fees;
	}

	/**
	 * @param array $fees
	 */
	public function setFees(array $fees) {
		$this->fees = $fees;
	}

	/**
	 * @return array
	 */
	public function getPackages(): array {
		return $this->packages;
	}

	/**
	 * @param array $packages
	 */
	public function setPackages(array $packages) {
		$this->packages = $packages;
	}
}
