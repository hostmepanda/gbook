<?

class gb{

  var $db;

  function __construct() {
    $this->db=new mysqli("localhost","*","*","gb");
    $this->db->query("SET CHARACTER SET utf8");
  }

  function selectPage($arr){
    // print_r($arr);

    $step=10;
    $start=0;


    if(!empty($arr)){
      if($arr->start-1>0){
        $start=$arr->start-1;
      }else{
        $start=0;

      }
    }





    if(!is_int($start)){
      return false;
    }
    if(!is_int($step)){
      return false;
    }
    // echo "SELECT * FROM `gb_records` ORDER BY `id` DESC LIMIT $step OFFSET ".(int)($start*$step)." ;";
    if($dbq=$this->db->query("SELECT * FROM `gb_records` ORDER BY `id` DESC LIMIT $step OFFSET ".(int)($start*$step)." ;")){
      if($dbq->num_rows>0){
        while($rec=$dbq->fetch_assoc()){
          $recSet[]=$rec;
        }
        $q=$this->db->query("SELECT count(`id`) AS `total` FROM `gb_records` ;");
        $overall=$q->fetch_assoc()["total"];
        return ["records"=>$recSet,"overall"=>$overall];
      }else{
        // echo "null";
      }
    }
    return false;
  }

  function addRecord($arr){
    $name=$arr->name;
    $age=abs((int)$arr->age);
    if($age>99){
      return false;
    }
    $mes=$arr->mes;

    if(empty($name) || empty($age) || empty($mes)){
      return false;
    }

    $escapedNm=$this->db->escape_string($name);
    $escapedMes=$this->db->escape_string($mes);

    if($this->db->query("INSERT INTO `gb_records` (`name`,`old`,`mes`) VALUES ('$name','$age','$mes')")===TRUE){
      return $this->selectPage([]);
    }

    return false;

  }

  function api($apiMet,$arr=null){

    $res=$this->$apiMet($arr);
    // print_r($res);
    return(json_encode(["code"=>200,"rt"=>!empty($res)?$res:[]]));
  }


}

?>
