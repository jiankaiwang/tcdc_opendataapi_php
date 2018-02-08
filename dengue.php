<?php

function fetchDengueYearDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "dengue", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select year, sum(dengueval) as dengueval from dengue where year in (select * from (select year from dengue group by year order by year desc limit 6) as yLs) group by year order by year asc;",
    True,
    array()
  );

  if($getRes["state"] == "success") {
    return $getRes["data"];
  } else {
    return array();
  }
}

function fetchDengueMonthDataInJson() {
  global $mysqlhost, $mysqlport, $mysqluser, $mysqlpass, $mysqldb;

  $obj = new PHP2MySQL($mysqlhost, $mysqlport, $mysqldb, "dengue", $mysqluser, $mysqlpass);

  $getRes = $obj -> execsql(
    "select * from dengue where year in (select * from (select year from dengue group by year order by year desc limit 4) as yLs) order by year asc, month asc;",
    True,
    array()
  );

  if($getRes["state"] == "success") {
    return $getRes["data"];
  } else {
    return array();
  }
}

# array data to desired format
function Array2CSV($data,$format) {
  $output = ["year","month","dengueval"];
  $split = ($format == "csv" ? "," : "\t");
  echo join($split, $output)."\n";
  for($i = 0 ; $i < count($data); $i++) {
    $output = [$data[$i]["year"], $data[$i]["month"], $data[$i]["dengueval"]];
    echo join($split, $output)."\n";
  }
}

# output as json
switch($_GET['v']) {
  default:
  case "a1":
    header('Content-Type: application/json');
    echo json_encode(fetchDengueYearDataInJson());
    break;
  case "a2":
    header('Content-Type: application/json');
    echo json_encode(fetchDengueMonthDataInJson());
    break;
  case "dev1":
    if(array_key_exists("f",$_GET)) {
      switch(strtolower($_GET["f"])) {
        default:
        case "json":
          header('Content-Type: application/json');
          echo json_encode(fetchDengueMonthDataInJson());
          break;
        case "csv":
        case "txt":
          header('Content-Type: text/txt');
          echo Array2CSV(fetchDengueMonthDataInJson(), strtolower($_GET["f"]));
          break;
      }
    } else {
      header('Content-Type: application/json');
      echo json_encode(fetchDengueMonthDataInJson());
    }
    break;
}


?>
