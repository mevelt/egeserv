<?php
require "vendor/autoload.php";
use mehmetbeyHZ\SSH;

$username = "";
$password = "";

$ssh = new SSH("sorubank2.ege.edu.tr",$username,$password);


$files = scanAllDir(realpath('.').'/ege_server');

foreach ($files as $file)
{
    $file_content = file_get_contents( realpath('.').'/ege_server/'.$file);
    $file_content = preg_replace("/\n+/",'\n',$file_content);
    $stream = $ssh->command("echo '{$file_content}' > {$file} ");
    print_r($stream->getOutputStream());
}

