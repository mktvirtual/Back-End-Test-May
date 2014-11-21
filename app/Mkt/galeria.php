<?php

namespace Mkt;
use \Mkt\db;
class Galeria {
    
    var $pasta = "";   // caminho de destino da imagem
    var $nome;  // nome da imagem
    var $largura = 750;  // largura limite desejada
    var $altura = 750;  // altura limite desejada
    var $tmp_name;  // nome temporário da imagem
    var $destinot = 'uploads/t/';
    var $destinop = 'uploads/p/';
    var $legenda;
    var $uid;
    
    //método para subir o arquivo para o servidor
    public function uploadArquivo() {
      $this->nome = $this->nomeRandomico().'.'.substr($this->nome, -3,3);
      if(move_uploaded_file($this->tmp_name, $this->destinop.$this->nome)) {
        $this->redimensiona();
        $this->make_thumb($this->destinop.$this->nome, $this->destinot.$this->nome, 200);
        $this->inserirBD();
      }
    }
    
    //método para redimensionar a imagem
    public function redimensiona() {
          
      $img = $this->nome; 
      // recupera tamanho da imagem e tipo
      // http://br3.php.net/manual/pt_BR/function.getimagesize.php
      list($larguraOriginal, $alturaOriginal, $type) = getimagesize($this->destinop.$img);
      // faz checagem se a redimensão será via largura ou altura
      if ($this->largura && ($larguraOriginal < $alturaOriginal)) {
        $this->largura = ($this->altura / $alturaOriginal) * $larguraOriginal;
      } else {
        $this->altura = ($this->largura / $larguraOriginal) * $alturaOriginal;
      }
      // cria imagem com as dimensoes especificadas por parametro
      // http://www.php.net/manual/pt_BR/function.imagecreatetruecolor.php
      $novaImagem = imagecreatetruecolor($this->largura, $this->altura);
      // cria imagem JPEG
      // http://br3.php.net/manual/pt_BR/function.imagecreatefromjpeg.php
      $image = imagecreatefromjpeg($this->destinop.$img);
      // http://br3.php.net/manual/pt_BR/function.imagecopyresampled.php
      imagecopyresampled($novaImagem, $image, 0, 0, 0, 0, $this->largura, $this->altura, $larguraOriginal, $alturaOriginal);
      // http://br3.php.net/manual/pt_BR/function.imagejpeg.php
      imagejpeg($novaImagem, $this->destinop.$img, 100);
    }
    
    
    //método para gerar um nome randomico para o arquivo
    public function nomeRandomico() {
      $novoNome = "";
      for($i=0; $i<20; $i++) {
        $novoNome .= rand(0,9); 
      }
      return $novoNome;
    }





public function make_thumb($src, $dest, $desired_width) {

  /* read the source image */
  $source_image = imagecreatefromjpeg($src);
  $width = imagesx($source_image);
  $height = imagesy($source_image);
  
  /* find the "desired height" of this thumbnail, relative to the desired width  */
  $desired_height = floor($height * ($desired_width / $width));
  
  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
  
  /* copy source image at a resized size */
  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
  
  /* create the physical thumbnail image to its destination */
  imagejpeg($virtual_image, $dest);
}

  


  public function inserirBD(){
    $banco = new db();
    $insertrow = $banco->insertRegistro("INSERT INTO fotos (nm_foto, nm_legenda, cd_uid, dt_postada) VALUES (?, ?,?,?)", array($this->nome, $this->legenda, $this->uid, date('y-m-d'))) ;



  }
 }
?>


