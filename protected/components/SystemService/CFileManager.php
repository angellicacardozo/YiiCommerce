<?php
/**
 * Componente respons�vel pela ger�ncia das tarefas relacionadas ao tratamento de arquivos e diret�rios
 * 	- Entrada e sa�da (aloca��o) de arquivos (upload e download de arquivos diversos) 
 * @author Angellica
 *
 */
class CFileManager extends CApplicationComponent
{
	public $upload_path;
	public $file_name;
	public $keep_original_image_file= true;
	
	/**
	 * Um array composto das informacoes para cada instancia da imagem
	 * array(TAMANHO MAIOR, TAMANHO MENOR, QUALIDADE, PREFIXO)
	 * @var array
	 */
	public $image_crop_configuration= array();
	
	public function init()
	{
		parent::init();
	}
	
	/**
	 * Retorna o caminho real de um arquivo caso ele exista
	 * @param string $fileName
	 * @param string $path
	 * @param string $width
	 * @return string Caminho real so arquivo ou NULL caso o arquivo n�o exista
	 */
	public function findFile($fileName, $path, $width=null)
	{
		$prefix= null;
		if(!is_null($width))
			$prefix= $this->getPrefix($width);
			
		$fileName= $this->normalize($fileName);
		
		$file= $this->upload_path."/{$path}/{$prefix}{$fileName}";
		Yii::log("CApiFileManager ::: Buscando arquivo {$file} ");
		
		if(file_exists($file))
		{
			return $file;
		}
		
		return NULL;
	}
	
	public function getPrefix($width, $height= NULL)
	{
		foreach($this->image_crop_configuration as $configuration)
		{
			if($configuration['width']== $width)
			{
				return $configuration['prefix'];
			}
		}
	}
	
	/**
	 * Salva um arquivo dentro da pasta espec�fica
	 * @param $file
	 * @param $file_name
	 * @param $directory
	 * @return boolean
	 */
	public function upload(CUploadedFile $file, $file_name= NULL, $directory= NULL)
	{
		/**
		 * Para cada item do array de configura��o de corte
		 * o m�todo tratar� a imagem como configurado
		 */
		try {
			Yii::log("CApiFileManager ::: INICIANDO O ARMAZENAMENTO DO ARQUIVO ");
			if(!is_dir($this->upload_path))
			{
				$const_path= ABSOLUTE_PATH_UPLOAD;
				throw new CHttpException(500, "O diret�rio de upload de arquivo � inv�lido {$const_path} | {$this->upload_path}");
			}
			
			$caminho= $this->upload_path;
			
			if(!is_null($directory))
			{
				// $array_directory= explode('/', $directory);
				
				// @todo Testar c�digo abaixo para garantir integridade das pastas
				/**
				 * foreach($array_directory as $dir_name)
				 * 		$dir_name= normalize($dir_name)
				 * 
				 * $directory= implode('/', $array_directory);
				 */
				
				/*
				 * Verificar se o diret�rio n�o existe: Caso n�o exista, criar este diret�rio
				 */
				if(!is_dir("$caminho/{$directory}/"))
				{
					$novo_caminho= @mkdir("$caminho/{$directory}/", 0777, true);
					if(!$novo_caminho)
					{
						throw new Exception("Falha ao criar diretorio $caminho/$directory/");
					}
					
					$caminho= "$caminho/{$directory}/";
				}
				// Caso o diret�rio j� exista, somente informar o path
				else {
					$caminho= "$caminho/{$directory}/";
				}
			}
			
			// Atualizar a variavel com o novo caminho de upload
			$this->upload_path= $caminho;
			if(is_null($file_name))
			{
				$nome_do_arquivo= $this->getNewFileName($file);
			}
			else
			{
				$nome_do_arquivo= $this->normalize($file_name);
			}
			
			$caminho_para_salvar_arquivo= "{$caminho}/{$nome_do_arquivo}";
			if(!$file->saveAs($caminho_para_salvar_arquivo))
			{
				throw new Exception("Falha ao salvar arquivo como {$caminho}/{$nome_do_arquivo}");
			}
			
			// A rotina abaixo deve ser realizada somente em casos de imagem
			if(in_array($file->getType(), array("image/gif", "image/png", "image/bmp", "image/jpeg", "image/tiff")))
			{
				Yii::import("application.components.SystemService.lib.*");
				foreach($this->image_crop_configuration as $crop_configuration)
				{
					$thumb=new imageUpload("{$caminho}/{$nome_do_arquivo}");
					if(array_key_exists("width", $crop_configuration))
					{
						$thumb->size_auto($crop_configuration["width"]);
					}
					
					$thumb->jpeg_quality($crop_configuration["quality"]);
					$thumb->save("{$caminho}/{$crop_configuration['prefix']}{$nome_do_arquivo}");
					Yii::log("CApiFileManager ::: O arquivo {$crop_configuration['prefix']}{$nome_do_arquivo} foi mantido no disco");
				}
				
				if(!$this->keep_original_image_file)
				{
					// A imagem original deve ser removida ap�s os cortes serem executados
					$this->delete($nome_do_arquivo, $directory);
				}
			}
			else
			{
				Yii::log("CApiFileManager ::: O arquivo nao possui um tipo permitido");
			}
		}
		catch (Exception $e)
		{
			Yii::log("CApiFileManager ::: {$e->getMessage()} ");
			return false;
		}
		
		$this->file_name= $nome_do_arquivo;
		
		return true;
	}
	
