<?php

require_once './model/City.php';
require_once './model/School.php';

function generateHTML($data)
{
$text = <<<HTML
<!DOCTYPE html>
<html>
  <head>
    <title>Analytics Project</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/index.css">
  </head>
  <body>
    <div id="content">
      <div id="query-ui">
        <div id="query-banner">
          <span class="city-name">Query</span>
          <ul>
            <li><a type="text/csv" href="./?format=csv">csv</a></li>
            <li><a type="application/json" href="./?format=json">json</a></li>
            <li><a type="application/xml" href="./?format=xml">xml</a></li>
          </ul>
        </div>
        <form action=".">
        <table>
          <tr><td>Time</td><td><input type="date" name="start-date"></td><td><input type="date" name="end-date"></td></tr>
        </table>
        <input type="submit" value="Submit" />
        </form>
      </div>
      <div id="cities">
HTML;
       
print($text);

        foreach ($data as $city)
        {
          print('<div class="city">' . "\n");
          print('<div class="city-banner">');
          printf('<div class="city-name">%s</div><div class="visit-count"><img class="icon-left" src="img/visits_white_16px.png"/>%s</div>' . "\n", $city->getName(), number_format($city->getVisits()));
          print('</div>');
          print('<div class="schools">' . "\n");

          foreach ($city->getSchools() as $school)
          {
            print('<div class="school">' . "\n");
            print('<div class="school-banner">');
            print($school->getName());
            print('</div>');
            print('<table>');
            printf('<tr><td><img src="img/email.png" /></td><td class="table-label">Email</td><td class="table-data"><a href="mailto:%s">%s</a></td></tr>', $school->getEmail(), $school->getEmail());
            if (strlen($school->getWebsiteURL()) > 0)
            {
              printf('<tr><td><img src="img/web.png" /></td><td class="table-label">Website</td><td class="table-data"><a href="%s">%s</a></td></tr>', $school->getWebsiteURL(), $school->getWebsiteURL());
            }
            print('<tr><td><img src="img/address.png" /></td><td class="table-label">Address</td><td class="table-data">');
            printf('%s<br />', $school->getAddress1());
            if (strlen($school->getAddress2()) > 0)
            {
              printf('%s<br />', $school->getAddress2());
            }
            printf('%s<br />', $school->getTown());
            print($school->getPostcode());
            print('</td></tr>');
             if (strlen($school->getSpecialism()) > 0)
            { 
              print('<tr>');
              switch ($school->getSpecialism())
              {
                case 'Arts' : print('<td><img src="img/art.png" /></td>'); break;
                case 'Sports' : print('<td><img src="img/sport.png" /></td>'); break;
                case 'Humanities' : print('<td><img src="img/human.png" /></td>'); break;
                case 'Science' : print('<td><img src="img/science.png" /></td>'); break;
                case 'Business and Enterprise' : print('<td><img src="img/business.png" /></td>'); break;
                case 'Technology' : print('<td><img src="img/technology.png" /></td>'); break;
                case 'Language' : print('<td><img src="img/language.png" /></td>'); break;
                case 'Music' : print('<td><img src="img/music.png" /></td>'); break;
                case 'Maths and Computing' : print('<td><img src="img/computing.png" /></td>'); break;
              }
              printf('<td class="table-label">Specialism</td><td class="table-data">%s</td></tr>', $school->getSpecialism());
            }
            print('</table>');
            print('</div>');
          }

          print('</div>' . "\n");
          print('</div>' . "\n");
        }
        
      print('</div>
    </div>
  </body>
</html>  ');
        
}

function generateCSV($data)
{
  header('Content-type: text/csv');
  
  print('id,name,email,website,address1,address2,city,postcode,specialism,visits' . "\n");
  foreach ($data as $city)
  {
    foreach ($city->getSchools() as $school)
    {
      printf('"%d","%s","%s","%s","%s","%s","%s","%s","%s","%d"',
              $school->getID(),
              $school->getName(),
              $school->getEmail(),
              $school->getWebsiteURL(),
              $school->getAddress1(),
              $school->getAddress2(),
              $school->getTown(),
              $school->getPostcode(),
              $school->getSpecialism(),
              $city->getVisits());
      print("\n");
    }
  }
}

function generateJSON($data)
{
  header('Content-type: application/json');
  
  print('{"cities" : [');
  $first_city = TRUE;
  foreach ($data as $city)
  {
    if (!$first_city)
    {
      print(',');
    }
      
    if ($first_city) $first_city = FALSE;
      
    printf('{"city":"%s","visits":"%d","schools":[', $city->getName(), $city->getVisits());  
      
    $first_school = TRUE;
    foreach ($city->getSchools() as $school)
    {
      if (!$first_school)
      {
        print(',');
      }
      
      if ($first_school) $first_school = FALSE;

      printf('{"id":"%d","name":"%s","email":"%s","website":"%s","address1":"%s","address2":"%s","town":"%s","postcode":"%s","specialism":"%s"}',
            $school->getID(),
            $school->getName(),
            $school->getEmail(),
            $school->getWebsiteURL(),
            $school->getAddress1(),
            $school->getAddress2(),
            $school->getTown(),
            $school->getPostcode(),
            $school->getSpecialism());
    }
    print(']}');
  }
  print(']}');
}

function generateXML($data)
{
  header('Content-type: application/xml');
  
  print('<cities>' . "\n");
  foreach ($data as $city)
  {
    printf('  <city name="%s" visits="%d">', $city->getName(), $city->getVisits());
    print("\n");
    foreach ($city->getSchools() as $school)
    {
      printf('    <school id="%d" name="%s" email="%s" website="%s" address1="%s" address2="%s" town="%s" postcode="%s" specialism="%s" />',
            $school->getID(),
            htmlspecialchars($school->getName(), ENT_QUOTES),
            $school->getEmail(),
            htmlspecialchars($school->getWebsiteURL(), ENT_QUOTES),
            $school->getAddress1(),
            $school->getAddress2(),
            $school->getTown(),
            $school->getPostcode(),
            $school->getSpecialism());
      print("\n");
    }
    print('</city>' . "\n");
  }
  print('</cities>');
}

?>
