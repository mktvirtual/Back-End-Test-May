<?php
$id = $_GET['id'];
//$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

//if ((($_FILES["file"]["type"] == "image/gif")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/jpg")
//|| ($_FILES["file"]["type"] == "image/pjpeg")
//|| ($_FILES["file"]["type"] == "image/x-png")
//|| ($_FILES["file"]["type"] == "image/png"))
//&& ($_FILES["file"]["size"] < 20000)
//&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Código de erro: " . $_FILES["file"]["error"] . "<br>";
  } else {
  	
  	$name = md5(uniqid(rand(),true));

    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Tipe: " . $_FILES["file"]["type"] . "<br>";
    echo "Tamanho do arquivo: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Arquivo temporário: " . $_FILES["file"]["tmp_name"] . "<br>";
    if (file_exists("usersPhotos/" . $id . "/" . $_FILES["file"]["name"])) {
    	echo $_FILES["file"]["name"] . " already exists. ";
    } else {
    	move_uploaded_file($_FILES["file"]["tmp_name"], "usersPhotos/" . $id . "/" . $name . "." . $extension);
    	echo "Stored in: usersPhotos/" . $id . "/" . $_FILES["file"]["name"];

    //redimensionar
    $filename = "usersPhotos/" . $id . "/" . $name . "." . $extension;
    $filename_thumb = "usersPhotos/" . $id . "/" . $name . "-thumb." . $extension;
    //$percent = 0.5;
    echo $filename;
	// Content type
	header('Content-Type: image/jpeg');

	// Get new dimensions
	list($width, $height) = getimagesize($filename);
	$new_width = '250px';
	$new_height = '250px';

	// Resample
	$image_p = imagecreatetruecolor($new_width, $new_height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	// Output
	imagejpeg($image_p, $filename_thumb, 100);

    }
  }
//} else {
  //echo "Invalid file";
//}
?>