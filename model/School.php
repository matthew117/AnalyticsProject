<?php
/**
 * Represents a school and its related data.
 *
 * @author Matthew Bates
 */
class School
{
  /** A unique identifier for this school */
  private $id;
  private $name;
  private $email;
  private $websiteURL;
  private $address1;
  private $address2;
  private $town;
  private $postcode;
  private $latitude;
  private $longitude;
  private $specialism;
  
  public function getID() {
    return $this->id;
  }

  public function setID($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getWebsiteURL() {
    return $this->websiteURL;
  }

  public function setWebsiteURL($websiteURL) {
    $this->websiteURL = $websiteURL;
  }

  public function getAddress1() {
    return $this->address1;
  }

  public function setAddress1($address1) {
    $this->address1 = $address1;
  }

  public function getAddress2() {
    return $this->address2;
  }

  public function setAddress2($address2) {
    $this->address2 = $address2;
  }

  public function getTown() {
    return $this->town;
  }

  public function setTown($town) {
    $this->town = $town;
  }

  public function getPostcode() {
    return $this->postcode;
  }

  public function setPostcode($postcode) {
    $this->postcode = $postcode;
  }

  public function getLatitude() {
    return $this->latitude;
  }

  public function setLatitude($latitude) {
    $this->latitude = $latitude;
  }

  public function getLongitude() {
    return $this->longitude;
  }

  public function setLongitude($longitude) {
    $this->longitude = $longitude;
  }

  public function getSpecialism() {
    return $this->specialism;
  }

  public function setSpecialism($specialism) {
    $this->specialism = $specialism;
  }
  
}
?>
