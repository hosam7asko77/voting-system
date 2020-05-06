<?php
class VoterService{
  private $con;
function __construct()
{
   require_once dirname(__FILE__).'/../include/DBConnect.php';
   $db=new DBConnect;
   $this->con=$db->connect();
}
public function voterRegister($name, $email, $dob, $gender, $adhaar)
{
if(!$this->isAdhaarExist($adhaar)){
  $status=false;
  $publicId=$this->generatePublicId();
  $sql=$this->con->prepare("INSERT INTO voter_data(v_name, v_email, v_dob, v_gender, v_adhaar, v_status, v_public_id)
  VALUES(?,?,?,?,?,?,?)");
  $sql->bind_param("sssssss",$name, $email, $dob, $gender, $adhaar,$status,$publicId);
  if($sql->execute()){
    return 201;
  }else {
    return 500;
  }
}else {
    return 401;
}
}
public function voterLogin($value='')
{
  // code...
}
public function isAdhaarExist($adhaar){
  $sql=$this->con->prepare("SELECT * FROM voter_data WHERE v_adhaar=?");
  $sql->bind_param("s",$adhaar);
  $sql->execute();
  $sql->store_result();
  return $sql->num_rows  > 0;
}
public function generatePublicId()
{
  $publicId = rand();
  return $publicId;
}
}

 ?>
