<!DOCTYPE html>
<html>
  <head>
    <title>Analytics Project</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/index.css">
  </head>
  <body>
    <div id="content">
      <div id="cities">

        <?php
        require_once 'model/School.php';
        require_once 'model/City.php';

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

        $ga_data_str = file_get_contents('data/ga_data.json');
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

        foreach ($cities as $city)
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
        ?>
      </div>
    </div>
  </body>
</html>