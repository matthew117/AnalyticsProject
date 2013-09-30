<?php
/**
 * Holds the number of hits from a particular city and a list of schools in that city.
 *
 * @author Matthew Bates
 */
class City
{
  /** The name of the city */
  private $name;
  /** The number of web hits from this particular city */
  private $visits;
  /** A list of schools situated in this city */
  private $schools;
  
  function __construct()
  {
    $this->schools = array();
  }
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setName($name)
  {
    $this->name = $name;
  }
  
  public function getVisits()
  {
    return $this->visits;
  }
  
  public function setVisits($visits)
  {
    $this->visits = $visits;
  }
  
  public function getSchools()
  {
    return $this->schools;
  }
  
  public function setSchools($schools)
  {
    $this->schools = $schools;
  }
  
}
?>
