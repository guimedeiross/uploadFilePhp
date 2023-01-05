<?php

require_once __DIR__.'/Upload.php';

define("DIR_ARQUIVOS", "/files");

if(isset($_FILES['arquivo'])){
	$obUpload = new Upload($_FILES['arquivo']);
	
	$success = $obUpload->upload(__DIR__.DIR_ARQUIVOS);
	if($success){
		$linkArquivo = 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER['SERVER_PORT'].DIR_ARQUIVOS.'/'.$obUpload->getBasename();
		echo 'Arquivo <strong>'.$obUpload->getBasename().'</strong> enviado com sucesso<br>';
		echo 'Link para arquivo: <a href='.$linkArquivo.'>'.$linkArquivo.'</a>';
		
		exit;
	} else {
		die('Problemas ao Enviar o arquivo');
	}
}

include __DIR__.'/formulario.php';