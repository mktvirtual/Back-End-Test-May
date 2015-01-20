<?php
namespace mktInstagram\Vendor;

$includedFiles = get_included_files();

require __SITE_PATH . "/model/files.php";

use mktInstagram\Model\Files;
use mktInstagram\DB;

# ========================================================================#
#
#  Author:    Rajani .B
#  Version:	 1.0
#  Date:      07-July-2010
#  Update Date: 19-Jan-2015
#  Purpose:   Resizes and saves image
#  Requires : Requires PHP5, GD library.
#  Usage Example:
#  include("classes/resize_class.php");
#  $resizeObj = new resize('images/cars/large/input.jpg');
#  $resizeObj -> resizeImage(150, 100, 0);
#  $resizeObj -> saveImage('images/cars/large/output.jpg', 100);
#
# ========================================================================#

class Resize extends Files
{
    private $file;
    private $image;
    private $width;
    private $height;
    private $extension;
    private $imageResized;
    private $folders = array("500x500", "300x300", "160x160");

	public function __construct($fileName)
	{
        $this->file = $fileName;
        $extension = strtolower(strrchr($fileName, '.'));
        $this->extension = $extension;

		// *** Open up the file
		$this->image = $this->openImage($fileName);

	    // *** Get width and height
	    $this->width  = imagesx($this->image);
	    $this->height = imagesy($this->image);
	}

	## --------------------------------------------------------

	private function openImage($file)
	{
		// *** Get extension
		$extension = strtolower(strrchr($file, '.'));

		switch ($extension) {
			case '.jpg':
			case '.jpeg':
				$img = @imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = @imagecreatefromgif($file);
				break;
			case '.png':
				$img = @imagecreatefrompng($file);
				break;
			default:
				$img = false;
				break;
		}

		return $img;
	}

	## --------------------------------------------------------

	public function resizeImage($newWidth, $newHeight, $option="auto")
	{
		// *** Get optimal width and height - based on $option
		$optionArray = $this->getDimensions($newWidth, $newHeight, $option);

		$optimalWidth  = ceil($optionArray['optimalWidth']);
		$optimalHeight = $optionArray['optimalHeight'];

		// *** Resample - create image canvas of x, y size
		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

		// *** if option is 'crop', then crop too
		if ($option == 'crop') {
			$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
		}
	}

	## --------------------------------------------------------
	
	private function getDimensions($newWidth, $newHeight, $option)
	{

	   switch ($option)
		{
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
			case 'crop':
				$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	## --------------------------------------------------------

	private function getSizeByFixedHeight($newHeight)
	{
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth)
	{
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	private function getSizeByAuto($newWidth, $newHeight)
	{
		if ($this->height < $this->width)
		// *** Image to be resized is wider (landscape)
		{
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		}
		elseif ($this->height > $this->width)
		// *** Image to be resized is taller (portrait)
		{
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		}
		else
		// *** Image to be resizerd is a square
		{
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				// *** Sqaure being resized to a square
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	## --------------------------------------------------------

	private function getOptimalCrop($newWidth, $newHeight)
	{

		$heightRatio = $this->height / $newHeight;
		$widthRatio  = $this->width /  $newWidth;

		if ($heightRatio < $widthRatio) {
			$optimalRatio = $heightRatio;
		} else {
			$optimalRatio = $widthRatio;
		}

		$optimalHeight = $this->height / $optimalRatio;
		$optimalWidth  = $this->width  / $optimalRatio;

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}

	## --------------------------------------------------------

	private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
	{
		// *** Find center - this will be used for the crop
		$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
		$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

		$crop = $this->imageResized;
		//imagedestroy($this->imageResized);

		// *** Now crop from center to exact requested size
		$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
		imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
	}

	## --------------------------------------------------------

    /**
    * Função adicionada na classe com objetivo de salvar a imagem gerada pelo jCrop.js
    * @param string $savePath : Caminho da onde devemos salvar
    * @param string/int $imageQuality : Qualidade da imagem
    * @param int $x : valor horizontal da imagem cortada
    * @param int $y : valor vertical da imagem cortada
    * @param int $w : largura da imagem cortada
    * @param int $h : altura da imagem cortada
    */
    public function saveCroppedImage($savePath, $imageQuality, $x, $y, $w, $h, $finalName)
    {
        $targ_h = 500;
        if ($this->height < $targ_h) {
            $targ_h = $this->height;
        }

        $targ_w = $w;

        if (empty($imageQuality)) {
            $imageQuality = "100";
        }

        $this->imageResized = imagecreatetruecolor($targ_w, $targ_h);
        imagecopyresampled($this->imageResized, $this->image, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);
        $nomeArquivo = "{$finalName}{$this->extension}";

        $this->prepareFolders($savePath);

        $this->saveImage($savePath."/{$this->folders[0]}/{$nomeArquivo}", $imageQuality);
        
        return $savePath."/{$this->folders[0]}/{$nomeArquivo}";
    }

    public function saveNewFileOnDatabase($user_id, $legenda = "")
    {
        $connection = new DB();
        $columns = array("usuario_id", "vc_legenda");
        $items = array($user_id, $connection->addSlashes($legenda));

        $connection->saveOrUpdate("files", $columns, $items);
        return str_pad($connection->lastInsertId(), 2, "0", STR_PAD_LEFT);
    }

    public function saveOtherSizes($lastPath, $lastPos = 0)
    {
        if (file_exists($lastPath)) {
            // *** Open up the file
            $this->image = $this->openImage($lastPath);

            // *** Get width and height
            $this->width  = imagesx($this->image);
            $this->height = imagesy($this->image);

            $fileName = strtolower(strrchr($lastPath, '/'));

            $newPos = $lastPos+1;
            list($w, $h) = explode("x", $this->folders[$newPos]);

            $savePath = __SITE_PATH . "/assets/datafiles/{$_SESSION['user_id']}/{$this->folders[$newPos]}{$fileName}";

            $this->resizeImage($w, $h, "auto");
            $this->saveImage($savePath, "100");
            $this->destroyImage();

            if (($newPos+1) <= count($this->folders)-1) {
                $this->saveOtherSizes($savePath, $newPos);
                return true;
            }
        }
    }

    private function prepareFolders($savePath)
    {
        if (!empty($this->folders) && is_array($this->folders)) {
            foreach ($this->folders as $item) {
                Files::criarPasta($savePath."/".$item);
            }
        }
    }

	public function saveImage($savePath, $imageQuality="100")
	{
		// *** Get extension
		$extension = strrchr($savePath, '.');
		$extension = strtolower($extension);

		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				}
				break;

			case '.gif':
				if (imagetypes() & IMG_GIF) {
					imagegif($this->imageResized, $savePath);
				}
				break;

			case '.png':
				// *** Scale quality from 0-100 to 0-9
				$scaleQuality = round(($imageQuality/100) * 9);

				// *** Invert quality setting as 0 is best, not 9
				$invertScaleQuality = 9 - $scaleQuality;

				if (imagetypes() & IMG_PNG) {
					 imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}
				break;

			// ... etc

			default:
				// *** No extension - No save.
				break;
		}
	}

    public function destroyImage()
    {
        imagedestroy($this->imageResized);
    }
}
