<?php

function fetchDiaDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "influlinechart", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select * from diarrheapiechart where year in (select * from (select year from diarrheapiechart group by year order by year desc limit 1) as yLs) order by year;",
    True,
    array()
  );

  if($getRes["state"] == "success") {
    return $getRes["data"];
  } else {
    return array();
  }
}

# output as json
switch($_GET['v']) {
  default:
  case "a1":
    header('Content-Type: application/json');
    echo json_encode(fetchDiaDataInJson());
    break;
}

?>
