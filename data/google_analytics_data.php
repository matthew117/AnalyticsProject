<?php

set_include_path(get_include_path() . PATH_SEPARATOR . './lib/google-api-php-client/src');
require_once "./lib/google-api-php-client/src/Google_Client.php";
require_once "./lib/google-api-php-client/src/contrib/Google_AnalyticsService.php";

function getGoogleAnalyticsData($startDate, $endDate, $url = '/')
{  
  $client = new Google_Client();
  $client->setApplicationName('Durham University Google Analytics Service');

  // set assertion credentials
  $client->setAssertionCredentials(
          new Google_AssertionCredentials(
          // Developer Email
          '1062074655622-mf98un757jtdhogcjvedlipb399gg1lr@developer.gserviceaccount.com',
          // Read Only
          array('https://www.googleapis.com/auth/analytics.readonly'),
          // Path to KeyFile
          file_get_contents("./a45f9a991e573750854db03e71033d6cfaad1609-privatekey.p12")
  ));

  // from API console
  $client->setClientId('1062074655622-mf98un757jtdhogcjvedlipb399gg1lr.apps.googleusercontent.com');
  $client->setAccessType('offline_access');

  // create service and get data
  $service = new Google_AnalyticsService($client);
  $optParams = array(
        'dimensions' => 'ga:city',
        'sort' => '-ga:pageviews',
        'filters' => 'ga:country==United Kingdom;ga:city!=(not set);ga:pagePath==' . $url);
  $x = $service->data_ga->get('ga:7685379', $startDate, $endDate, 'ga:pageviews', $optParams);
  return json_encode($x);
}
?>