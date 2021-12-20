<?php
	$local_python = "C:\\Users\\Wagner\\AppData\\Local\\Programs\\Python\\Python39\\python.exe ";
	$local_script_python = "c:\\Apache24\\htdocs\\imobiliaria\\python\\";
	$nome_script_python = "test.py";
	$comando = escapeshellcmd($local_python.$local_script_python.$nome_script_python);	
    $resultado = shell_exec($comando);
    echo $resultado;
?>