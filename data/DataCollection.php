<?php

function getData($startDate, $endDate, $url)
{
  require_once 'model/School.php';
  require_once 'model/City.php';
  require_once 'data/google_analytics_data.php';
  
  $now = getdate();
  
  if (!isset($startDate) || strlen($startDate) < 10) $startDate = $now['year'] . '-' . ($now['mon'] > 9 ? $now['mon'] : '0'.$now['mon']) . '-' . ($now['mday'] > 9 ? $now['mday'] : '0'.$now['mday']);
  if (!isset($endDate) || strlen($endDate) < 10) $endDate = $now['year'] . '-' . ($now['mon'] > 9 ? $now['mon'] : '0'.$now['mon']) . '-' . ($now['mday'] > 9 ? $now['mday'] : '0'.$now['mday']);

  $schools = array();

  // Read school data
  $file_handle = fopen("data/school_data.csv", "r");
  $headers = TRUE;
  while (!feof($file_handle))
  {
    $school_data = fgetcsv($file_handle);

    if ($headers)
    {
      $headers = FALSE;
      continue;
    }

    $school = new School();
    $school->setID($school_data[0]);
    $school->setName($school_data[1]);
    $school->setEmail($school_data[2]);
    $school->setAddress1($school_data[3]);
    $school->setAddress2($school_data[4]);
    $school->setTown(str_replace('-', ' ', $school_data[5]));
    $school->setPostcode($school_data[6]);
    $school->setLatitude($school_data[7]);
    $school->setLongitude($school_data[8]);
    $school->setWebsiteURL($school_data[9]);
    $school->setSpecialism(preg_replace('/ \(.*\)/', '', $school_data[10]));

    if (array_key_exists($school->getTown(), $schools))
    {
      array_push($schools[$school->getTown()], $school);
    }
    else
    {
      $school_array = array();
      array_push($school_array, $school);
      $schools[$school->getTown()] = $school_array;
    }
  }
  fclose($file_handle);

  $cities = array();

  $ga_data_str = getGoogleAnalyticsData($startDate, $endDate, $url);
  $ga_data = json_decode($ga_data_str);

  for ($i = 0; $i < count($ga_data->rows); $i++)
  {
    $city = new City();
    $city->setName(str_replace('-', ' ', $ga_data->rows[$i][0]));
    $city->setVisits($ga_data->rows[$i][1]);
    if (array_key_exists($city->getName(), $schools))
    {
      $city->setSchools($schools[$city->getName()]);
    }
    array_push($cities, $city);
  }

  return $cities;
}

?>
