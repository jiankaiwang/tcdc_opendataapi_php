<?php

function fetchHIVDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "hivbc", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select * from hivbc where year in (select * from (select year from hivbc group by year order by year desc limit 12) as yLs) order by year asc, age asc;",
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
    echo json_encode(fetchHIVDataInJson());
    break;
}

?>
