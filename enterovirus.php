<?php

function fetchEVDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "enterovirus", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select rawdata.* from (select * from enterovirus where coxsackie > -1 order by yearweek desc limit 8) as rawdata order by yearweek asc;",
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
    echo json_encode(fetchEVDataInJson());
    break;
}

?>
