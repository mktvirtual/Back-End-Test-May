<?php
namespace Mkt;
use \Facebook;
use \Mkt\db;




class Face{

  public $usuario; //getUser();
  public $url;      //Url para Login/Logout
  public $facebook; //Objeto Facebook
  public $banco;  //Conexão com o BD
  private $appId = "753899488013895"; //APPID
  private $secret = "8f43ef3b0494e717c447def9e903a00d"; //Secret APP

  public function __construct(){
  //Parametros para conexão com o Facebook;
  $this->facebook = new Facebook(array(
  'appId'  => $this->appId,
  'secret' => $this->secret,
  'cookie' => true, ));
  $this->isLogado();
  
  }


  public function isLogado(){
    $this->usuario = $this->facebook->getUser();
    return $this->usuario;

  }

  public function Url(){
      
    if($this->usuario){
        $this->url  = "sair.php";
    }else{
        $this->url = $this->facebook->getLoginUrl(array(
    'scope'   => 'email',));
    }
      return $this->url;
  }



  //Resgatar Informações do Usuário;
  public function infoUser(){
  if ($this->usuario) {
    try {
    $this->usuario = $this->facebook->api('/me');

    $banco = new db();
    $verificarUser = $banco->getLinha("SELECT * FROM usuarios  WHERE cd_uid =?", array($this->usuario['id']));
    if(!$verificarUser){
       $insertrow = $banco->insertRegistro("INSERT INTO usuarios (nm_usuario, nm_email, cd_uid) VALUES (?, ?,?)", array($this->usuario["name"], $this->usuario["email"],$this->usuario["id"]));
    }
    
    } catch (FacebookApiException $e) {
    //error_log($e);
    $this->usuario = null;
      }
  }

  return $this->usuario;


  }

 public function sair(){

  session_destroy();  

 }



}
