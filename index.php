<?php 

require_once './data/DataCollection.php';
require_once './data/Formatter.php';

$format = 'html';
if (isset($_GET['format'])) $format = $_GET['format'];
if (isset($_GET['start-date'])) $startDate = $_GET['start-date'];
if (isset($_GET['end-date'])) $endDate = $_GET['end-date'];

$data = getData($startDate, $endDate);

switch ($format)
{
  case 'html': generateHTML($data); break;
  case 'csv' : generateCSV($data);  break;
  case 'json': generateJSON($data); break;
  case 'xml' : generateXML($data);  break;
}

?>