	/**
	 * Remove o arquivo de uma pasta espec�fica
	 * Enter description here ...
	 * @param $path
	 */
	public function delete($file_name, $directory=NULL)
	{
		if(!is_dir($this->upload_path))
		{
			throw new CHttpException(500, "O diret�rio de upload de arquivo � inv�lido");
		}
		
		$caminho= $this->upload_path;
		if(!is_null($directory))
		{
			if(is_dir("$caminho\\{$directory}\\"))
			{
				$caminho= "$caminho\\{$directory}\\";
			}
		}
		
		$dir= realpath("$caminho");
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		           if(trim($file)==trim($file_name))
		           {
		           		return unlink($caminho."/".$file);
		           }
		        }
		        closedir($dh);
		    }
		}	
		
		return false;
	}
	
	public function clearDirectoryFrom($file_name, $directory)
	{
		$retorno= false;
		
		if(!is_dir($this->upload_path))
		{
			throw new CHttpException(500, "O diret�rio de upload de arquivo � inv�lido");
		}
		
		$caminho= $this->upload_path;
		if(!is_null($directory))
		{
			if(is_dir("$caminho\\{$directory}\\"))
			{
				$caminho= "$caminho\\{$directory}\\";
			}
		}

		// Monta array com os nomes dos arquivos a serem removidos
		$array_image_names= array();
		$array_image_names[]= trim($file_name);
		foreach($this->image_crop_configuration as $crop_configuration)
		{
			$array_image_names[]= trim($crop_configuration['prefix'].$file_name);
		}
		
		$dir= realpath("$caminho");
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		    	// Percorre os arquivos de um diret�rio
		        while (($file = readdir($dh)) !== false) {
		           if(in_array(trim($file), $array_image_names))
		           {
		           		Yii::log("CApiFileManager ::: LIMPANDO O DIRETORIO {$caminho}/{$file}");
		           		$retorno= unlink($caminho."/".$file);
		           }
		        }
		        closedir($dh);
		    }
		}	
		
		return $retorno;
	}
	
	protected function getNewFileName(CUploadedFile $file)
	{
		return time().".{$file->extensionName}";
	}
	
	public function normalize($filename)
	{
		return strtolower(preg_replace("/[^a-zA-Z0-9s.]/", "_", $filename));
	}
	
	public function advancedRemoveDirectory($path)
	{
	
		$origipath = $path;
		$handler = opendir($path);
		while (true) {
			$item = readdir($handler);
			if ($item == "." or $item == "..") {
				continue;
			} elseif (gettype($item) == "boolean") {
				closedir($handler);
				if (!rmdir($path)) {
					return false;
				}
				if ($path == $origipath) {
					break;
				}
				$path = substr($path, 0, strrpos($path, "/"));
				$handler = opendir($path);
			} elseif (is_dir($path."/".$item)) {
				closedir($handler);
				$path = $path."/".$item;
				$handler = opendir($path);
			} else {
				unlink($path."/".$item);
			}
		}
		return true;
	}
}