<?php
if (is_null($_GET['width'])) $_GET['width'] = 250;
if (is_null($_GET['height'])) $_GET['height'] = 250;


thumb($_GET['arquivo'],$_GET['width'],$_GET['height'], $_GET['path']);
function thumb ($arquivo,$maxwidth,$maxheight) 
{
	
	$path ='arquivos/';
	if(!file_exists($path . $arquivo) || trim($arquivo)==""){
		$path = "arquivos/";
		$arquivo="bullet.gif";
	}
	if (stristr($arquivo,'jpg')) $srcimage = imagecreatefromjpeg($path.$arquivo);
	if (stristr($arquivo,'jpeg')) $srcimage = imagecreatefromjpeg($path.$arquivo);	
	if (stristr($arquivo,'gif')) $srcimage = imagecreatefromgif($path.$arquivo);
	if (stristr($arquivo,'png')) $srcimage = imagecreatefrompng($path.$arquivo);
	
	$srcW = ImagesX($srcimage);
	$srcH = ImagesY($srcimage);
	$wdiff = $srcW - $maxwidth;
	$hdiff = $srcH - $maxheight;
	
	if ($wdiff > $hdiff) {
	 $newW = $maxwidth;
	  $aspect = ($newW/$srcW);
	  $newH = (int)($srcH * $aspect);
	} else {
	  $newH = $maxheight;
	  $aspect = ($newH/$srcH);
	  $newW = (int)($srcW * $aspect);
	}
	
	//$newimage = imagecreatetruecolor($newW,$newH);
	//$newimage = imagecreate($newW,$newH);
	
	//ImageCopyResampled($newimage,$srcimage,0,0,0,0,$newW,$newH,$srcW,$srcH);
	
	if (stristr($arquivo,'jpg') or stristr($arquivo,'jpeg')) {		
		$newimage = imagecreatetruecolor($newW,$newH);
		
		ImageCopyResampled($newimage,$srcimage,0,0,0,0,$newW,$newH,$srcW,$srcH);
		
		header("Content-type:image/jpeg");
		imagejpeg($newimage);
	}
	
	if (stristr($arquivo,'gif')) {
		$newimage = imagecreate($newW,$newH);
	
		//background Transparente
		setTransparency($newimage, $srcimage);
		
		ImageCopyResampled($newimage,$srcimage,0,0,0,0,$newW,$newH,$srcW,$srcH);
		
		header("Content-type:image/gif");	
		imagegif($newimage);
	}
	
	if (stristr($arquivo,'png')) {
		$newimage = imagecreatetruecolor($newW,$newH);
		
		//Transparente Background
		imagesavealpha($newimage, true);
	    $trans_colour = imagecolorallocatealpha($newimage, 0, 0, 0, 127);
	    imagefill($newimage, 0, 0, $trans_colour);
	    //------------

		ImageCopyResampled($newimage,$srcimage,0,0,0,0,$newW,$newH,$srcW,$srcH);
		
		header("Content-type:image/png");	
		imagepng($newimage);
	}
	
	imagedestroy($newimage);
}
function setTransparency($new_image,$image_source)
{
	$transparencyIndex = imagecolortransparent($image_source);
	$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
	
	if ($transparencyIndex >= 0) 
	{
		$transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);
	}

	$transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
	imagefill($new_image, 0, 0, $transparencyIndex);
	imagecolortransparent($new_image, $transparencyIndex);
}
?>