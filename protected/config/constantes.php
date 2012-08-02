<?php

/**
 * As constantes abaixo definem os caminhos de upload de arquivo
 */

define("PATH_UPLOAD",     "/upload/");
define("ABSOLUTE_PATH_UPLOAD", realpath('./').'/upload');

define("DEFAULT_IMG_PATH", "images");
define("ABSOLUTE_IMAGE_PATH", realpath(dirname(DEFAULT_IMG_PATH)."/".DEFAULT_IMG_PATH));

define("PATH_UPLOAD_IMAGEM",     "/upload/images/");
define("ABSOLUTE_PATH_UPLOAD_IMAGEM", realpath(dirname(DEFAULT_IMG_PATH).PATH_UPLOAD_IMAGEM));

define("PATH_UPLOAD_ANEXOS",     "/upload/anexos_diversos/");
define("ABSOLUTE_PATH_UPLOAD_ANEXOS", realpath(dirname(DEFAULT_IMG_PATH).PATH_UPLOAD_ANEXOS));

define("DIRETORIO_PROTECTED","/protected/");
define("ABSOLUTE_DIRETORIO_PROTECTED", realpath(dirname(DIRETORIO_PROTECTED)."/".DIRETORIO_PROTECTED));

define("DIRETORIO_APLICACAO","/portal/");
define("ABSOLUTE_DIRETORIO_APLICACAO",realpath(dirname('../'.DIRETORIO_APLICACAO)."/".DIRETORIO_APLICACAO));