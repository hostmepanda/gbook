<?

include(__DIR__."/../../../php/gbClass.php");

$gb=new gb();

$json=json_decode(file_get_contents('php://input'),false);

$methods=[
  "getRecords"=>"selectPage",
  "putRecord"=>"addRecord",
];

if(!isset($json->action) || empty($json->action)){
  die(json_encode(["code"=>500]));
}

if(isset($methods[$json->action])){
  // echo "calling".$methods[$json->action];
  exit($gb->api($methods[$json->action],$json));
}else{
  die(json_encode(["code"=>500]));
}


// if($q=$gb->selectPage()){
//
//   exit(json_encode(["code"=>200,"rt"=>$q]));
// }
//
//
// exit(json_encode(["code"=>200,"rt"=>[]]));


?>
