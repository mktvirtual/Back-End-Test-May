<?php

$id = $_GET['id'];

if(!is_dir('usersPhotos/'.$id)){
	mkdir('usersPhotos/'.$id.'/', 0777, true);
	echo json_encode(array("message" => "No photos", "success" => true));
}else{
	if (count(glob("usersPhotos/".$id."/*-thumb.jpg")) === 0 ) {
		echo json_encode(array("message" => "No photos", "success" => true));
	}else{
		if ($dh = opendir('usersPhotos/'.$id)) {
        $images = array();

        while (($file = readdir($dh)) !== false) {
            if (!is_dir('usersPhotos/'.$id.'/'.$file) && strpos($file,"-thumb.jpg")) {
                $images[] = $file;
            }
        }

        closedir($dh);

        echo json_encode(array(
        	'message' => count($images)." imagens encontradas",
        	'content' => $images,
        	'success' => true
        	));
    }
	}
}


?>