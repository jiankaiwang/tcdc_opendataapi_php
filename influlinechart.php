<?php

function fetchInfluDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "influlinechart", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select * from influlinechart where year in (select * from (select year from influlinechart group by year order by year desc limit 5) as yLs) order by year, week;",
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
    echo json_encode(fetchInfluDataInJson());
    break;
}

?>
