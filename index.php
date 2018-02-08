<?php
header('Access-Control-Allow-Origin: *');

require("PHP2MySQL.php");
require("config.php");

switch($_GET['s']) {
  case "enterovirus":
    require("enterovirus.php");
    break;
  case "influlinechart":
    require("influlinechart.php");
    break;
  case "diarrheapiechart":
    require("diarrheapiechart.php");
    break;
  case "hivbc":
    require("hivbc.php");
    break;
  case "dengue":
    require("dengue.php");
    break;
  default:
    header('Content-Type: application/json');
    $output = array("meta" => "Welcome to Taiwan CDC Open Data API Service.", 
                    "message" => "Please refer to the portal https://data.cdc.gov.tw/.");
    echo json_encode($output);
    break;
}
?>
