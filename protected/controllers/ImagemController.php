<?php
class ImagemController extends Controller
{
	public function actionShow()
	{
		$nome_da_pasta= $_GET['path'];
		$arquivo= $_GET['file'];
		$largura= $_GET['width'];
		
		$path= Yii::app()->fileManager->findFile($arquivo, $nome_da_pasta, $largura);

		if(!is_null($path))
		{
			    $info =  getimagesize($path);
	   			$mime =  image_type_to_mime_type($info[2]);
				
			    switch($mime)
			    {
			    	case "image/jpeg":
			    		$image = imagecreatefromjpeg($path);
			    		header("Content-Type: image/jpeg");
						imagejpeg($image);
			    		break;
			    	case "image/png":
			    		$image = imagecreatefrompng($path);
			    		header("Content-Type: image/png");
						imagepng($image);
			    		break;
			    	case "image/gif":
			    		$image = imagecreatefromgif($path);
			    		header("Content-Type: image/gif");
						imagegif($image);
			    		break;
			    } 
		}
		
	}
}